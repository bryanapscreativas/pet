<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Treatment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The pets that belong to the treatment.
     */
    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class)
            ->withPivot([
                'start_date',
                'end_date',
                'dosage',
                'frequency',
                'notes',
                'is_completed',
            ])
            ->withTimestamps();
    }
}
