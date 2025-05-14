<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Pet extends Model
{
    use HasUlids;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'species',
        'breed',
        'gender',
        'description',
        'sterilized',
        'birth_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'sterilized' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the pet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The diseases that belong to the pet.
     * Enfermedades
     */
    public function diseases()
    {
        return $this->belongsToMany(Disease::class)
            ->withPivot(['diagnosis_date', 'treatment', 'notes'])
            ->withTimestamps();
    }

    /**
     * The treatments that belong to the pet.
     * Tratamientos
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class)
            ->withPivot(['start_date', 'end_date', 'dosage', 'frequency', 'notes', 'is_completed'])
            ->withTimestamps();
    }
}
