<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user_type = 'Member';
        $curtime = date("Y-m-d H:i:s");
        
        $userdata = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type'=>$user_type,
            'created_at'=>$curtime,
            'updated_at'=>$curtime
        ];

        $user = User::create($userdata);

        if($user instanceof User)
        {
            event(new Registered($user));
            Auth::login($user);
            return response()->json([
                'error' => false,
                'message' => __('You have been registered successfully'),
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => __('Something went wrong'),
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
