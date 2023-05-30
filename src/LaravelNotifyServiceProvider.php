<?php

namespace coderslab\Notify;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class LaravelNotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        resource_path
        $this->registerBladeDirective();
        $this->registerPublishables();

        
        $Agent = new Agent();
        if ($Agent->isMobile()) {
        $viewPath = resource_path('views/mobile');
        } else {
        $viewPath = resource_path('views/web');
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
            __DIR__.'/../resources/views' => resource_path('views/web/vendor/coderslab/laravel-notify'),
        ], 'notify-assets');

        $this->publishes([
            __DIR__.'/../config/notify.php' => config_path('notify.php'),
        ], 'notify-config');
    }
}
