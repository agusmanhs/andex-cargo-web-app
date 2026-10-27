<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Login extends BaseLogin
{
    protected static string $view = 'filament.pages.auth.login';
    protected static string $layout = 'filament-panels::components.layout.base';

    public function getTitle(): string | Htmlable
    {
        return 'Masuk ke Akun Anda - Andex Cargo Enterprise';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Masuk ke Akun Anda';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Akses portal operasional cabang, sistem agen resmi, dan analitik logistik terpadu.';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('ID PENGGUNA / EMAIL')
            ->placeholder('contoh: branch.jkt01 atau user@andexcargo.com')
            ->prefixIcon('heroicon-m-identification')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('KATA SANDI')
            ->placeholder('Masukkan kata sandi akun')
            ->prefixIcon('heroicon-m-lock-closed')
            ->hint(new HtmlString('<span class="text-xs font-bold text-[#c5161d] cursor-pointer hover:underline" onclick="alert(&quot;Untuk bantuan reset sandi, hubungi IT Helpdesk cabang.&quot;)">Lupa Sandi?</span>'))
            ->password()
            ->revealable(true)
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Ingat sesi perangkat ini');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Masuk ke Portal Operasional →')
            ->color('danger')
            ->submit('authenticate')
            ->extraAttributes([
                'class' => 'stitch-login-submit-btn w-full !bg-[#c5161d] hover:!bg-[#a81318] !text-white !font-bold !py-3.5 !rounded-xl !shadow-lg hover:!shadow-red-600/30 transition-all text-base tracking-wide flex items-center justify-center gap-2',
            ]);
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }
}
