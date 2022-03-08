<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function index(User $user): JsonResponse
    {
        $products = ProductResource::collection($user->products);
        return $this->success($products, trans('general.fetch'));
    }
}
