<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingReport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TrainingReportController extends Controller
{
    /**
     * Obtener entrenamientos asignados al usuario y sus reportes
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTrainingReports(){
            $training_reports = TrainingReport::where('user_id', Auth::id())->with('training')->get();

            return response()->json([
                'status' => 1,
                'message' => 'Training reports got successfully',
                'training_reports' => $training_reports
            ], 200);
    }

    /**
     * Agregar reporte a entrenamiento previamente asignado a usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUserReport(Request $request){
        try{
            $report = TrainingReport::find($request->training_report_id);
            $report->distance = $request->distance;
            $report->comments = $request->comments;
            $report->is_completed = true;

            $type = $request->type;
            if($type == 'doc'){
                $dir = 'documents';
                $evidence = $request->file('evidence');

                if ($evidence->getClientOriginalExtension() == 'pdf') {
                    $unique_name = uniqid() . '.' . $evidence->getClientOriginalExtension();
                    $path = "{$dir}/{$unique_name}";

                    // Guarda el archivo con el nombre único
                    Storage::disk('public')->put($path, file_get_contents($evidence));
                    $report->evidence = $path;
                    $report->save();
                }
            } else if($type == 'img'){
                $evidence = $request->evidence;
                if($evidence != null){
                    $dir = "images";
                    $image_64 = $evidence;
                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                    $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                    $image = str_replace($replace, '', $image_64);
                    $image = str_replace(' ', '+', $image);
                    $image_name = \Illuminate\Support\Str::random(25) . '.' . $extension;
                    if (!file_exists(public_path($dir))) {
                        mkdir(public_path($dir), 0777, true);
                    }
                    $path = "{$dir}/{$image_name}";
                    Storage::disk('public')->put($path, base64_decode($image));
                    $image_resized = Image::make(Storage::get($path));
                    $image_resized->resize(270, 480, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    Storage::put($path, $image_resized->encode('png'));

                    $report->evidence = $path;
                    $report->save();
                }
            }

            return response()->json([
                'status' => 1,
                'message' => 'Report saved successfully'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 0,
                'message' =>  $e->getMessage()
            ], 500);
        }
    }
}
