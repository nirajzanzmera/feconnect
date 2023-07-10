<?php

namespace App\Providers;

use App\Helper\Helper;
use Illuminate\Http\Request;
use App\Breadcrumbs\Breadcrumbs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrap();
        
        Blade::directive('rtable', function ($data) {
            // $items = json_decode($data, true);
            // $view = view('components.responsive_table', compact('data'))->render();
            dd($data);
            return View::make('components.responsive_table', $data);
        });

        Blade::directive('rowmenu', function ($data) {
            dd($data);
            return view('components.row_menu', (array)$data);
        });

        /* 
            To format variables in blade files as USD $
            @money($value)
        */
        Blade::directive('money', function ($amount) {
            return "<?php echo '$' . number_format($amount, 2); ?>";
        });

        // Breadcrumb support
        Request::macro('breadcrumbs', function () {
            return new Breadcrumbs($this);
        });

        // Support global session variables for view
        View::composer('*', function ($view) {
            // Verify Login (NB: middleware hasn't been processed at this point)
            /*
            if (session()->has('home_data')) {
                $results=session('home_data');
            } else {
                if (Helper::VerifyAccessDefaultApi()) {
                    $results=Helper::GetDefaultApi("/api/home_data");
                    session(['home_data' => $results]);
                }
            }
            */
            $results=Helper::load_home_data();
            // $view->with('website',$results['data']->data->website ?? []);
            $view->with('team',$results['data']->data->team ?? []);
            $view->with('teams',$results['data']->data->teams ?? []);
            $view->with('g_user',$results['data']->data->user ?? []);
        });

    }
}
