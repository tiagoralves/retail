<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Urlbox\Screenshots\Facades\Urlbox;

class ScreensShotController extends Controller
{

    public function list()
    {
        return view('screenshots.list');
    }


    public function form()
    {
        return view('screenshots.form');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
