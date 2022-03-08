<?php

namespace App\Http\Repository;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use Cache;
use Carbon\Carbon;
use Exception;

class CartRepository
{
    public const CACHE_KEY = 'carts';

    public static function index($status = null)
    {
        try {
            return Cache::tags(self::CACHE_KEY)
                ->remember(
                    self::CACHE_KEY,
                    Carbon::now()->addMinutes(30),
                    static function () use ($status) {
                        // @phpstan-ignore-next-line
                        return CartResource::collection(Cart::when($status, static fn ($q) => $q->whereStatus($status))
                            ->get());
                    }
                );
        } catch (Exception $e) {
            // @phpstan-ignore-next-line
            return CartResource::collection(Cart::when($status, static fn ($q) => $q->whereStatus($status))->get());
        }
    }

    public static function clearCache(): void
    {
        $cacheKey = self::CACHE_KEY;
        Cache::tags($cacheKey)->flush();
    }
}
