<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::with('user_c', 'user_u', 'course')->get();
        return $this->sendResponse(CategoryResource::collection($category), 'Category Retrieve Successfully');
    }

    public function popularCategory()
    {
        $populars = Category::with('course')->withCount('course')->orderby('course_count', 'desc')->take(5)->get();
        return $this->sendResponse(CategoryResource::collection($populars), 'popular category retrieved');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $request['created_by'] = auth()->user()->id;
        $data = $request->all();
        $category = Category::create($data);
        if ($category) {
            return $this->sendResponse(new CategoryResource($category), 'category created', 201);
        }
        return $this->sendError('category create failed', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $this->sendResponse(new CategoryResource($category), 'category detail retrieved');
        }
        return $this->sendError('category not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $request['updated_by'] = auth()->user()->id;
        $data = $request->all();
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
            return $this->sendResponse(new CategoryResource($category), 'category updated');
        }
        return $this->sendError('category not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->sendResponse(new CategoryResource($category), 'category deleted');
        }
        return $this->sendError('category not found');
    }
}
