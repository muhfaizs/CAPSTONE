<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeCertificateController extends Controller
{
    public function create()
    {
        $businessUnits = \App\Models\BusinessUnit::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();

        return view('employee.certificate.create', compact('businessUnits', 'qualifications', 'lsps'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:255',
                'lsp' => 'nullable|string|max:255',
                'certificate_registration_number' => 'nullable|string|max:255',
                'issue_date' => 'nullable|date|before_or_equal:today',
                'expiry_date' => 'nullable|date|after_or_equal:issue_date',
                'certificate_file' => 'required|file|mimes:pdf|max:7168', // 7168 KB = 7 MB
            ], [
                'name.required' => 'Nama harus diisi.',
                'issue_date.before_or_equal' => 'Tanggal dikeluarkan tidak boleh di masa depan.',
                'expiry_date.after_or_equal' => 'Tanggal berlaku tidak boleh lebih awal dari tanggal dikeluarkan.',
                'certificate_file.required' => 'File sertifikat harus diupload.',
                'certificate_file.mimes' => 'File harus berformat PDF.',
                'certificate_file.max' => 'Ukuran file maksimal 7MB.',
            ]);

            $data = $request->all();
            // Mapping field agar sesuai dengan database
            $data['full_name'] = $request->input('name');
            
            // Handle file upload for manual entry
            if ($request->hasFile('certificate_file')) {
                $path = $request->file('certificate_file')->store('certificates', 'public');
                $data['file_path'] = $path;
            }

            Certificate::create($data);

            // Return JSON response untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request) {
        $query = \App\Models\Certificate::query();
        
        // Filter hanya sertifikat milik user yang sedang login (berdasarkan nama yang diinput saat membuat sertifikat)
        // Tidak strict filter, jadi employee bisa input nama lengkap yang berbeda
        // Kita filter berdasarkan user_id jika ada, atau nama
        $user = Auth::user();
        
        // Search functionality
        if ($request->has('q') && $request->q !== null && $request->q !== '') {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('full_name', 'like', "%$q%")
                    ->orWhere('certificate_registration_number', 'like', "%$q%")
                    ->orWhere('qualification', 'like', "%$q%")
                    ->orWhere('lsp', 'like', "%$q%");
            });
        }
        
        // Filter LSP
        if ($request->has('lsp') && $request->lsp !== null && $request->lsp !== '') {
            $query->where('lsp', $request->lsp);
        }

        // Filter Qualification
        if ($request->has('qualification') && $request->qualification !== null && $request->qualification !== '') {
            $query->where('qualification', $request->qualification);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $certificates = $query->paginate(10);
        
        // Get filter options
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();

        return view('employee.certificate.search', compact('certificates', 'lsps', 'qualifications'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = \App\Models\Certificate::query();
        
        // Employee bisa lihat semua sertifikat yang mereka buat
        $user = Auth::user();
        
        if ($request->has('q') && $request->q !== null && $request->q !== '') {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('full_name', 'like', "%$q%")
                    ->orWhere('certificate_registration_number', 'like', "%$q%")
                    ->orWhere('qualification', 'like', "%$q%")
                    ->orWhere('lsp', 'like', "%$q%");
            });
        }
        
        if ($request->has('lsp') && $request->lsp !== null && $request->lsp !== '') {
            $query->where('lsp', $request->lsp);
        }

        if ($request->has('qualification') && $request->qualification !== null && $request->qualification !== '') {
            $query->where('qualification', $request->qualification);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $certificates = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $certificates->items(),
            'pagination' => [
                'total' => $certificates->total(),
                'per_page' => $certificates->perPage(),
                'current_page' => $certificates->currentPage(),
                'last_page' => $certificates->lastPage(),
                'from' => $certificates->firstItem(),
                'to' => $certificates->lastItem()
            ]
        ]);
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        // Employee bisa edit sertifikat yang mereka buat
        // Tidak perlu strict check pada nama, karena employee bisa input nama lengkap berbeda

        $businessUnits = \App\Models\BusinessUnit::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();

        return view('employee.certificate.edit', compact('certificate', 'businessUnits', 'qualifications', 'lsps'));
    }

    public function update(Request $request, $id)
    {
        try {
            $certificate = Certificate::findOrFail($id);
            
            // Employee bisa update sertifikat yang mereka buat (tidak perlu strict check)

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:255',
                'lsp' => 'nullable|string|max:255',
                'certificate_registration_number' => 'nullable|string|max:255',
                'issue_date' => 'nullable|date|before_or_equal:today',
                'expiry_date' => 'nullable|date|after_or_equal:issue_date',
                'certificate_file' => 'nullable|file|mimes:pdf|max:7168',
            ]);

            $data = $request->all();
            $data['full_name'] = $request->input('name');
            
            if ($request->hasFile('certificate_file')) {
                // Delete old file if exists
                if ($certificate->file_path) {
                    Storage::disk('public')->delete($certificate->file_path);
                }
                $path = $request->file('certificate_file')->store('certificates', 'public');
                $data['file_path'] = $path;
            }

            $certificate->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $certificate = Certificate::findOrFail($id);
            
            // Employee bisa delete sertifikat yang mereka buat (tidak perlu strict check)

            // Delete file if exists
            if ($certificate->file_path) {
                Storage::disk('public')->delete($certificate->file_path);
            }

            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
