<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\CustomClass\PawRbac;
use App\Models\Groups;
use App\Models\Locations;
use App\Models\Menus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        date_default_timezone_set('Asia/Jakarta');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        
        $this->registerPolicies();

        Gate::define('Admin', function ($user) {
            if (isset($this->prev_segments(URL::current())[0])) {
                $link = $this->prev_segments(URL::current())[0];
                if ($user->username == 'administrator') {
                    return true;
                } else {
                    $pawrbac = new PawRbac;
                    $res = $pawrbac->cekMenuGroup($link, $user->group_id);
                    return $res;
                }
            } else {
                return true;
            }
        });

        Gate::define('Insert', function ($user) {
            if (isset($this->prev_segments(URL::current())[0])) {
                $link = $this->prev_segments(URL::current())[0];
                if ($user->username == 'administrator') {
                    return true;
                } else {
                    $pawrbac = new PawRbac;
                    $res = $pawrbac->cekPrivileges($link, $user->group_id, 'Insert');
                    return $res;
                }
            } else {
                return true;
            }
        });

        Gate::define('Update', function ($user) {
            if (isset($this->prev_segments(URL::current())[0])) {
                $link = $this->prev_segments(URL::current())[0];
                if ($user->username == 'administrator') {
                    return true;
                } else {
                    $pawrbac = new PawRbac;
                    $res = $pawrbac->cekPrivileges($link, $user->group_id, 'Update');
                    return $res;
                }
            } else {
                return true;
            }
        });

        Gate::define('Delete', function ($user) {
            if (isset($this->prev_segments(URL::current())[0])) {
                $link = $this->prev_segments(URL::current())[0];
                if ($user->username == 'administrator') {
                    return true;
                } else {
                    $pawrbac = new PawRbac;
                    $res = $pawrbac->cekPrivileges($link, $user->group_id, 'Delete');
                    return $res;
                }
            } else {
                return true;
            }
        });

        View::composer(
            'includes.main-sidebar',
            function ($view) {

                if (isset($this->prev_segments(URL::current())[0])) {
                    $link = $this->prev_segments(URL::current())[0];
                } else {
                    $link = '';
                }

                $pawrbac = new PawRbac;
                $arr = $pawrbac->menuApp($link);
                $view->with('link',  $link);
                $view->with('header_menu_sidebar',  $arr['header']);
                $view->with('menu_sidebar',  $arr['output']);
            }
        );

        View::composer(
            'includes.main-header',
            function ($view) {
                $user = Auth::user();
                $location = Locations::where('id', $user->location_id)->first();
                $view->with('location',  $location);

                $group = Groups::where('id', $user->group_id)->first();
                $view->with('group',  $group);
            }
        );

        View::composer(
            'layouts.main',
            function ($view) {
                if (isset($this->prev_segments(URL::current())[0])) {
                    $link = $this->prev_segments(URL::current())[0];
                    if($link){
                        $menus = Menus::whereRaw(" (lower(link) = '".strtolower($link)."') ")->first();
                        $menu_name = (isset($menus->menu_name)) ? $menus->menu_name : $link;
                    }
                    else{
                        $menu_name = 'Home';
                    }
                } else {
                    $menu_name = 'Home';
                }
                
                $view->with('menu_name',  $menu_name);
                $user = Auth::user();
                $location = Locations::where('id', $user->location_id)->first();
                $view->with('location',  $location);
            }
        );
    }

    private function prev_segments($uri)
    {
        $segments = explode('/', str_replace('' . url('') . '', '', $uri));

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }
}
