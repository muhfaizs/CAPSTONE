<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CertificateImport;

class CertificateController extends Controller
{
    public function create()
    {
        $businessUnits = \App\Models\BusinessUnit::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();

        return view('certificate.create', compact('businessUnits', 'qualifications', 'lsps'));
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
            // Track who created this certificate
            $data['created_by_user_id'] = \Illuminate\Support\Facades\Auth::id();
            
            // Handle file upload - store as Base64 in database for Vercel compatibility
            if ($request->hasFile('certificate_file')) {
                $file = $request->file('certificate_file');
                
                // Store file content as Base64 in database (for Vercel serverless)
                $data['file_content'] = base64_encode(file_get_contents($file->getRealPath()));
                $data['file_mime_type'] = $file->getMimeType();
                $data['file_name'] = $file->getClientOriginalName();
                
                // Also try to store in filesystem (works locally, may not persist on Vercel)
                try {
                    $path = $file->store('certificates', 'public');
                    $data['file_path'] = $path;
                } catch (\Exception $e) {
                    // Filesystem storage failed (expected on Vercel), continue with DB storage
                    $data['file_path'] = null;
                }
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
        
        // Search functionality
        if ($request->has('q') && $request->q !== null && $request->q !== '') {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('full_name', 'like', "%$q%")
                    ->orWhere('certificate_registration_number', 'like', "%$q%")
                    ->orWhere('qualification', 'like', "%$q%")
                    ->orWhere('company_name', 'like', "%$q%")
                    ->orWhere('lsp', 'like', "%$q%")
                ;
            });
        }
        
        // Filter LSP
        if ($request->has('lsp') && $request->lsp !== null && $request->lsp !== '') {
            $query->where('lsp', $request->lsp);
        }

        // Filter Business Unit
        if ($request->has('business_unit') && $request->business_unit !== null && $request->business_unit !== '') {
            $query->where('company_name', $request->business_unit);
        }

        // Filter Qualification
        if ($request->has('qualification') && $request->qualification !== null && $request->qualification !== '') {
            $query->where('qualification', $request->qualification);
        }

        // Initialize variables
        $isFromNotification = false;
        $isFromExpiredNotification = false;

        // Filter status
        if ($request->status == 'active') {
            $query->where(function($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>', now());
            });
        } elseif ($request->status == 'expired') {
            $query->where('expiry_date', '<', now());

            // Jika dari notification (hanya status=expired tanpa filter tambahan), limit seperti dashboard (10 records)
            $isFromExpiredNotification = $request->status == 'expired' &&
                                       (!$request->has('q') || empty($request->q)) &&
                                       (!$request->has('lsp') || empty($request->lsp)) &&
                                       (!$request->has('business_unit') || empty($request->business_unit)) &&
                                       (!$request->has('qualification') || empty($request->qualification)) &&
                                       (!$request->has('sort') || $request->sort == 'desc');

            if ($isFromExpiredNotification) {
                $query->limit(10);
            }
        } elseif ($request->status == 'expiring' || $request->status == 'expiring_soon') {
            $query->where('expiry_date', '>', now())
                  ->where('expiry_date', '<=', now()->addMonths(3));

            // Jika dari notification (hanya status=expiring_soon tanpa filter tambahan), limit seperti dashboard (10 records)
            $isFromNotification = $request->status == 'expiring_soon' &&
                                (!$request->has('q') || empty($request->q)) &&
                                (!$request->has('lsp') || empty($request->lsp)) &&
                                (!$request->has('business_unit') || empty($request->business_unit)) &&
                                (!$request->has('qualification') || empty($request->qualification)) &&
                                (!$request->has('sort') || $request->sort == 'desc');

            if ($isFromNotification) {
                $query->limit(10);
            }
        }

        // Sort functionality
        if ($isFromNotification) {
            // Jika dari notification expiring_soon, sort seperti dashboard (by expiry_date asc)
            $query->orderBy('expiry_date', 'asc');
        } elseif ($isFromExpiredNotification) {
            // Jika dari notification expired, sort seperti dashboard (by expiry_date desc)
            $query->orderBy('expiry_date', 'desc');
        } elseif ($request->sort == 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $certificates = $query->get();
        
        // Check if it's an AJAX request - multiple detection methods
        if ($request->ajax() || $request->wantsJson()) {


            // Convert certificates to array and ensure proper JSON format
            $certificatesArray = $certificates->map(function($cert) {
                // Safely handle date formatting - check if it's already a string or Carbon object
                $issueDate = $cert->issue_date;
                $expiryDate = $cert->expiry_date;

                // Convert to string format if it's a Carbon/DateTime object
                if ($issueDate && is_object($issueDate)) {
                    $issueDate = $issueDate->format('Y-m-d');
                }
                if ($expiryDate && is_object($expiryDate)) {
                    $expiryDate = $expiryDate->format('Y-m-d');
                }

                return [
                    'id' => $cert->id,
                    'full_name' => $cert->full_name,
                    'company_name' => $cert->company_name,
                    'qualification' => $cert->qualification,
                    'lsp' => $cert->lsp,
                    'certificate_registration_number' => $cert->certificate_registration_number,
                    'issue_date' => $issueDate,
                    'expiry_date' => $expiryDate,
                    'file_path' => $cert->file_path,
                ];
            });

            return response()->json([
                'success' => true,
                'certificates' => $certificatesArray,
                'count' => $certificates->count()
            ]);
        }

        $businessUnits = \App\Models\BusinessUnit::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();

        return view('certificate.search', compact('certificates', 'businessUnits', 'qualifications', 'lsps'));
    }





    public function previewExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $import = new CertificateImport();
            $data = Excel::toArray($import, $request->file('file'))[0];
            
            // Format data for display
            $formattedData = [];
            foreach ($data as $row) {
                $formattedData[] = [
                    $row['name'] ?? '',
                    $row['company'] ?? '',
                    $row['qualification'] ?? '',
                    $row['lsp'] ?? '',
                    $row['certificate_number'] ?? '',
                    $row['issue_date'] ?? '',
                    $row['expiry_date'] ?? ''
                ];
            }
            
            return $this->formatPreviewTable($formattedData);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error reading Excel file: ' . $e->getMessage()
            ], 422);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $file = $request->file('excel_file');
            
            // Parse XLSX manually (XLSX is a ZIP file with XML content)
            $rows = $this->parseXlsxFile($file->getRealPath());
            
            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File Excel kosong atau format tidak valid'
                ], 422);
            }
            
            // Get header row (first row) and convert to lowercase
            $headers = array_map(function($h) {
                return strtolower(trim(str_replace(['.', ' ', '/'], ['', '_', '_'], $h ?? '')));
            }, $rows[0]);
            
            $importedCount = 0;
            
            // Process data rows (skip header)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $data = [];
                
                // Map row values to headers
                foreach ($headers as $index => $header) {
                    $data[$header] = $row[$index] ?? null;
                }
                
                // Skip if required fields are empty
                if (empty($data['nama']) || empty($data['kualifikasi'])) {
                    continue;
                }
                
                // Create certificate
                Certificate::create([
                    'full_name' => $data['nama'] ?? null,
                    'company_name' => $data['perusahaan'] ?? null,
                    'qualification' => $data['kualifikasi'] ?? null,
                    'lsp' => $data['lsp'] ?? null,
                    'certificate_registration_number' => $data['no_registrasi'] ?? null,
                    'issue_date' => $this->parseExcelDate($data['dikeluarkan'] ?? null),
                    'expiry_date' => $this->parseExcelDate($data['berlaku_sd'] ?? null),
                ]);
                $importedCount++;
            }
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil mengimpor {$importedCount} data sertifikat!",
                'redirect' => route('certificate.search')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing data: ' . $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Parse XLSX file manually without temp directory requirement
     */
    private function parseXlsxFile($filePath)
    {
        $rows = [];
        
        // Read file content into memory
        $fileContent = file_get_contents($filePath);
        
        // Create temp file in /tmp (writable on Vercel)
        $tmpFile = '/tmp/xlsx_' . uniqid() . '.xlsx';
        file_put_contents($tmpFile, $fileContent);
        
        $zip = new \ZipArchive();
        if ($zip->open($tmpFile) !== true) {
            @unlink($tmpFile);
            throw new \Exception('Cannot open XLSX file');
        }
        
        // Read shared strings (for cell values)
        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml) {
            $xml = simplexml_load_string($sharedStringsXml);
            foreach ($xml->si as $si) {
                if (isset($si->t)) {
                    $sharedStrings[] = (string)$si->t;
                } elseif (isset($si->r)) {
                    $text = '';
                    foreach ($si->r as $r) {
                        $text .= (string)$r->t;
                    }
                    $sharedStrings[] = $text;
                }
            }
        }
        
        // Read worksheet
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXml) {
            $zip->close();
            @unlink($tmpFile);
            throw new \Exception('Cannot read worksheet');
        }
        
        $xml = simplexml_load_string($sheetXml);
        
        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            $maxCol = 0;
            
            foreach ($row->c as $cell) {
                $cellRef = (string)$cell['r'];
                $colIndex = $this->columnToIndex($cellRef);
                $maxCol = max($maxCol, $colIndex);
                
                // Fill gaps with null
                while (count($rowData) < $colIndex) {
                    $rowData[] = null;
                }
                
                $value = null;
                $type = (string)$cell['t'];
                
                if ($type === 's') {
                    // Shared string
                    $index = (int)$cell->v;
                    $value = $sharedStrings[$index] ?? null;
                } elseif ($type === 'inlineStr') {
                    $value = (string)$cell->is->t;
                } else {
                    $value = (string)$cell->v;
                }
                
                $rowData[$colIndex] = $value;
            }
            
            if (!empty(array_filter($rowData))) {
                $rows[] = $rowData;
            }
        }
        
        $zip->close();
        @unlink($tmpFile);
        
        return $rows;
    }
    
    /**
     * Convert Excel column reference to index (A=0, B=1, etc.)
     */
    private function columnToIndex($cellRef)
    {
        preg_match('/([A-Z]+)/', $cellRef, $matches);
        $col = $matches[1] ?? 'A';
        $index = 0;
        $length = strlen($col);
        for ($i = 0; $i < $length; $i++) {
            $index = $index * 26 + (ord($col[$i]) - ord('A') + 1);
        }
        return $index - 1;
    }
    
    private function parseExcelDate($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // If numeric (Excel serial date)
        if (is_numeric($value)) {
            // Excel date serial number to Unix timestamp
            // Excel dates start from 1900-01-01, Unix from 1970-01-01
            $unixTimestamp = ($value - 25569) * 86400;
            return date('Y-m-d', $unixTimestamp);
        }
        
        // Try various date formats
        $formats = ['d-M-y', 'd-M-Y', 'd/m/Y', 'd/m/y', 'Y-m-d'];
        foreach ($formats as $format) {
            $dt = \DateTime::createFromFormat($format, $value);
            if ($dt) {
                return $dt->format('Y-m-d');
            }
        }
        
        // Try strtotime
        $timestamp = strtotime(str_replace('/', '-', $value));
        if ($timestamp) {
            return date('Y-m-d', $timestamp);
        }
        
        return null;
    }

    public function previewPdf(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return '<div class="alert alert-danger">No file uploaded.</div>';
        }
        // Gunakan spatie/pdf-to-text untuk ekstrak teks
        try {
            $text = (new \Spatie\PdfToText\Pdf())->setPdf($file->getPathname())->text();
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Failed to read PDF: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        // Ekstrak baris data (asumsi satu baris satu record, dipisah tab/koma)
        $lines = preg_split('/\r?\n/', $text);
        $data = [];
        foreach ($lines as $line) {
            $row = preg_split('/\t|,/', $line);
            if (count($row) >= 7 && !empty($row[0]) && !empty($row[2])) {
                $data[] = array_slice($row, 0, 7);
            }
        }
        if (count($data) < 1) {
            return '<div class="alert alert-warning">No data found in PDF.</div>';
        }
        $headers = [
            'NAMA', 'PERUSAHAAN', 'KUALIFIKASI', 'LSP', 'NO. REGISTRASI', 'DIKELUARKAN', 'BERLAKU S/D'
        ];
        $html = '';
        $html .= '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';
        $html .= '<div class="text-end mt-3">'
            .'<button type="button" class="btn btn-secondary me-2" id="previewAgainBtn">Preview</button>'
            .'<button type="button" class="btn btn-success" id="importPdfBtn">Submit</button>'
            .'</div>';
        return $html;
    }


    public function importPdf(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return response()->json(['success' => false, 'message' => 'No file uploaded.']);
        }
        try {
            $text = (new \Spatie\PdfToText\Pdf())->setPdf($file->getPathname())->text();
            $lines = preg_split('/\r?\n/', $text);
            foreach ($lines as $line) {
                $row = preg_split('/\t|,/', $line);
                if (count($row) >= 7 && !empty($row[0]) && !empty($row[2])) {
                    \App\Models\Certificate::create([
                        'full_name' => $row[0],
                        'company_name' => $row[1],
                        'qualification' => $row[2],
                        'lsp' => $row[3],
                        'certificate_registration_number' => $row[4],
                        'issue_date' => $row[5],
                        'expiry_date' => $row[6],
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Import failed: ' . $e->getMessage()]);
        }
        return response()->json(['success' => true, 'redirect' => route('certificate.search')]);
    }

    public function edit(\App\Models\Certificate $certificate)
    {
        $businessUnits = \App\Models\BusinessUnit::active()->orderBy('name')->get();
        $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
        $lsps = \App\Models\Lsp::active()->orderBy('name')->get();

        return view('certificate.edit', compact('certificate', 'businessUnits', 'qualifications', 'lsps'));
    }

    public function update(Request $request)
    {
        $certificate = Certificate::find($request->certificate_id);
    
    if (!$certificate) {
        return response()->json([
            'success' => false,
            'message' => 'Certificate not found'
        ], 404);
    }
        try {
            $data = $request->validate([
                'full_name' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:255',
                'lsp' => 'nullable|string|max:255',
                'certificate_registration_number' => 'nullable|string|max:255',
                'issue_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
            ]);

            // Get certificate ID from request
            $certificateId = $request->input('certificate_id') ?? $request->route('certificate');
            if (is_object($certificateId)) {
                $certificateId = $certificateId->id;
            }
            
            $certificate = \App\Models\Certificate::findOrFail($certificateId);

            // Handle file upload if present - store as Base64 in database for Vercel
            if ($request->hasFile('certificate_file')) {
                $file = $request->file('certificate_file');
                
                // Store file content as Base64 in database (for Vercel serverless)
                $data['file_content'] = base64_encode(file_get_contents($file->getRealPath()));
                $data['file_mime_type'] = $file->getMimeType();
                $data['file_name'] = $file->getClientOriginalName();
                
                // Delete old file if exists
                if ($certificate->file_path && \Storage::disk('public')->exists($certificate->file_path)) {
                    \Storage::disk('public')->delete($certificate->file_path);
                }
                
                // Also try to store in filesystem (works locally, may not persist on Vercel)
                try {
                    $path = $file->store('certificates', 'public');
                    $data['file_path'] = $path;
                } catch (\Exception $e) {
                    // Filesystem storage failed (expected on Vercel), continue with DB storage
                    $data['file_path'] = null;
                }
            }

            $certificate->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Certificate $certificate)
    {
        try {
            // Hapus file jika ada
            if ($certificate->file_path) {
                Storage::delete('public/' . $certificate->file_path);
            }
            
            $certificate->delete();
            
            return redirect()->route('certificate.search')
                ->with('success', 'Certificate deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('certificate.search')
                ->with('error', 'Error deleting certificate: ' . $e->getMessage());
        }
    }


    public function bulkDelete(Request $request)
    {
        try {
            // Handle both array and single value formats
            $certificateIds = $request->input('certificate_ids', []);
            
            // If it's not an array, make it an array
            if (!is_array($certificateIds)) {
                $certificateIds = [$certificateIds];
            }
            
            // Filter out empty values
            $certificateIds = array_filter($certificateIds, function($id) {
                return !empty($id);
            });
            
            if (empty($certificateIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No certificates selected for deletion.'
                ]);
            }

            \Log::info('Bulk delete request', ['certificate_ids' => $certificateIds]);

            // Get certificates with file paths before deletion
            $certificates = \App\Models\Certificate::whereIn('id', $certificateIds)->get();
            
            \Log::info('Found certificates to delete', ['count' => $certificates->count()]);
            
            // Delete associated files from storage
            foreach ($certificates as $certificate) {
                if ($certificate->file_path && Storage::disk('public')->exists($certificate->file_path)) {
                    Storage::disk('public')->delete($certificate->file_path);
                    \Log::info('Deleted file', ['file_path' => $certificate->file_path]);
                }
            }
            
            // Delete certificates from database
            $deletedCount = \App\Models\Certificate::whereIn('id', $certificateIds)->delete();
            
            \Log::info('Deleted certificates from database', ['count' => $deletedCount]);
            
            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' certificate(s) deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Bulk delete error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error deleting certificates: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeBusinessUnit(Request $request)
    {
        \Log::info('Store Business Unit called', $request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:10|unique:business_units,code',
                'abbreviation' => 'nullable|string|max:50',
                'is_active' => 'nullable'
            ]);

            $businessUnit = \App\Models\BusinessUnit::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['abbreviation'], // Using description field for abbreviation
                'is_active' => $validated['is_active'] ? true : false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Business Unit added successfully!',
                'data' => $businessUnit
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding business unit: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeQualification(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:10|unique:qualifications,code',
                'lsp_id' => 'nullable|exists:lsps,id',
                'is_active' => 'nullable'
            ]);

            $qualification = \App\Models\Qualification::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'level' => $validated['lsp_id'] ? \App\Models\Lsp::find($validated['lsp_id'])->name : null, // Store LSP name in level field for backward compatibility
                'lsp_id' => $validated['lsp_id'],
                'is_active' => $validated['is_active'] ? true : false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Qualification added successfully!',
                'data' => $qualification
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding qualification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeLsp(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'abbreviation' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'is_active' => 'nullable'
            ]);

            $lsp = \App\Models\Lsp::create([
                'name' => $validated['name'],
                'code' => $validated['abbreviation'], // Using code field for abbreviation
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'is_active' => $validated['is_active'] ? true : false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'LSP added successfully!',
                'data' => $lsp
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding LSP: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getQualificationsByLsp($lspId)
    {
        try {
            if ($lspId == 0 || $lspId == '') {
                // Return all active qualifications if no LSP selected
                $qualifications = \App\Models\Qualification::active()->orderBy('name')->get();
            } else {
                // Return qualifications for specific LSP
                $qualifications = \App\Models\Qualification::where('lsp_id', $lspId)
                    ->active()
                    ->orderBy('name')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'qualifications' => $qualifications
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching qualifications: ' . $e->getMessage()
            ], 500);
        }
    }
}