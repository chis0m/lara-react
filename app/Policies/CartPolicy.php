<?php

namespace App\Policies;

use App\Exceptions\ApplicationException;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function adminOnly(User $user): bool
    {
        return $user->role === User::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Cart $cart
     * @return Response|bool
     */
    public function view(User $user, Cart $cart): Response|bool
    {
        return $user->id === $cart->user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Cart $cart
     * @return Response|bool
     */
    public function store(User $user, Cart $cart): Response|bool
    {
        return $user->id === $cart->user->id;
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Cart $cart
     * @param Request $request
     * @return Response|bool
     * @throws ApplicationException
     */
    public function update(User $user, Cart $cart, Request $request): Response|bool
    {
        if (in_array($cart->status, [Cart::REMOVED, Cart::CHECKED_OUT], true)) {
            throw new ApplicationException(
                trans('general.cart_cant_update', [
                    'value' => Cart::statusToString((int) $request->{'status'}),
                    'secondValue' =>  Cart::statusToString($cart->status)
                ]),
                Res::HTTP_PRECONDITION_FAILED
            );
        }
        return $user->id === $cart->user->id;
    }
}
