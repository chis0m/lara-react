<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $status
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @property-read User $user
 * @method static \Database\Factories\CartFactory factory(...$parameters)
 * @method static Builder|Cart newModelQuery()
 * @method static Builder|Cart newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cart onlyTrashed()
 * @method static Builder|Cart query()
 * @method static Builder|Cart whereCreatedAt($value)
 * @method static Builder|Cart whereDeletedAt($value)
 * @method static Builder|Cart whereId($value)
 * @method static Builder|Cart whereProductId($value)
 * @method static Builder|Cart whereStatus($value)
 * @method static Builder|Cart whereUpdatedAt($value)
 * @method static Builder|Cart whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Cart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cart withoutTrashed()
 * @mixin Eloquent
 * @property-read Checkout|null $checkout
 * @property int $count
 * @method static Builder|Cart whereCount($value)
 */
class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const ADDED = 1;
    public const REMOVED = 2;
    public const CHECKED_OUT = 3;

    protected $guarded = [];


    /**
     * @return Builder|Cart
     */
    public static function removed(): Builder|Cart
    {
        return self::whereStatus(self::REMOVED);
    }

    /**
     * @return Builder|Cart
     */
    public static function checkedOut(): Builder|Cart
    {
        return self::whereStatus(self::CHECKED_OUT);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasOne
     */
    public function checkout(): HasOne
    {
        return $this->hasOne(Checkout::class);
    }

    /**
     * @param int $status
     * @return string
     */
    public static function statusToString(int $status): string
    {
        return match ($status) {
            self::ADDED => 'added',
            self::REMOVED => 'removed',
            self::CHECKED_OUT => 'checked_out',
            default => 'added',
        };
    }

    /**
     * @return bool
     */
    public function isCheckedOut(): bool
    {
        return $this->status === self::CHECKED_OUT;
    }
}
