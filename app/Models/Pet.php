<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
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
            ->withTimestamps();
    }

    /**
     * The treatments that belong to the pet.
     * Tratamientos
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class)
            ->withTimestamps();
    }
}
