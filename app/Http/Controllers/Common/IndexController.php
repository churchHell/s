<?php

namespace App\Http\Controllers\Common;

use Illuminate\View\View;

class IndexController extends Controller
{
    public function index($group = 0): View
    {
        return view('common.index.index', compact('group'));
    }
}
