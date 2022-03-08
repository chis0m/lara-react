<?php

namespace App\Services;

use App\Http\Repository\CheckoutRepository;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Support\Collection as ArrayCollection;
use  Illuminate\Database\Eloquent\Collection;

/**
 * Class CheckoutServices
 * @package App\Services
 */
class CheckoutServices
{
    /**
     * @param User $user
     * @param ArrayCollection $collection
     * @return Collection|array
     */
    public static function storeUserCheckouts(User $user, ArrayCollection $collection): Collection|array
    {
        $collection->each(function ($el) use ($user) {
            $cart = Cart::whereUserId($user->id)->find($el['id']);
            $cart->checkout()->create();
            $cart->update(['status' => Cart::CHECKED_OUT]);
        });
        $cartIds = $collection->pluck('id')->toArray();
        $checkouts = Checkout::with('cart')->whereIn('cart_id', $cartIds)->get();
        CheckoutRepository::clearCache();
        return $checkouts;
    }
}
