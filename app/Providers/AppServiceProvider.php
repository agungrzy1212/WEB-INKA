<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Permintaan Reset Kata Sandi - LKP INKA Wonosobo')
                ->greeting('Halo, ' . ($notifiable->name ?? 'Siswa LKP INKA') . '!')
                ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di Sistem Pendaftaran LKP INKA Wonosobo.')
                ->action('Atur Ulang Kata Sandi', $url)
                ->line('Tautan atur ulang kata sandi ini hanya berlaku selama 60 menit.')
                ->line('Jika Anda tidak merasa mengajukan permintaan ini, silakan abaikan email ini dan akun Anda tetap aman.')
                ->salutation("Salam hangat,\nTim LKP INKA Wonosobo");
        });
    }
}
