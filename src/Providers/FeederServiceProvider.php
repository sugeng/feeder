<?php namespace Wongpinter\Feeder\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Created By: Sugeng
 * Date: 2019-06-22
 * Time: 12:15
 */
class FeederServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/feeder.php' => config_path('feeder.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/feeder.php', 'feeder');

        $this->registerCommands();

        $this->app->bind(
            \Wongpinter\Feeder\Modules\Mahasiswa\Dto\MahasiswaDTOContract::class,
            \Wongpinter\SimpatiFeeder\DTO\MahasiswaDTO::class
        );

        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Wongpinter\Feeder\Commands\Experiment\UpdateMahasiswa::class,
                \Wongpinter\Feeder\Commands\Experiment\CariKosong::class
            ]);
        }
    }
}
