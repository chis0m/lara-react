<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Checkout
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\CheckoutFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout newQuery()
 * @method static \Illuminate\Database\Query\Builder|Checkout onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Checkout withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Checkout withoutTrashed()
 * @mixin Eloquent
 * @property int $cart_id
 * @property-read Cart $cart
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Checkout whereCartId($value)
 */
class Checkout extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];


    /**
     * @return BelongsTo
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
