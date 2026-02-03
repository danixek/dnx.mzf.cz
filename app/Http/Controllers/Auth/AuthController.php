<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Úspěšné přihlášení
            $request->session()->regenerate();
            $result = User::where('email', $credentials['email'])->first();

            return redirect()->intended($request->session()->pull('redirect_after_login', '/dashboard'));
        }

        // Neplatné údaje
         return back()->withErrors([
            'email' => 'Neplatný email.',
            'password' => 'Neplatné heslo.'
        ])->withInput($request->only('email', 'password'));
    }
    public function logout(Request $request)
    {
        // Odhlášení uživatele
        Auth::logout();

        // Vyčištění session a regenerace tokenu
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Přesměrování na dashboard nebo domovskou stránku
        return redirect()->route('dashboard');
    }    
    // Zpracovat registraci
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:4', 'max:255', 'alpha_num'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed', // očekává pole password_confirmation
                'min:8',
                'regex:/[0-9]/',      // alespoň jedna číslice
                'regex:/[A-Z]/',      // alespoň jedno velké písmeno
                'regex:/[a-z]/',      // alespoň jedno malé písmeno
            ]], [
            'username.required' => 'Uživatelské jméno je povinné.',
            'username.min' => 'Uživatelské jméno musí mít alespoň 4 znaky.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadejte platný email.',
            'email.unique' => 'Tento email je již registrován.',
            'password.required' => 'Heslo je povinné.',
            'password.min' => 'Heslo musí mít alespoň 8 znaků.',
            'password.confirmed' => 'Hesla se neshodují.',
        ]
        );

        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        Auth::login($user);

        // Přesměrování po úspěšné registraci
        return redirect()->intended($request->session()->pull('redirect_after_login', '/dashboard'));
    }
}
