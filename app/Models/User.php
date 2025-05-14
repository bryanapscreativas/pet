<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'whatsapp',
        'profile_picture_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'profile_picture_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getProfilePictureUrlAttribute(): ?string
    {
        if ($this->profile_picture_path) {
            return route('profile_picture', $this);
        }

        return null;
    }

    /**
     * Obtener las mascotas del usuario.
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    /**
     * Obtener las enfermedades del usuario a través de sus mascotas.
     */
    public function diseases()
    {
        return $this->hasManyThrough(
            Disease::class,
            Pet::class,
            'user_id', // Clave foránea en la tabla pets
            'id', // Clave local en la tabla diseases
            'id', // Clave local en la tabla users
            'id' // Clave foránea en la tabla diseases_pet
        )->distinct();
    }

    /**
     * Obtener los tratamientos del usuario a través de sus mascotas.
     */
    public function treatments()
    {
        return $this->hasManyThrough(
            Treatment::class,
            Pet::class,
            'user_id', // Clave foránea en la tabla pets
            'id', // Clave local en la tabla treatments
            'id', // Clave local en la tabla users
            'id' // Clave foránea en la tabla pet_treatment
        )->distinct();
    }
}
