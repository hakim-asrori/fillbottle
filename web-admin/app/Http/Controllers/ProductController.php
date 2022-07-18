<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nette\Utils\DateTime;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('nama', 'ASC');
        $this->data['products'] = $products->paginate(10);
        return view('admin.product.index', $this->data);
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

        $partners = Partner::orderBy('nama', 'ASC')->get();
        $this->data['partners'] = $partners->toArray();
        $this->data['partnerID'] = null;

        $this->data['product'] = null;
        $this->data['productID'] = 0;
        $this->data['categoryIDs'] = [];

        return view('admin.product.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $params = $request->except('_token');

            if ($request->has('foto')) {
                $dt = new DateTime();

                $path = public_path('uploads/images/' . $dt->format('Y-m-d'));
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file = $request->file('foto');
                $name =  Str::slug($params['nama']) . '_' . time();
                $fileName = $name . '.' . $file->getClientOriginalExtension();
                $folder = '/uploads/images/' . $dt->format('Y-m-d');
                $filePath = $file->storeAs($folder, $fileName, 'public');
                $params['foto'] = $filePath;
            }

            $saved = false;
            $saved = DB::transaction(function () use ($params) {
                $product = Product::create($params);
                $product->categories()->sync($params['category_ids']);
                return true;
            });

            if ($saved) {
                Session::flash('success', 'Product has been saved');
            } else {
                Session::flash('error', 'Product could not be saved');
            }
        } catch (QueryException $e) {
            Session::flash('error', "Product could not be saved : SQL Error");
        }
        return redirect('admin/product');
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
        if (empty($id)) {
            return redirect('admin.product.create');
        }

        $product = Product::findOrFail($id);
        $categories = Category::orderBy('nama', 'ASC')->get();
        $partners = Partner::orderBy('nama', 'ASC')->get();

        $this->data['partners'] = $partners->toArray();
        $this->data['partnerID'] = $product->partner_id;

        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = $product;
        $this->data['productID'] = $product->id;
        $this->data['categoryIDs'] = $product->categories->pluck('id')->toArray();

        return view('admin.product.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $params = $request->except('_token');
        if ($request->has('foto')) {
            $dt = new DateTime();
            $path = public_path('uploads/images/' . $dt->format('Y-m-d'));
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file = $request->file('foto');
            $name =  Str::slug($params['nama']) . '_' . time();
            $fileName = $name . '.' . $file->getClientOriginalExtension();
            $folder = '/uploads/images/' . $dt->format('Y-m-d');
            $filePath = $file->storeAs($folder, $fileName, 'public');
            $params['foto'] = $filePath;
        } else {
            $params = $request->except('foto');
        }

        $product = Product::findOrFail($id);
        $saved = false;
        $saved = DB::transaction(function () use ($product, $params) {
            $product->update($params);
            $product->categories()->sync($params['category_ids']);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Product has been updated');
        } else {
            Session::flash('error', 'Product could not be update');
        }

        return redirect('admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->delete()) {
            Session::flash('success', 'Product has been delete');
        }
        return redirect('admin/product');
    }
}
