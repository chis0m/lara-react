<?php

namespace App\Http\Controllers;

use App\Http\Repository\CheckoutRepository;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
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
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('adminOnly', User::class);
        $carts = CheckoutRepository::index();
        return $this->success($carts, trans('general.fetch'));
    }

    /**
     * Display the specified resource.
     *
     * @param Checkout $checkout
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Checkout $checkout): JsonResponse
    {
        $this->authorize('view', $checkout);
        return $this->success($checkout, trans('general.fetch'));
    }
}
