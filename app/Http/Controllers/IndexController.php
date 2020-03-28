<?php

namespace App\Http\Controllers;

use \Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * トップページ表示
     *
     * @return View
     */
    public function index(): View
    {
        return view('index');
    }
}
