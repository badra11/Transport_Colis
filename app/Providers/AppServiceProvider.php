<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Colis; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
       $this->configureDefaults();

       View::composer('*', function ($view) {
        $nbreDepot = 0;
        
        if (Auth::check()) {
            $poste = Auth::user()->gare_id; // Récupérer le poste de l'utilisateur connecté
            
            $nbreDepot = Colis::where('status_envois', 'depot')
                ->where('gare_envois', $poste)
                ->count();
        }
        
        $view->with('nbreDepot', $nbreDepot);
    });
           view::composer('*', function ($view) {
            $nbreEnCours = 0;
            
            if (Auth::check()) {
                $poste = Auth::user()->gare_id; // Récupérer le poste de l'utilisateur connecté
                
                $nbreEnCours = Colis::where('status_envois', 'encours')
                    ->where('gare_envois', $poste)
                    ->count();
            }
            
            $view->with('nbreEnCours', $nbreEnCours);
        });

        view::composer('*', function ($view) {
            $nbreArriver = 0;
            
            if (Auth::check()) {
                $poste = Auth::user()->gare_id; // Récupérer le poste de l'utilisateur connecté
                
                $nbreArriver = Colis::where('status_envois', 'encours')
                    ->where('gare_destination', $poste)
                    ->count();
            }
            
            $view->with('nbreArriver', $nbreArriver);
        });

        view::composer('*', function ($view) {
            $nbreAnnuler = 0;
            
            if (Auth::check()) {
                $poste = Auth::user()->gare_id; // Récupérer le poste de l'utilisateur connecté
                
                $nbreAnnuler = Colis::where('status_envois', 'annuler')
                    ->where('gare_envois', $poste)
                    ->count();
            }
            
            $view->with('nbreAnnuler', $nbreAnnuler);
        });

    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
