<?php

namespace coderslab\Notify;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent as Agent;


final class LaravelNotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerBladeDirective();
        $this->registerPublishables();
            $Agent = new Agent();
            if ($Agent->isMobile()) {
                $viewPath = __DIR__.'/../resources/views/mobile';
            } else {
                $viewPath = __DIR__.'/../resources/views/web';
            }


        $this->loadViewsFrom($viewPath, 'notify');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/notify.php', 'notify');

        $this->app->singleton('notify', function ($app) {
            return $app->make(LaravelNotify::class);
        });
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('notifyCss', function () {
            return '<?php echo notifyCss(); ?>';
        });

        Blade::directive('notifyJs', function () {
            return '<?php echo notifyJs(); ?>';
        });
    }

    public function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../resources/views' =>  base_path('views/web/vendor/coderslab/laravel-notify'),
        ], 'notify-assets-web');

        $this->publishes([
            __DIR__.'/../resources/views' =>  base_path('views/mobile/vendor/coderslab/laravel-notify'),
        ], 'notify-assets-mobile');

        $this->publishes([
            __DIR__.'/../config/notify.php' => config_path('notify.php'),
        ], 'notify-config');
    }
}
