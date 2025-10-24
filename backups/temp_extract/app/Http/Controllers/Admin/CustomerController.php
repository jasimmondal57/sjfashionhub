<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customers.index');
    }

    public function create()
    {
        return redirect()->route('admin.customers.index')
            ->with('info', 'Customer management will be available once user authentication is implemented.');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.customers.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.customers.index')
            ->with('info', 'Customer details will be available once user system is implemented.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.customers.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.customers.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.customers.index');
    }
}
