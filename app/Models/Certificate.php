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
        'file_content',
        'file_mime_type',
        'file_name',
        // kolom lain jika ada
    ];

    /**
     * Check if the certificate has stored file content (for Vercel deployment)
     */
    public function hasFileContent(): bool
    {
        return !empty($this->file_content);
    }

    /**
     * Get the file URL - returns route to serve file from database if file_content exists
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->hasFileContent()) {
            return route('certificate.file', $this->id);
        }
        
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return null;
    }
} 