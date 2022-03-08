<?php

namespace App\Http\Controllers;

use App\Http\Resources\Auth\UserResource;
use App\Traits\Respondable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use Respondable;

    /**
     * Display our routes
     *
     * @return string
     */
    public function routes(): string
    {
        exec(base_path('artisan route:list'), $routes);
        foreach ($routes as $index => $route) {
            if (str_contains($route, 'telescope')) {
                unset($routes[$index]);
            }
            if (str_contains($route, '_ignition')) {
                unset($routes[$index]);
            }
        }
        return '<pre>' . implode("\n", $routes) . '</pre>';
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return $this->success(new UserResource($request->user()));
    }
}
