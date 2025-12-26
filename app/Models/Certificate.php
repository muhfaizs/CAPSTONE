<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'qualification',
        'lsp',
        'certificate_registration_number',
        'issue_date',
        'expiry_date',
        'file_path',
        // kolom lain jika ada
    ];
} 