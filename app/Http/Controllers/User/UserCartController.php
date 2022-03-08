<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartIndexRequest;
use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Requests\Cart\CartUpdateRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserCartController extends Controller
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
     * @param User $user
     * @param CartIndexRequest $request
     * @return JsonResponse
     */
    public function index(User $user, CartIndexRequest $request): JsonResponse
    {
        $carts = $user->carts()->when($request['status'], fn ($q) => $q->whereStatus($request['status']))->get();
        $cartCollection = CartResource::collection($carts);
        return $this->success($cartCollection, trans('general.fetch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param CartStoreRequest $request
     * @return JsonResponse
     */
    public function store(User $user, CartStoreRequest $request): JsonResponse
    {
        $carts = collect($request['cart']);
        $updated = CartService::storeCart($user, $carts);
        return $this->success(CartResource::collection($updated), trans('general.store'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param Cart $cart
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user, Cart $cart): JsonResponse
    {
        $this->authorize('view', $cart);
        return $this->success($cart, trans('general.fetch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param Cart $cart
     * @param CartUpdateRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(User $user, Cart $cart, CartUpdateRequest $request): JsonResponse
    {
        $this->authorize('update', [$cart, $request]);
        $result = CartService::updateCart($cart, $request);
        return  $this->success($result, trans('general.update'), Response::HTTP_ACCEPTED);
    }
}
