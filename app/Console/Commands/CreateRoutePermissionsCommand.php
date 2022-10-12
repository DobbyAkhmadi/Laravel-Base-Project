<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class CreateRoutePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-permission-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a permission routes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $routes = Route::getRoutes()->getRoutes();
        $controllersPath = 'App\Http\Controllers';
        foreach ($routes as $route) {
            $type = gettype($route->getAction()['uses']);
            if ($type != 'object' && $type === 'string' && str_contains($route->getAction()['uses'], $controllersPath)) {
                $actionName = explode('@', basename(str_replace('\\', '/', $route->getAction()['uses'])));
                $moduleName = preg_replace('/Controller$/', '', $actionName[0]);
                $methodName = $actionName[1];
                $permName = "$moduleName@$methodName";
                $permission = Permission::where('name', $permName)->where('module', $moduleName)->first();
                if (empty($permission)) {
                    Permission::create([
                        'name' => $permName,
                        'guard_name' => 'api',
                        'module' => $moduleName,
                    ]);
                }
            }
        }
        $role = Role::where('name', 'super-admin')->first();

        $permissions = Permission::pluck('id', 'id')->all();
        $this->info('sync permission to super admin');
        $role->syncPermissions($permissions);
        $this->info('permission sync successfully');
        $this->info('Permission routes added successfully.');
    }
}
