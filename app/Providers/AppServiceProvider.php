<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        // Throw an exception whenever a lazy-loaded relationship is accessed
        // outside of production, so N+1 issues are caught during development.
        Model::preventLazyLoading(! app()->isProduction());

        \Illuminate\Auth\Notifications\ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Reset Kata Sandi - ' . config('app.name'))
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda di sistem ' . config('app.name') . '.')
                ->action('Reset Kata Sandi', route('filament.admin.auth.password-reset.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]))
                ->line('Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.')
                ->line('Jika Anda tidak merasa meminta reset sandi, abaikan saja email ini.');
        });
    }
}
