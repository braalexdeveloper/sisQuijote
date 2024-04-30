<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=Role::all();

        return response()->json(["roles"=>$roles],200);
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
        if(!$request->name){
            return response()->json(["error"=>"Debe llenar el campo nombre!"],400);
        }

        $role=Role::create($request->all());
        return response()->json(["message"=>"Rol creado correctamente!","role"=>$role],200);
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
        if(!$request->name){
            return response()->json(["error"=>"Debe llenar el campo nombre!"],400);
        }

        
        $role=Role::find($id);
        if(!$role){
            return response()->json(["error"=>"No se encontró el Rol"],404);
        }

        $role->update($request->all());
        return response()->json(["message"=>"Rol actualizado correctamente!","role"=>$role],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::find($id)->delete();
        return response()->json(["message"=>"Rol eliminado correctamente!"],200);
    }
}
