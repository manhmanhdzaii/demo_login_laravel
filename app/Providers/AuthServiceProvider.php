<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Modules;
use App\Models\User;
use App\Models\Categories;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categories::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $modulesList = Modules::all();
        if ($modulesList->count() > 0) {
            foreach ($modulesList as $module) {
                Gate::define($module->name, function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name);
                        return $check;
                    }
                    return false;
                });
                $roleArrModule = explode(',', $module->role);
                foreach ($roleArrModule as $role) {
                    Gate::define($module->name . '.' . $role, function (User $user) use ($module, $role) {
                        $roleJson = $user->group->permissions;
                        if (!empty($roleJson)) {
                            $roleModule = json_decode($roleJson, true);
                            $check = isRole($roleModule, $module->name, $role);
                            return $check;
                        }
                        return false;
                    });
                }
            }
        }
    }
}