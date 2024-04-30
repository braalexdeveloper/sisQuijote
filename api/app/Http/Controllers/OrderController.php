<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $orders=Order::all();
            return response()->json(["orders"=>$orders],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage()],500);
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
        try{

            $reglas=[
                'total'=>'required|numeric',
                'client_id'=>'required'
            ];
            
            $validate=Validator::make($request->all(),$reglas);
            if($validate->fails()){
                return response()->json(["error"=>$validate->errors()],400);
            }

            $order=Order::create([
                'total'=>$request->total,
                'client_id'=>$request->client_id
            ]);

            foreach($request->details as $detail){
                Order_detail::create([
                    'quantity'=>$detail['quantity'],
                    'subtotal'=>$detail['subtotal'],
                    'order_id'=>$order->id,
                    'book_id'=>$detail['book_id']
                ]);
            }

            

            return response()->json(["message"=>"Venta creada correctamente!","order"=>$order],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{

            $order=Order::with('client','order_details.book')->find($id);
            if(!$order){
                return response()->json(["error"=>"No existe la orden"],404);
            }
            return response()->json(["order"=>$order],200);
        }catch(\Exception $e){
           return response()->json(["error"=>$e->getMessage()],500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
