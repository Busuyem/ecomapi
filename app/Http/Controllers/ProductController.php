<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\ProductCategory;
use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $allProducts = Product::with('category')->orderBy('created_at', 'DESC')->get();
            return response()->json([
                'status_code' => 200,
                'message' => 'Success!',
                'data' => ProductResource::collection($allProducts)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status_code'=>200,
                'message'=> 'No product available yet',
                'data'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validatedProductData = $request->validated();

        try{
            if(request()->hasFile('image')){
                $name = 'image_'.time().'.'.request()->image->getClientOriginalName();
                $storedImagePath = request()->file('image')->storeAs('public/images', $name);
                $validatedProductData['image'] = $name;
            }

            $createdProductData = Product::create($validatedProductData);

            return response()->json([
                'status_code' => 200,
                'message' => 'Your product has been saved successfully',
                'data' => new ProductResource($createdProductData)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 422,
                'message' => $e->getMessage()
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
            $findProductById = Product::findOrFail($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'Success!',
                'data' => new ProductResource($findProductById)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message' => 'Not found',
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
    public function update(ProductRequest $request, $id)
    {
        try{
            $validatedProductData = $request->validated();
            $findProductById = Product::findOrFail($id);
            if(request()->hasFile('image')){
                $name = 'image_'.time().'.'.request()->image->getClientOriginalName();
                $storedImagePath = request()->file('image')->storeAs('public/images', $name);
                $validatedProductData['image'] = $name;
            }

            $findProductById->update($validatedProductData);
            return response()->json([
                'status_code' => 201,
                'message' => 'Product updated successfully.',
                'data' => new ProductResource($findProductById)
            ]);

        }catch(Throwable $e){
           return response()->json([
                'status_code' => 500,
                'message' => 'Product update failed',
                'data' => $e->getMessage()
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
            $findProductById = Product::findOrFail($id);
            $findProductById->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Product deleted successfully'
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message'=> 'Product not found'
            ]);
        }
    }
}
