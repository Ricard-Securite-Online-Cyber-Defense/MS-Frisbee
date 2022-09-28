<?php

namespace App\Services;

use App\Models\Range;

class RangeService
{
    public function createRange($range) {
        return Range::firstOrCreate(
            ["name" => $range["name"]],
            $range,
        );
    }
}
