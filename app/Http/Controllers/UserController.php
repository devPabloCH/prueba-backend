<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Obtener datos del usuario en sesión
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request){
        $user = $request->user();
        return response()->json([
            'message' => 'Obtener usuario en sesión OK',
            'user' => $user
        ]);
    }

    /**
     * Obtener listado de usuario con rol corredor
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRunners(){
        try{
            $runners = User::where('role_id', 2)->get();
            return response()->json([
                'runners' => $runners,
                'status' => 1,
                'message' => 'Runners getted succesfully'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request){
        try{
            $data = $request['form'];
            $user = new User();
            $user->full_name = $data['full_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role_id = $data['role_id'];

            if($data['avatar']){
                $carpeta_imagen = "avatars";
                $image_64 = $data['avatar'];
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = \Illuminate\Support\Str::random(25) . '.' . $extension;
                if (!file_exists(public_path($carpeta_imagen))) {
                    mkdir(public_path($carpeta_imagen), 0777, true);
                }
                $path = "{$carpeta_imagen}/{$imageName}";
                Storage::disk('public')->put($path, base64_decode($image));
                $image_resized = Image::make(Storage::get($path));
                $image_resized->resize(270, 480, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::put($path, $image_resized->encode('png'));

                $user->avatar = $path;
            }

            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'User added success'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Actualizar datos de usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $id){
        try{
            $data = $request['form'];
            $user = User::find($id);
            $user->full_name = $data['full_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->role_id = $data['role_id'];

            if ($data['avatar'] != null && !filter_var($data['avatar'], FILTER_VALIDATE_URL)) {
                $carpeta_imagen = "avatars";
                $image_64 = $data['avatar'];
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = \Illuminate\Support\Str::random(25) . '.' . $extension;
                if (!file_exists(public_path($carpeta_imagen))) {
                    mkdir(public_path($carpeta_imagen), 0777, true);
                }
                $path = "{$carpeta_imagen}/{$imageName}";
                Storage::disk('public')->put($path, base64_decode($image));
                $image_resized = Image::make(Storage::get($path));
                $image_resized->resize(270, 480, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                Storage::put($path, $image_resized->encode('png'));

                $user->avatar = $path;
            }

            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'User added success'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Eliminar usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id){
        try{
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'status' => 1,
                'message' => 'User deleted sucessfully'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
