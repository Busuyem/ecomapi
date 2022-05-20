<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $categories = ProductCategory::with('products')->get();
            return response()->json([
                'status' => 200,
                'message' => 'Categories created successfully!',
                'data' => CategoryResource::collection($categories)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status' => 422,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $categoryData = $request->validated();

        try{
            $createdCategoryData = ProductCategory::create($categoryData);
            return response()->json([
                'status_code' => 201,
                'message' => 'Category created successfully',
                'data' => new CategoryResource($createdCategoryData)
            ]);

        }catch(Throwable $e){
           response()->json([
            'status_code' => 500,
            'message' => 'Failed to create category',
            'data' => $e->getMessage()
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
            $findCategoryById = ProductCategory::find($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'Success!',
                'data' => new CategoryResource($findCategoryById)
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message' => 'Not found'
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
    public function update(CategoryRequest $request, $id)
    {

        try{
            $categoryData = $request->validated();
            $findCategoryById = ProductCategory::find($id);
            $findCategoryById->update($categoryData);
            return response()->json([
                'status_code' => 201,
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($findCategoryById)
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 200,
                'message' => 500,
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
            $findCategoryById = ProductCategory::find($id);
            $findCategoryById->delete();
            return response()->json([
                'status_code' => 201,
                'message' => 'Category deleted successfully.'
            ]);

        }catch(Throwable $e){
            return response()->json([
                'status_code' => 404,
                'message' => 'Not found',
                'error' => $e->getMessage()
            ]);
        }
    }
}
