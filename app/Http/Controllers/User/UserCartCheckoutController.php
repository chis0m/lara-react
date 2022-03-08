<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Repository\CheckoutRepository;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserCartCheckoutController extends Controller
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
     * Display the specified resource.
     *
     * @param User $user
     * @param Cart $cart
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user, Cart $cart): JsonResponse
    {
        $this->authorize('view', $user);
        $this->authorize('view', $cart);

        return $this->success($cart->checkout, trans('general.fetch'));
    }
}
