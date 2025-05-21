<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'image'      => $this->image,
            'roles' => $this->roles->map(function ($role) {
                        return [
                            'name' => $role->name,
                            'permissions' => $role->permissions
                                ->groupBy('type')              // group by permission type first
                                ->map(function ($permissionsByType) {
                                    return $permissionsByType
                                        ->groupBy('group')    // then group by permission group inside each type
                                        ->map(function ($permissionsByGroup) {
                                            return $permissionsByGroup->pluck('name'); // get permission names
                                        });
                                }),
                        ];
                    }),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
        if ($request->is('api/auth/signin')) {
            $data = array_merge($data, [
                'token' => $this->token
            ]);
        }
        return $data;
    }
}
