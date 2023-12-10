<?php

namespace App\Providers;

use Native\Laravel\Dock;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {


        MenuBar::create()
            ->route('color-picker.index')
            ->alwaysOnTop()
            ->transparent()
            ->lightVibrancy()
            ->width(300)
            ->height(390)
            ->icon(storage_path('app/public/images/menuBarIconTemplate.png'))
            ->
            withContextMenu(
                Menu::new()
                    ->label('Color Snap')
                    ->separator()
                    ->link('https://sinarahmannejad.com/', 'About Developer…')
                    ->separator()
                    ->label('version: '. config('nativephp.version'))
                    ->separator()
                    ->quit()
            );
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
