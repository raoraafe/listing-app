<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Factory|View|Application
    {
        // Get the authenticated user
        $user = Auth::user();
        // Load the user's roles
        $user->load('role');
        // Access user information
        $userName = $user->name;
        // Access user roles
        $userRoles = $user->role->first()->title;

        return view('dashboard', [
            'user' => $user,
            'userName' => $userName,
            'userRoles' => $userRoles
        ]);
    }
}
