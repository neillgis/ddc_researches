<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\API\SSOController;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    private function putSession($user) {
        if (empty(Session::get('role'))) {
            $cid = trim($user->preferred_username);
            $data = DB::table('user_role')->where('cid', $cid)->first();
            if( empty($data) ) {
                $sso = new SSOController();
                $sso = $sso->ProfileData($cid);
                $user_name = $sso['user_name'];
                $dep_id = $sso['dep_id'];
                $role = "user";
            }else{
                $user_name = $data->name;
                $dep_id = $data->dep_id;
                $role = $data->role;
            }

            session()->put('cid', $cid);
            session()->put('user_name', $user_name);
            session()->put('dep_id', $dep_id);
            session()->put('role', $role);
            session()->put('curr_role', $role);

            $query = DB::table("depart")->where("sso", $dep_id)->first();
            $dep_name = empty($query)?"departments":$query->depart_name;
            session()->put('dep_name', $dep_name);

            return $role;
        }else{
            return Session::get('role');
        }
    }

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            if (Auth::hasRole('admin')) {
                return true;
            }else{
                return false;
            }
        });

        Gate::define('manager', function ($user) {
            if( Session::get('curr_role') == "user" ) {
                return false;
            }else{
                $curr_role = $this->putSession($user);
                if ($curr_role == 'manager') {
                    return true;
                }else{
                    return false;
                }
            }
            
        });

        Gate::define('departments', function ($user) {
            if( Session::get('curr_role') == "user" ) {
                return false;
            }else{
                $curr_role = $this->putSession($user);
                if ($curr_role == 'departments') {
                    return true;
                }else{
                    return false;
                }
            }
        });
        Gate::define('user', function ($user) {
            $curr_role = $this->putSession($user);
            if ($curr_role == 'user') {
                return true;
            }else{
                return false;
            }
        });

    }
}
