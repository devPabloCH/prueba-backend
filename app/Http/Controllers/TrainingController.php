<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingReport;
use Exception;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Obtener todos los entrenamientos registrados
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrainings(){
        try{
            $trainings = Training::with('trainingReport.training', 'trainingReport.user')->get();

            return response()->json([
                'status' => 1,
                'trainings' => $trainings,
                'message' => 'Trainings successfully'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 0,
                'trainings' => [],
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Registrar nuevo entrenamiento
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTraining(Request $request){
            $training = new Training();
            $training->name = $request->name;
            $training->start_time = $request->start_time;
            $training->recurrence = $request->recurrence;
            $training->save();

            foreach($request->runners as $runner){
                $training_report = new TrainingReport();
                $training_report->training_id = $training->id;
                $training_report->user_id = $runner;
                $training_report->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'Training added successfully'
            ], 200);

    }

    /**
     * Actualizar los datos de un entrenamiento y sus corredores
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTraining(Request $request, $id){
        try{
            $training = Training::find($id);
            $training->name = $request->name;
            $training->start_time = $request->start_time;
            $training->recurrence = $request->recurrence;
            $training->save();

            $current_runners = $training->trainingReport()->pluck('user_id')->toArray();
            $new_runners = $request->runners;

            // Comparo los arrays para quedarme con los no coincidentes en comparación con new_runners y current_runners
            $runners_add = array_diff($new_runners, $current_runners);
            $runners_delete = array_diff($current_runners, $new_runners);

            foreach($runners_delete as $runner){
                $training->trainingReport()->where('user_id', $runner)->delete();
            }

            foreach($runners_add as $runner){
                $training_report = new TrainingReport();
                $training_report->training_id = $training->id;
                $training_report->user_id = $runner;
                $training_report->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'Training updated successfully'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar datos de entrenamiento
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTraining($id){
        try{
            $training = Training::find($id);

            $training->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Training deleted successfully'
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
