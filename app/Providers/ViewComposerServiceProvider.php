<?php

namespace App\Providers;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(views: ['users.create', 'users.edit'], callback: fn (ViewContract $view) => $view->with(
            key: 'roles',
            value: Role::select(columns: ['id', 'name'])->get()
        ));
  

				View::composer(views: ['merchants.create', 'merchants.edit'], callback: fn(ViewContract $view) => $view->with(
            key: 'banks',
            value: \App\Models\Bank::select(columns: ['id', 'nama_bank'])->get()
        ));

	}
}