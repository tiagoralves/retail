<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadReportOverview()
    {
        return view('reports.report_overview');
    }


}