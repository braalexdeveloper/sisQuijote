<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $books = Book::with('category')->get();
            return response()->json(["books" => $books], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al listar los libros: " . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $reglas = [
                'code' => 'required|string',
                'title' => 'required|string',
                'description' => 'required|string',
                'autor' => 'required|string',
                'category_id' => 'required'
            ];

            $validate = Validator::make($request->all(), $reglas);

            if ($validate->fails()) {
                return response()->json(["error" => $validate->errors()], 400);
            }

            if ($request->hasFile("img")) {
                $image = $request->file('img');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/products', $filename);
                $request['image'] = asset('storage/products/' . $filename);
            }

            $book = Book::create($request->all());

            return response()->json(["message" => "Libro creado con éxito!", "book" => $book], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al crear libro: " . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $book=Book::find($id);
            return response()->json(["book" => $book], 200);
         } catch (\Exception $e) {
             return response()->json(["error" => "Error al obtener libro: " . $e->getMessage()], 500);
         }
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
         try {
             
             $reglas = [
                 'code' => 'required|string',
                 'title' => 'required|string',
                 'description' => 'required|string',
                 'autor' => 'required|string'
             ];
     
             $validate = Validator::make($request->all(), $reglas);
     
             if ($validate->fails()) {
                 
                 return response()->json(["error" => $validate->errors()], 400);
             }
     
             $book = Book::find($id);
     
             if (!$book) {
                
                 return response()->json(['error' => 'El book no se encuentra'], 404);
             }
     
             if ($request->hasFile("img")) {
                
     
                 if ($book->image && Storage::exists('public/products/' . basename($book->image))) {
                     Storage::delete('public/products/' . basename($book->image));
                 }
     
                 $image = $request->file('img');
                 $filename = time() . '_' . $image->getClientOriginalName();
                 $image->storeAs('public/products', $filename);
                 $request['image'] = asset('storage/products/' . $filename);
             }
     
            
     
             $book->update([
                 'code' => $request->code,
                 'title' => $request->title,
                 'description' => $request->description,
                 'autor' => $request->autor,
                 'image' => $request->image ?? $book->image, // Mantener la imagen actual si no se proporciona una nueva
             ]);
     
             
     
             return response()->json(["message" => "Libro actualizado con éxito!", "book" => $book], 200);
         } catch (\Exception $e) {
             
             return response()->json(["error" => "Error al actualizar libro: " . $e->getMessage()], 500);
         }
     }
         


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

           Book::find($id)->delete();
           return response()->json(["message" => "Libro eliminado con éxito!"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al eliminar libro: " . $e->getMessage()], 500);
        }
    }
}
