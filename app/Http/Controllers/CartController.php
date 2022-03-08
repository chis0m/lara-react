<?php

namespace App\Http\Controllers;

use App\Http\Repository\CartRepository;
use App\Http\Requests\Cart\CartIndexRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param CartIndexRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(CartIndexRequest $request): JsonResponse
    {
        $this->authorize('adminOnly', User::class);
        $carts = CartRepository::index($request['status']);
        return $this->success($carts, trans('general.fetch'));
    }
}
