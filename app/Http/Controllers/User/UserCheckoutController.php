<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutStoreRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\User;
use App\Services\CheckoutServices;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserCheckoutController extends Controller
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
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(User $user): JsonResponse
    {
        $this->authorize('view', $user);
        $checkouts = $user->checkouts;
        $checkoutCollection = CheckoutResource::collection($checkouts);
        return $this->success($checkoutCollection, trans('general.fetch'));
    }

    /**
     * @param User $user
     * @param CheckoutStoreRequest $request
     * @return JsonResponse
     */
    public function store(User $user, CheckoutStoreRequest $request): JsonResponse
    {
        $collection = collect($request['cart']);
        $checkouts = CheckoutServices::storeUserCheckouts($user, $collection);
        return $this->success(
            CheckoutResource::collection($checkouts),
            trans('general.store'),
            Response::HTTP_CREATED
        );
    }
}
