<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lsp;
use App\Models\BusinessUnit;
use App\Models\Qualification;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getStats()
    {
        // Get LSP statistics with certificate counts
        $lspStats = Lsp::withCount(['qualifications', 'certificates'])->get()->map(function($lsp) {
            return [
                'name' => $lsp->name,
                'code' => $lsp->code,
                'qualifications_count' => $lsp->qualifications_count,
                'certificates_count' => $lsp->certificates_count,
                'percentage' => $lsp->certificates_count > 0 ? round(($lsp->certificates_count / Certificate::count()) * 100, 1) : 0
            ];
        });

        // Get Business Unit statistics with certificate counts
        $businessUnitStats = BusinessUnit::withCount(['certificates'])->get()->map(function($unit) {
            return [
                'name' => $unit->name,
                'code' => $unit->code,
                'certificates_count' => $unit->certificates_count,
                'percentage' => $unit->certificates_count > 0 ? round(($unit->certificates_count / Certificate::count()) * 100, 1) : 0
            ];
        });

        // Get Qualification statistics with certificate counts
        $qualificationStats = Qualification::withCount(['certificates'])->get()->map(function($qual) {
            return [
                'name' => $qual->name,
                'code' => $qual->code,
                'lsp_name' => $qual->lsp ? $qual->lsp->name : 'No LSP',
                'certificates_count' => $qual->certificates_count,
                'percentage' => $qual->certificates_count > 0 ? round(($qual->certificates_count / Certificate::count()) * 100, 1) : 0
            ];
        });

        // Overall statistics
        $totalCertificates = Certificate::count();
        $totalLsps = Lsp::count();
        $totalBusinessUnits = BusinessUnit::count();
        $totalQualifications = Qualification::count();

        // Get certificates expiring soon (within 3 months)
        $threeMonthsFromNow = now()->addMonths(3);
        $expiringSoonCertificates = Certificate::where('expiry_date', '>=', now())
            ->where('expiry_date', '<=', $threeMonthsFromNow)
            ->orderBy('expiry_date', 'asc')
            ->limit(10)
            ->get(['full_name', 'company_name', 'expiry_date']);

        // Get expired certificates
        $expiredCertificates = Certificate::where('expiry_date', '<', now())
            ->orderBy('expiry_date', 'desc')
            ->limit(10)
            ->get(['full_name', 'company_name', 'expiry_date']);

        return response()->json([
            'lsp_stats' => $lspStats,
            'business_unit_stats' => $businessUnitStats,
            'qualification_stats' => $qualificationStats,
            'expiring_soon' => $expiringSoonCertificates,
            'expired' => $expiredCertificates,
            'summary' => [
                'total_certificates' => $totalCertificates,
                'total_lsps' => $totalLsps,
                'total_business_units' => $totalBusinessUnits,
                'total_qualifications' => $totalQualifications,
                'expiring_soon_count' => $expiringSoonCertificates->count(),
                'expired_count' => $expiredCertificates->count()
            ]
        ]);
    }
}
