<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function avatarUrl()
    {
        if ($this->profile_photo_path) {
            return Storage::disk('local')->url($this->profile_photo_path);
        }

        return "https://ui-avatars.com/api/?name=" . urlencode($this->name);
    }

    public function role($id){
        $role_ = DB::table('model_has_roles')->where('model_id', $id)->where('current_hospital_id', $this->currentHospital->id)->first();
        $role = Role::find($role_?->role_id);
        return $role?->name;
    }

    public function hospitals(){
        return $this->belongsToMany(Hospital::class);
    }

    public function currentHospital(){
        // relating to the specific column of this current models database
        return $this->belongsTo(Hospital::class, 'current_hospital_id');
    }

    public function permissions_service_list(){
        $role_ids = DB::table('model_has_roles')->where('model_id', $this->id)->get()->pluck('role_id')->toArray() ?? null;
        $role_permission_ids = DB::table('role_has_permissions')->whereIn('role_id', $role_ids)->get()->pluck('permission_id')->toArray() ?? null;
        $role_permissions = Permission::whereIn('id', $role_permission_ids)->get()->pluck('name')->toArray() ?? null;
        $permissions_services = Service::whereIn('name', $role_permissions)->get()->pluck('name')->toArray() ?? null;
        return $permissions_services;
    }

    // To be revised

    // Get the departments that exist in relation to the services that the user does
    // Get all the services, pluck out the names
    // Compare the permissions under the user role
    // compare the permissions with services
    // Display only those that match

    // get the departments to whom the services belong
    // return the department ids
    // only display those departments that match the department.ids

    // get the roles from model_id (model_has_roles)
    // get the permissions related to the role
    // permission_ids
    // Then permission names
    // Get the service names that relate with the permission names

    // Get the departments to which those services belong
    // return the department ids

    public function user_department_list()
    {
        $role_ids = DB::table('model_has_roles')->where('model_id', $this->id)->pluck('role_id')->toArray();
        $permission_ids = DB::table('role_has_permissions')->whereIn('role_id', $role_ids)->pluck('permission_id')->toArray();
        $permissions = Permission::whereIn('id', $permission_ids)->pluck('name')->toArray();
        $service_ids = Service::whereIn('name', $permissions)->pluck('id')->toArray();
        $department_ids = DB::table('service_department')
            ->whereIn('service_id', $service_ids)
            ->where('hospital_id', $this->currentHospital->id)
            ->pluck('department_id')
            ->toArray();

        return $department_ids;
    }


}
