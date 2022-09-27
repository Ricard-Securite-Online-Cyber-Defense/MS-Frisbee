<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Process extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["name", "description"];

    /**
     * @return BelongsTo
     */
    public function frisbee(): BelongsTo
    {
        return $this->belongsTo(Frisbee::class);
    }

    /**
     * @return BelongsToMany
     */
    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(Step::class);
    }
}
