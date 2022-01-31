<?php

namespace App\Http\Controllers\Common;

use App\Models\Group;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Group $group): View
    {
        return view('common.search.index', compact('group'));
    }
}
