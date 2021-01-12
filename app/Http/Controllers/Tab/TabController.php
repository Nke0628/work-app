<?php

namespace App\Http\Controllers\Tab;

use App\Http\Controllers\Controller;
use \Illuminate\View\View;

class TabController extends Controller
{
    /**
     * トップページ表示
     *
     * @return View
     */
    public function index(): View
    {
        return view('tab.tab');
    }
}
