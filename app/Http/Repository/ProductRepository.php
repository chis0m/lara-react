<?php

namespace App\Http\Repository;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Cache;
use Carbon\Carbon;
use Exception;

class ProductRepository
{
    public const CACHE_KEY = 'products';

    public static function index()
    {
        try {
            return Cache::tags(self::CACHE_KEY)
                ->remember(
                    self::CACHE_KEY,
                    Carbon::now()->addMinutes(300),
                    static function () {
                        return ProductResource::collection(Product::get());
                    }
                );
        } catch (Exception $e) {
            return ProductResource::collection(Product::get());
        }
    }

    public static function clearCache(): void
    {
        $cacheKey = self::CACHE_KEY;
        Cache::tags($cacheKey)->flush();
    }
}
