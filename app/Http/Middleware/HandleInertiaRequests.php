<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Laravel\Fortify\Features;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {

        $services_list = DB::table('service_department')->where('hospital_id', $request->user()->currentHospital->id ?? null)->pluck('service_id')->toArray() ?? null;
        // dd(DB::table('service_department')->whereIn('service_id', $services_list)->get());
        return array_merge(parent::share($request), [
            'config' => config()->get(['app.name']),
            'auth' => [
                'user' => $request->user() ? UserResource::make($request->user()->load(['currentHospital', 'currentHospital.departments', 'currentHospital.departments.services'])) : null
            ],
            'current_hospital_services' => Service::whereIn('id', $services_list)->get()->pluck('name')->toArray(),
            'features' => collect(config('fortify.features'))->mapWithKeys(fn ($key) => [$key => true])->merge([
                'security' => Features::hasSecurityFeatures(),
            ]),
            'toast' => session('toast'),
            'ziggy' => [
                'route_name' => Route::currentRouteName()
            ]
        ]);
    }
}
