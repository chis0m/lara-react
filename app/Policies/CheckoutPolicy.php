<?php

namespace App\Policies;

use App\Exceptions\ApplicationException;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Validation\ValidationException;

class CheckoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Checkout $checkout
     * @return Response|bool
     */
    public function view(User $user, Checkout $checkout): Response|bool
    {
        return $user->id === $checkout->cart->user->id || $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Cart $cart
     * @return bool
     * @throws ApplicationException
     */
    public function store(User $user, Cart $cart)
    {
        if (!$cart->isCheckedOut()) {
            throw new ApplicationException(
                trans('general.checkout'),
                \Illuminate\Http\Response::HTTP_PRECONDITION_FAILED
            );
        }
        return $user->id === $cart->user->id;
    }
}
