<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $allCartsItems = CartItem::with('product')->get();
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
                'data' => CartResource::collection($allCartsItems)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message' => 'failure',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        try{
            $validateCartData = $request->validated();
            $createdCartData = CartItem::create($validateCartData);
            //$cartProducts = Product::where('id', request()->product_id)->get();
            return response()->json([
                'status_code' => 200,
                'message' => 'Cart successfully added',
                'data' => new CartResource($createdCartData)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 500,
                'message' => 'Cart cannot be created',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $findCartItemById = CartItem::findOrFail($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
                'data' => new CartResource($findCartItemById)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message' => 'Not found',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, $id)
    {
        try{
            $validateCartData = $request->validated();
            $findCartItemById = CartItem::findOrFail($id);
            $findCartItemById->update($validateCartData);
            return response()->json([
                'status_code' => 201,
                'message' => 'Cart item updated successfully.',
                'data' => new CartResource($findCartItemById)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 500,
                'message' => 'failure',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $findCartItemById = CartItem::findOrFail($id);
            $findCartItemById->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'cart removed successfully',
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => 'Failure',
                'error' => $e->getMessage()
            ]);
        }
    }
}
