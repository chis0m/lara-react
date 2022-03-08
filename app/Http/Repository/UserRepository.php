<?php

namespace App\Http\Repository;

use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use Exception;

class UserRepository
{
    public const CACHE_KEY = 'users';

    public static function index()
    {
        try {
            return Cache::tags(self::CACHE_KEY)
                ->remember(
                    self::CACHE_KEY,
                    Carbon::now()->addMinutes(30),
                    static function () {
                        return UserResource::collection(User::get());
                    }
                );
        } catch (Exception $e) {
            return UserResource::collection(User::get());
        }
    }

    public static function clearCache(): void
    {
        $cacheKey = self::CACHE_KEY;
        Cache::tags($cacheKey)->flush();
    }
}
