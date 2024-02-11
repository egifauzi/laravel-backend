<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = \App\Models\Category::paginate(5);
        return view('pages.category.index', compact('categories'));
    }


    //create
    public function create()
    {
        return view('pages.category.create');

    }
    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
        ]);
        $categories = \App\Models\Category::create($request->all());
        return redirect()->route('category.index')->with('success', 'Category created successfully.');

}
    //edit
    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));

}
    //update
    public function update(Request $request, $id)
    {
       $validated =  $request->validate([
            'name' => 'required|max:30',
        ]);
        $categories = \App\Models\Category::findOrFail($id);
        // $categories->update($request->all());
        $categories->update($validated);
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');}

//destroy
public function destroy($id)
{
    $categories = \App\Models\Category::findOrFail($id);
    $categories->delete();
    return redirect()->route('category.index')->with('success', 'Category deleted successfully.');}
}
