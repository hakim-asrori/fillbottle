<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Support\Facades\Session;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branchs = Branch::orderBy('nama', 'ASC');
        $this->data['branchs'] = $branchs->paginate(10);
        return view('admin.branch.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['branch'] = null;
        return view('admin.branch.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        $params = $request->except('_token');
        if (branch::create($params)) {
            Session::flash('success', 'Branch has been saved');
        } else {
            Session::flash('error', 'Branch could not be saved');
        }
        return redirect('admin/branch');
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
        $branch = Branch::findOrFail($id);
        $this->data['branch'] = $branch;
        return view('admin.branch.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
        $params = $request->except('_token');

        $branch = Branch::findOrFail($id);
        if ($branch->update($params)) {
            Session::flash('success', 'Branch has been update');
        } else {
            Session::flash('error', 'Branch could not be saved');
        }
        return redirect('admin/branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        if ($branch->delete()) {
            Session::flash('success', 'Branch has been delete');
        }
        return redirect('admin/branch');
    }
}
