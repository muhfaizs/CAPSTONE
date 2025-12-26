<?php
// app/Http/Controllers/LanguageController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Switch language via AJAX
     */
    public function switchLanguageAjax(Request $request)
    {
        $language = $request->input('language', 'en');
        
        // Validasi bahasa yang tersedia
        $availableLanguages = ['en', 'id'];
        
        if (in_array($language, $availableLanguages)) {
            // Set bahasa di session
            Session::put('locale', $language);
            
            // Set bahasa aplikasi untuk response ini
            App::setLocale($language);
            
            return response()->json([
                'success' => true,
                'message' => __('messages.language') . ' changed successfully',
                'language' => $language,
                'translations' => $this->getTranslations($language)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Language not supported'
        ], 400);
    }
    
    /**
     * Switch language via URL (fallback untuk non-AJAX)
     */
    public function switchLanguage($language)
    {
        $availableLanguages = ['en', 'id'];
        
        if (in_array($language, $availableLanguages)) {
            Session::put('locale', $language);
        }
        
        return Redirect::back();
    }
    
    /**
     * Get current language
     */
    public function getCurrentLanguage()
    {
        return response()->json([
            'current_language' => App::getLocale(),
            'translations' => $this->getTranslations(App::getLocale())
        ]);
    }
    
    /**
     * Get translations for JavaScript
     */
    private function getTranslations($language)
    {
        App::setLocale($language);
        
        return [
            'dashboard' => __('messages.dashboard'),
            'account' => __('messages.account'),
            'profile' => __('messages.profile'),
            'edit_password' => __('messages.edit_password'),
            'certification' => __('messages.certification'),
            'search_certificate' => __('messages.search_certificate'),
            'add_certificate' => __('messages.add_certificate'),
            'logout' => __('messages.logout'),
            'language' => __('messages.language'),
            'dark_mode' => __('messages.dark_mode'),
            'light_mode' => __('messages.light_mode'),
            'sidebar' => __('messages.sidebar'),
            'user' => __('messages.user'),
            'certification_overview' => __('messages.certification_overview'),
            'certification_status' => __('messages.certification_status'),
            'certified' => __('messages.certified'),
            'not_certified' => __('messages.not_certified'),
            'certification_types_per_employee' => __('messages.certification_types_per_employee'),
            'type_a' => __('messages.type_a'),
            'type_b' => __('messages.type_b'),
            'type_c' => __('messages.type_c'),
            'unassigned_certifications' => __('messages.unassigned_certifications'),
            'employee' => __('messages.employee'),
            'due_date' => __('messages.due_date'),
            'no_certifications_found' => __('messages.no_certifications_found'),
            'expired_certifications' => __('messages.expired_certifications'),
            'expiration_date' => __('messages.expiration_date'),
            'no_expired_certifications_found' => __('messages.no_expired_certifications_found')
        ];
    }
}