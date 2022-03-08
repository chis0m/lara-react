<?php

namespace App\Services;

use App\Http\Repository\CartRepository;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as ArrayCollection;
use  Illuminate\Database\Eloquent\Collection;

/**
 * Class CartService
 * @package App\Services
 */
class CartService
{
    /**
     * @param User $user
     * @param ArrayCollection $carts
     * @return Collection|array
     */
    public static function storeCart(User $user, ArrayCollection $carts): Collection|array
    {
        $carts->each(function ($cart) use ($user) {
            Cart::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $cart[ 'product_id'], 'status' => Cart::ADDED],
                [ 'count' =>  $cart['count'] ?? 1]
            );
        });
        $updated = Cart::whereUserId($user->id)->whereStatus(Cart::ADDED)->with('product')->get();
        CartRepository::clearCache();
        return $updated;
    }

    /**
     * @param Cart $cart
     * @param Request $request
     * @return mixed
     */
    public static function updateCart(Cart $cart, Request $request): mixed
    {
        $result = tap($cart)->update([ 'count' => $request['count']]);
        if ($request->has('status')) {
            $status = ((int)$request['count'] === 0 ? Cart::REMOVED : $request['status']);
            $result = tap($cart)->update(['status' => $status]);
        }
        if ($cart->status === Cart::CHECKED_OUT) {
            $cart->checkout()->create();
        }

        CartRepository::clearCache();

        return $result->load('product');
    }
}
