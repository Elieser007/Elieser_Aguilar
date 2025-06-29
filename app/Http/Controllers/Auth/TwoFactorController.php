<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TwoFactorController extends Controller
{
    public function show2faForm(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $google2fa = app('pragmarx.google2fa');
        if (!$user->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        }
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );
        return view('2fa.enable', ['QR_Image' => $QR_Image, 'secret' => $user->google2fa_secret]);
    }

    public function enable2fa(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('one_time_password'));
        if ($valid) {
            // 2FA habilitado correctamente
            return redirect()->route('dashboard')->with('success', '2FA habilitado');
        } else {
            return back()->withErrors(['one_time_password' => 'Código inválido']);
        }
    }

    public function disable2fa(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $user->google2fa_secret = null;
        $user->save();
        return redirect()->route('dashboard')->with('success', '2FA deshabilitado');
    }
}