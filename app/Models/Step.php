<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Step extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["name", "description"];

    /**
     * @return BelongsToMany
     */
    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class);
    }
}
