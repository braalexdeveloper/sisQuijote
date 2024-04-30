<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
          $categories=Category::all();
          return response()->json(["categories"=>$categories],200);
        }catch(\Exception $e){
            return response()->json(["error" => "Error al listar categorias: " . $e->getMessage()], 500);
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
              'name'=>'required|string'
            ];

            $validate=Validator::make($request->all(),$reglas);

            if($validate->fails()){
                return response()->json(["error"=>$validate->errors()],400);
            }

            $category=Category::create($request->all());
            return response()->json(["message"=>"Categoria creado con Éxito!","category"=>$category],200);
          }catch(\Exception $e){
              return response()->json(["error" => "Error al crear categoria: " . $e->getMessage()], 500);
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

                $reglas=[
                  'name'=>'required|string'
                ];
    
                $validate=Validator::make($request->all(),$reglas);
    
                if($validate->fails()){
                    return response()->json(["error"=>$validate->errors()],400);
                }
    
                $category=Category::find($id);
                $category->update($request->all());

                return response()->json(["message"=>"Categoria actualizada con Éxito!","category"=>$category],200);
              }catch(\Exception $e){
                  return response()->json(["error" => "Error al actualizar categoria: " . $e->getMessage()], 500);
              }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        

            try{

                Category::find($id)->delete();
                return response()->json(["message"=>"Categoria Eliminada con Éxito!"],200);
              }catch(\Exception $e){
                  return response()->json(["error" => "Error al eliminar categoria: " . $e->getMessage()], 500);
              }
    }
}
