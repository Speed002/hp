<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact,
            'avatar_url' => $this->avatarUrl(),
            'two_factor_enabled' => $this->hasEnabledTwoFactorAuthentication(),
            'current_hospital' => HospitalResource::make($this->whenLoaded('currentHospital')),
            'role' => $this->role($this->id),
            'permissions' => [
                'manage_hospitals' => $request->user()->can('manage hospitals'),
                'manage_departments' => $request->user()->can('manage departments'),
                'manage_roles_and_permissions' => $request->user()->can('manage roles and permissions'),
                'assign_roles_and_permissions' => $request->user()->can('assign roles and permissions'),
                'update_hospital' => $request->user()->can('update hospital'),
                'create_users' => $request->user()->can('create users'),
                'profile_hospitals' => $request->user()->can('profile hospitals'),
                'profile_hospital' => $request->user()->can('profile hospital'),
            ],
            'permissions_service_list' => $this->permissions_service_list(),
            'user_department_list' => $this->user_department_list()
        ];
    }
}
