<?php

namespace App\Imports;

use App\Models\Certificate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CertificateImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        \Log::info('Import row:', $row);
        if (
            empty($row['nama']) ||
            empty($row['kualifikasi'])
        ) {
            return null;
        }
        return new Certificate([
            'full_name' => $row['nama'] ?? null,
            'company_name' => $row['perusahaan'] ?? null,
            'qualification' => $row['kualifikasi'] ?? null,
            'lsp' => $row['lsp'] ?? null,
            'certificate_registration_number' => $row['no_registrasi'] ?? null,
            'issue_date' => $this->excelDateToDate($row['dikeluarkan'] ?? null),
            'expiry_date' => $this->excelDateToDate($row['berlaku_sd'] ?? null),
        ]);
    }

    private function excelDateToDate($excelDate)
    {
        \Log::info('Parsing expiry_date:', ['value' => $excelDate]);
        if (is_string($excelDate) && strpos($excelDate, '=') === 0) {
            return null;
        }
        if (is_numeric($excelDate)) {
            return date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelDate));
        }
        if (is_string($excelDate)) {
            $timestamp = strtotime(str_replace('/', '-', $excelDate));
            if ($timestamp) {
                return date('Y-m-d', $timestamp);
            }
            $dt = \DateTime::createFromFormat('d-M-Y', $excelDate);
            if ($dt) {
                return $dt->format('Y-m-d');
            }
            $dt = \DateTime::createFromFormat('d-M-y', $excelDate);
            if ($dt) {
                return $dt->format('Y-m-d');
            }
            $dt = \DateTime::createFromFormat('d-M-Y', ucfirst($excelDate));
            if ($dt) {
                return $dt->format('Y-m-d');
            }
            $dt = \DateTime::createFromFormat('d-M-Y', strtoupper($excelDate));
            if ($dt) {
                return $dt->format('Y-m-d');
            }
        }
        return null;
    }
} 