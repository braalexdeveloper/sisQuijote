<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        try{
            $users=User::with('role')->get();
            // Modificar la salida JSON para incluir el nombre del rol directamente
        $formattedUsers = $users->map(function ($user) {
            $userData = $user->toArray();
            $userData['roleName'] = $user->role->name; // Agregar el nombre del rol directamente
            unset($userData['role']); // Eliminar el objeto de rol anidado
            return $userData;
        });

            return response()->json(["users"=>$formattedUsers],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage(),500]);
        }
     
    }

    public function store(Request $request){
        try{
           
            $reglas=[
                'name'=>'required|string',
                'email'=>'required|string',
                 'password'=>'required|string',
                 'role_id'=>'required'
               ];

               $validate=Validator::make($request->all(),$reglas);

               if($validate->fails()){
                return response()->json(["error"=>$validate->errors()],400);
               }

               if($request->hasFile('img')){
                 $image=$request->file('img');
                 $fileName=time()."_".$image->getClientOriginalName();
                 $image->storeAs('public/users',$fileName);
                 $request['avatar']=asset('storage/users/'.$fileName);
               }

               $user=User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'avatar' => $request->avatar ?? '', // Mantener la imagen actual si no se proporciona una nueva
                'role_id'=>$request->role_id
            ]);

               // Cargar la relación de rol después de crear el usuario
$user->load('role');

            return response()->json(["message"=>"Usuario creado correctamente!","user"=> [
        "name" => $user->name,
        "email" => $user->email,
        "avatar" => $user->avatar,
        "role_id" => $user->role_id,
        "roleName" => $user->role->name, // Agregar el nombre del rol al objeto del usuario
        "created_at" => $user->created_at,
        "id" => $user->id
    ]],200);
        }catch(\Exception $e){
           return response()->json(["error"=>"Error al crear Usuario : ".$e->getMessage(),500]);
        }
    }

    public function update(Request $request,string $id){
        try{

            $user = User::with('role')->find($id);

            if (!$user) {
                
                return response()->json(['error' => 'El usuario no se encuentra'], 404);
            }
           
            $reglas=[
                'name'=>'required|string',
                'email'=>'required|string',
                //'password'=>'required|string',
                'role_id'=>'required|exists:roles,id',
               ];

               $validate=Validator::make($request->all(),$reglas);

               if($validate->fails()){
                return response()->json(["error"=>$validate->errors()],400);
               }

               if($request->hasFile('img')){

                if($user->avatar && Storage::exists('public/users/'.basename($user->avatar))){
                   Storage::delete('public/users/'.basename($user->avatar));
                }

                 $image=$request->file('img');
                 $fileName=time()."_".$image->getClientOriginalName();
                 $image->storeAs('public/users',$fileName);
                 $request['avatar']=asset('storage/users/'.$fileName);
               }

               $user->update([
                'name' => $request->name,
                'email' => $request->email,
                //'password' => bcrypt($request->password),
                'avatar' => $request->avatar ?? $user->avatar, // Mantener la imagen actual si no se proporciona una nueva
               
            ]);

               if($request->has('role_id')){
                $role=Role::find($request->role_id);
                if($role){
                  $user->role()->associate($role);
                }else{
                  return response()->json(['error' => 'El ID del rol proporcionado no es válido'], 400);
                }
               }

               $user->save(); // Guardar los cambios en la base de datos

            return response()->json(["message"=>"Usuario actualizado correctamente!","user"=>[
        "name" => $user->name,
        "email" => $user->email,
        "avatar" => $user->avatar,
        "role_id" => $user->role_id,
        "roleName" => $user->role->name, // Agregar el nombre del rol al objeto del usuario
        "created_at" => $user->created_at,
        "id" => $user->id
    ]],200);
        }catch(\Exception $e){
           return response()->json(["error"=>"Error al actualizar Usuario : ".$e->getMessage(),500]);
        }
    }

    public function destroy(string $id){
        try {

            User::find($id)->delete();
            return response()->json(["message" => "Usuario eliminado con éxito!"], 200);
         } catch (\Exception $e) {
             return response()->json(["error" => "Error al eliminar Usuario: " . $e->getMessage()], 500);
         }
    }

}
