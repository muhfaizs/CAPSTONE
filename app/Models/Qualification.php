<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'level',
        'lsp_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'qualification', 'name');
    }

    public function lsp()
    {
        return $this->belongsTo(Lsp::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
