<?php

use App\Http\Controllers\Account\AccountIndexController;
use App\Http\Controllers\Account\SecurityIndexController;
use App\Http\Controllers\AddServiceController;
use App\Http\Controllers\AssignPermissionToRolesController;
use App\Http\Controllers\Auth\LoginIndexController;
use App\Http\Controllers\Auth\RecoverIndexController;
use App\Http\Controllers\Auth\RegisterIndexController;
use App\Http\Controllers\Auth\ResetIndexController;
use App\Http\Controllers\Auth\TwoFactorIndexController;
use App\Http\Controllers\CreateDepartmentController;
use App\Http\Controllers\CreateHospitalController;
use App\Http\Controllers\CreateServiceController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteMemberController;
use App\Http\Controllers\DestroyDepartmentController;
use App\Http\Controllers\DestroyServiceController;
use App\Http\Controllers\EditClientHospitalController;
use App\Http\Controllers\EditDepartmentController;
use App\Http\Controllers\EditHospitalController;
use App\Http\Controllers\EditServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HospitalIndexController;
use App\Http\Controllers\ManagePermissionsController;
use App\Http\Controllers\ManageRolesController;
use App\Http\Controllers\RemoveDepartmentController;
use App\Http\Controllers\RemoveServiceController;
use App\Http\Controllers\ServiceIndexController;
use App\Http\Controllers\StoreDepartmentController;
use App\Http\Controllers\StoreHospitalController;
use App\Http\Controllers\StoreServiceController;
use App\Http\Controllers\StoreUserController;
use App\Http\Controllers\UpdateClientHospitalController;
use App\Http\Controllers\UpdateHospitalAdminController;
use App\Http\Controllers\UpdateHospitalController;
use App\Http\Controllers\UpdateUserRoleController;
use App\Models\Service;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Symfony\Contracts\Service\ResetInterface;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Getting services to route

// -------------------------------
Route::get('/', HomeController::class)->name('home');
Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('verified');
// ->middleware(RequirePassword::using(null, 1));

if (Features::enabled(Features::registration())) {
    Route::get('/auth/register', RegisterIndexController::class)->name('auth.register');
}

Route::get('/auth/login', LoginIndexController::class)->name('auth.login');

if (Features::enabled(Features::updateProfileInformation())) {
    Route::get('/account', AccountIndexController::class)->name('account.index');
}

if (Features::hasSecurityFeatures()) {
    Route::get('/account/security', SecurityIndexController::class)->name('account.security.index');
}

if (Features::enabled(Features::twoFactorAuthentication())) {
    Route::get('/auth/two-factor', TwoFactorIndexController::class)->name('auth.two-factor');
}

if (Features::enabled(Features::resetPasswords())) {
    Route::get('/auth/recover', RecoverIndexController::class)->name('auth.recover');
    Route::get('/auth/reset', ResetIndexController::class)->name('password.reset');
}

Route::middleware(['auth'])->group(function(){
    Route::get('/hospital/edit', EditHospitalController::class)->name('hospital.edit');
    Route::patch('/hospital/update', UpdateHospitalController::class)->name('hospital.update');

    Route::get('/client/hospital/{hospital}/edit', EditClientHospitalController::class)->name('client.edit.hospital');
    Route::patch('/client/hospital/{hospital}/update', UpdateClientHospitalController::class)->name('client.update.hospital');
    Route::patch('/update/hospital/admin/{user}', UpdateHospitalAdminController::class)->name('update.hospital.admin');

    Route::get('/hospital/create', CreateHospitalController::class)->name('hospital.create');
    Route::post('/hospital/store', StoreHospitalController::class)->name('hospital.store');
    Route::get('/hospital/user/create', CreateUserController::class)->name('user.create');
    Route::post('/hospital/user/store', StoreUserController::class)->name('user.store');
    Route::get('/hospitals', HospitalIndexController::class)->name('hospital.index');
    // Add service
    Route::get('/hospital/{hospital}/department/services', AddServiceController::class)->name('hospital.settings');
    Route::post('/hospital/{hospital}/department/{department}/service/{service}', [AddServiceController::class, 'store'])->name('add.service');
    Route::delete('/hospital/{hospital}/department/{department}/service/{service}', RemoveServiceController::class)->name('remove.service');
    // Departments
    Route::get('/departments/create', CreateDepartmentController::class)->name('department.create');
    Route::patch('/departments/edit/{department}', EditDepartmentController::class)->name('department.edit');
    Route::post('/departments/store', StoreDepartmentController::class)->name('department.store');
    Route::delete('/department/destroy/{department}', DestroyDepartmentController::class)->name('department.destroy');
    Route::post('/hospital/{hospital}/department/add', [StoreDepartmentController::class, 'add'])->name('department.add');
    Route::delete('/hospital/{hospital}/department/{department}/remove', RemoveDepartmentController::class)->name('department.remove');
    // Services
    Route::get('/department/{department:name}/service', CreateServiceController::class)->name('department.service');
    Route::post('/department/{department}/service/store', StoreServiceController::class)->name('service.store');
    Route::patch('/service/{service}/edit', EditServiceController::class)->name('service.edit');
    Route::delete('/service/{service}/destroy', DestroyServiceController::class)->name('service.destroy');

    // Roles
    Route::get('/hospitals/roles', ManageRolesController::class)->name('manage.roles');
    Route::post('/hospitals/roles', [ManageRolesController::class, 'store'])->name('roles.store');
    Route::post('/hospitals/admin/add/roles', [ManageRolesController::class, 'addRole'])->name('admin.add.role');
    Route::post('/hospitals/admin/create/new/role', [ManageRolesController::class, 'newRole'])->name('admin.store.role');
    Route::delete('/hospitals/role/{role}', [ManageRolesController::class, 'destroy'])->name('role.destroy');

    // Permissions
    Route::post('/hospitals/role/{role}/permission/{permission}', [ManagePermissionsController::class, 'store'])->name('permission.add');
    Route::delete('/hospitals/role/{role}/permission/{permission}', [ManagePermissionsController::class, 'destroy'])->name('permission.remove');
    // Assign permissions to roles
    Route::get('/hospital/assign/permissions', [AssignPermissionToRolesController::class, 'assign'])->name('assign.permissions.to.roles');
    // Roles
    Route::patch('/hospital/member/{member}/role/update', UpdateUserRoleController::class)->name('user.role.edit');
    Route::delete('/hospital/member/{member}', DeleteMemberController::class)->name('user.role.destroy');
    // Service Routes
    Route::prefix('service')->group(function () {
        $services = cache()->remember('dynamic_service_routes', 3600, fn () => Service::get() ?? null);
        foreach ($services as $service) {
            $method = $service->code_name;
            if (method_exists(ServiceIndexController::class, $method)) {
                Route::get($method, [ServiceIndexController::class, $method])->name($method);
            }
        }
    });


});

require __DIR__ . '/fortify.php';
