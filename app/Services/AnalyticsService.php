<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

/**
 * Class AnalyticsService
 * @package App\Services
 */
class AnalyticsService
{
    /**
     * Get basic analytics
     * Product Removal Frequency after adding to cart
     * Number of products checkedOut from to cart
     * @return array
     */
    public static function getAnalytics(): array
    {
        $removed = Product::whereHas('carts', static function ($q) {
            $q->whereStatus(Cart::REMOVED);
        })->with(['carts' => static function ($q) {
            $q->whereStatus(Cart::REMOVED);
        }])->get();

        $checkedOuts = Product::whereHas('carts', static function ($q) {
            $q->whereStatus(Cart::CHECKED_OUT);
        })->withCount('carts')->with(['carts' => static function ($q) {
            $q->whereStatus(Cart::CHECKED_OUT);
        }])->get();

        $removed->map(static function ($product) {
            $product['total_count'] = $product->carts->count();
            return $product;
        });

        $checkedOuts->map(static function ($product) {
            $product['total_count'] = $product->carts->sum('count');
            return $product;
        });

        return [
            'removedProducts' => $removed,
            'checkedOutProduct' => $checkedOuts
        ];
    }
}
