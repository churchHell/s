<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $accountRules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9\+\(\)\-\s]+$/', 'max:20'],
        ];
        $passwordRules = [
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:50'],
        ];
        $class = User::class;
        return view('common.account.index', compact('accountRules', 'passwordRules', 'class'));
    }
}
