<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
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
     * The pets that belong to the disease.
     */
    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class)
            ->withPivot('diagnosis_date', 'notes')
            ->withTimestamps();
    }
}
