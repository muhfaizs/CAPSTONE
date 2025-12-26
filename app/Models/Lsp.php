<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lsp extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'license_number',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'lsp', 'name');
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
