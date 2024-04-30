<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $clients=Client::all();

            return response()->json(["clients"=>$clients],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage(),500]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
           
            $reglas=[
                'name'=>'required|string',
                'lastName'=>'required|string',
                'dni'=>'required|string'
            ];

            $validate=Validator::make($request->all(),$reglas);

            if($validate->fails()){
             return response()->json(["error"=>$validate->errors()],400);
            }

            $client=Client::create($request->all());

            return response()->json(["message"=>"Cliente creado correctamente!","client"=>$client],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage(),500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

            $client=Client::find($id);

            if(!$client){
                return response()->json(["error"=>"No Existe el cliente"],404);
               }
           
            $reglas=[
                'name'=>'required|string',
                'lastName'=>'required|string',
                'dni'=>'required|string'
            ];

            $validate=Validator::make($request->all(),$reglas);

            if($validate->fails()){
             return response()->json(["error"=>$validate->errors()],400);
            }

            $client->update($request->all());

            return response()->json(["message"=>"Cliente actualizado correctamente!","client"=>$client],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage(),500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
          Client::find($id)->delete();

            return response()->json(["message"=>"Cliente eliminado!"],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage(),500]);
        }
    }
}
