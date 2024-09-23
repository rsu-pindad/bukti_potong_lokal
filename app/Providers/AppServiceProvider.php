<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('currencyRp', function ($expression) {
            return "Rp. <?php echo number_format($expression,2,',','.'); ?>";
        });
        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression,2,',','.'); ?>";
        });
        Paginator::useBootstrapFive();
        setlocale(LC_ALL, 'id_ID', 'id_ID.UTF-8');
        Cache::flush();
        Session::flush();
        config(['app.locale' => 'id']);
        Number::useLocale('id');
        Carbon::setLocale('id');
    }
}
