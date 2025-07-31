<?php

namespace SaasPro;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use SaasPro\Facades\Saaspro;

class PortalPanelProvider extends PanelProvider {
    

    function load(Panel $panel) {
        $plugins = Saaspro::plugins();
        foreach($plugins as $plugin) {
            if(method_exists(app($plugin), 'filament')) {
                $panel = app($plugin)->filament($panel);
            }
        }


        return $panel;
    }

    public function panel(Panel $panel): Panel {
        return $this->load($this->boot($panel));
    }

    function boot(Panel $panel) {
        return $panel
            ->default()
            ->id('portal')
            ->path('portal')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            // ->discoverResources(in: __DIR__."/Filament/Resources", for: 'SaasPro\\Filament\\Resources')
            // ->discoverPages(in: __DIR__.'/Filament/Pages', for: 'SaasPro\\Filament\\Pages')
            // ->discoverWidgets(in:  __DIR__.'/Filament/Widgets', for: 'SaasPro\\Filament\\Widgets')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
        ]);
    }
}
