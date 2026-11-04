<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $request->session()->flash('toast_success', 'Selamat datang kembali, ' . $user->name . '!');
            
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Default role for registering users
        ]);

        Auth::login($user);
        
        $request->session()->flash('toast_success', 'Registrasi berhasil! Selamat datang di LKP INKA.');

        return redirect()->route('pendaftaran');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('toast_success', 'Anda telah berhasil keluar sistem.');

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }
        
        return redirect()->route('dashboard.siswa');
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $plainToken = null;
        $status = Password::broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) use (&$plainToken) {
                $plainToken = $token;
                $user->sendPasswordResetNotification($token);
            }
        );

        if ($status === Password::RESET_LINK_SENT) {
            $devResetUrl = null;
            if ($plainToken && (app()->isLocal() || config('mail.default') === 'log')) {
                $devResetUrl = route('password.reset', [
                    'token' => $plainToken,
                    'email' => $request->email,
                ]);
            }

            return back()->with([
                'status' => 'Tautan untuk mereset kata sandi telah dikirim ke email Anda!',
                'dev_reset_url' => $devResetUrl,
            ]);
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->withErrors([
                'email' => 'Permintaan reset sandi terlalu sering. Harap tunggu beberapa saat sebelum mencoba lagi.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.',
        ])->onlyInput('email');
    }

    public function resetPasswordForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $request->session()->flash('toast_success', 'Kata sandi berhasil diatur ulang! Silakan masuk dengan kata sandi baru Anda.');
            return redirect()->route('login');
        }

        $errorMessage = 'Gagal mengatur ulang kata sandi.';
        if ($status === Password::INVALID_TOKEN) {
            $errorMessage = 'Token atur ulang kata sandi tidak valid atau telah kedaluwarsa.';
        } elseif ($status === Password::INVALID_USER) {
            $errorMessage = 'Pengguna dengan alamat email tersebut tidak ditemukan.';
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->onlyInput('email');
    }
}
