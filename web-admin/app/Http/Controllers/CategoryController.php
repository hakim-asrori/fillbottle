<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('nama', 'ASC');
        $this->data['categories'] = $categories->paginate(10);
        return view('admin.category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $this->data['categories'] = $categories->toArray();
        $this->data['category'] = null;
        return view('admin.category.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $params = $request->except('_token');
        $params['parent_id'] = (int) $params['parent_id'];
        if (Category::create($params)) {
            Session::flash('success', 'Category has been saved');
        } else {
            Session::flash('error', 'Category could not be saved');
        }
        return redirect('admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::orderBy('nama', 'ASC')->get();
        $this->data['categories'] = $categories->toArray();
        $this->data['category'] = $category;
        return view('admin.category.form', $this->data);
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
        $params = $request->except('_token');

        $category = Category::findOrFail($id);
        if ($category->update($params)) {
            Session::flash('success', 'Category has been update');
        } else {
            Session::flash('error', 'Category could not be saved');
        }
        return redirect('admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->delete()) {
            Session::flash('success', 'Category has been delete');
        }
        return redirect('admin/category');
    }
}
