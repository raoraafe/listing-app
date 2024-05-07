<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(): Factory|View|Application
    {
        $userRoles = UserRole::all();

        return view('register', ['userRoles' => $userRoles]);
    }

    public function registerPost(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email|unique:users'
        ], [
            'name.required' => 'Name is required',
            'password.required' => 'Password is required'
        ]);
        try {
            DB::beginTransaction();

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();
            // Fetch the role ID from the request
            $roleId = $request->input('role');
            // Attach the role to the user
            $user->role()->attach($roleId);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Registration failed. Please try again.');
        }


        return back()->with('success', 'Register successfully');
    }
}
