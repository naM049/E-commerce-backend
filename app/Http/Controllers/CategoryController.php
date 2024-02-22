<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Category::class, 'category');


    }

    public function index()
    {
//        $this->authorize('viewAny', Category::class);
        return CategoryResource::collection(Category::paginate());
    }

    public function store(CategoryRequest $request)
    {
//        $this->authorize('create', Category::class);
        return new CategoryResource(Category::create($request->validated()));
    }

    public function show(Category $category)
    {
//        $this->authorize('view', $category);
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
//        $this->authorize('update', $category);
        $category->update([
            'name' => $request->name ?? $category->name,
            'description' => $request->description ?? $category->description,
        ]);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
//        $this->authorize('delete', $category);
        $category->delete();

        return response()->json();
    }
}
