<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Frisbee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "price",
        "description",
        "range",
        "process"
    ];

    /**
     * @return BelongsToMany
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }
}
