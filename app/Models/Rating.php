<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Rating extends Pivot
{
    protected $table = "ratings";
}
