<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $service
        ) {
    }

    // public function index(Request $request){
    //     return $this->service->getRoleUser($request->user());
    // }

    // assumir papel
    public function assignRole(RoleRequest $request){
        $validated = $request->validated();
        return $this->service->assignRole($validated);
    }

    // remover papel
    public function removeRole(RoleRequest $request){
        return $this->service->removeRole($request->validated());
    }
}
