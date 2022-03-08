<?php

namespace App\Http\Repository;

use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use Cache;
use Carbon\Carbon;
use Exception;

class CheckoutRepository
{
    public const CACHE_KEY = 'checkouts';

    public static function index()
    {
        try {
            return Cache::tags(self::CACHE_KEY)
                ->remember(
                    self::CACHE_KEY,
                    Carbon::now()->addMinutes(30),
                    static function () {
                        return CheckoutResource::collection(Checkout::get());
                    }
                );
        } catch (Exception $e) {
            return CheckoutResource::collection(Checkout::get());
        }
    }

    public static function clearCache(): void
    {
        $cacheKey = self::CACHE_KEY;
        Cache::tags($cacheKey)->flush();
    }
}
