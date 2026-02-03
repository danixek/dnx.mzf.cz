<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function callbackGoogle(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $googleId = $googleUser->getId();
            $email = $googleUser->getEmail();
            $avatar = $googleUser->getAvatar();

            /**
             * UŽIVATEL NENÍ PŘIHLÁŠEN → LOGIN
             */
            if (!Auth::check()) {

                $user = User::where('google_id', $googleId)->first();

                if (!$user && $email) {
                    $user = User::where('email', $email)->first();
                }
                if (!$user) {
                    return redirect('/login')
                        ->with('login_error', 'Tento Google účet není propojen s žádným účtem.');
                }

                Auth::login($user, true);

                $user->update([
                    'google_id' => $googleId,
                    'avatar_url' => $avatar,
                ]);

                return redirect()->route('dashboard');
            }

            /**
             * UŽIVATEL JE PŘIHLÁŠEN → PROPOJENÍ ÚČTU
             */
            $user = Auth::user();

            $exists = User::where('google_id', $googleId)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($exists) {
                return redirect()
                    ->route('dashboard')
                    ->withErrors('Tento Google účet je již propojen s jiným účtem.');
            }

            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleId,
                    'avatar_url' => $avatar,
                ]);
            }

            return redirect()
                ->route('dashboard')
                ->with('status', 'Google účet byl propojen');
        } catch (\Throwable $e) {

            report($e);

            Auth::logout();

            return redirect('/login')
                ->with('login_error', 'Došlo k chybě při přihlášení přes Google.');
        }
    }
}
?>