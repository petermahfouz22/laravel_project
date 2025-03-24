<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    \Log::info('Registration Request Received', $request->all());

    try {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:candidate,employer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        \Log::info('Validation Passed', $validatedData);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        \Log::info('User Created', ['user_id' => $user->id, 'role' => $user->role]);

        event(new Registered($user));
        Auth::login($user);

        \Log::info('User Logged In', ['user_id' => $user->id]);

        $route = match ($user->role) {
            'candidate' => 'candidate.dashboard',
            'employer' => 'employer.dashboard',
            default => 'welcome',
        };

        \Log::info('Redirecting to Route', ['route' => $route]);

        return redirect()->route($route);
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validation Failed', [
            'errors' => $e->errors(),
            'input' => $request->all()
        ]);
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        \Log::error('Unexpected Error', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
}