<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Frisbee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "price",
        "description",
        "range_id",
        "process_id"
    ];

    /**
     * @return BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    /**
     * @return BelongsTo
     */
    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    /**
     * @return BelongsTo
     */
    public function range(): BelongsTo
    {
        return $this->belongsTo(Range::class);
    }
}
