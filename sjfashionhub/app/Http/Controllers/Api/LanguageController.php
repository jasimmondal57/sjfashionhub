<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    /**
     * Get current language settings
     */
    public function getLanguage(Request $request)
    {
        $user = $request->user();
        $currentLanguage = $user ? $user->preferred_language : 'en';
        
        $languages = $this->getAvailableLanguages();
        
        return response()->json([
            'success' => true,
            'data' => [
                'current_language' => $currentLanguage,
                'available_languages' => $languages,
                'default_language' => 'en'
            ]
        ]);
    }

    /**
     * Set user language preference
     */
    public function setLanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|string|in:en,es,fr,de,it,pt,ar,zh,ja,ko,hi,ru'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        
        if ($user) {
            $user->update(['preferred_language' => $request->language]);
        }

        // Store in session for guest users
        session(['preferred_language' => $request->language]);

        return response()->json([
            'success' => true,
            'message' => 'Language preference updated successfully',
            'data' => [
                'language' => $request->language
            ]
        ]);
    }

    /**
     * Get available languages
     */
    private function getAvailableLanguages()
    {
        return [
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'flag' => '🇺🇸',
                'is_rtl' => false
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'native_name' => 'Español',
                'flag' => '🇪🇸',
                'is_rtl' => false
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'native_name' => 'Français',
                'flag' => '🇫🇷',
                'is_rtl' => false
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'native_name' => 'Deutsch',
                'flag' => '🇩🇪',
                'is_rtl' => false
            ],
            [
                'code' => 'it',
                'name' => 'Italian',
                'native_name' => 'Italiano',
                'flag' => '🇮🇹',
                'is_rtl' => false
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'native_name' => 'Português',
                'flag' => '🇵🇹',
                'is_rtl' => false
            ],
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'flag' => '🇸🇦',
                'is_rtl' => true
            ],
            [
                'code' => 'zh',
                'name' => 'Chinese',
                'native_name' => '中文',
                'flag' => '🇨🇳',
                'is_rtl' => false
            ],
            [
                'code' => 'ja',
                'name' => 'Japanese',
                'native_name' => '日本語',
                'flag' => '🇯🇵',
                'is_rtl' => false
            ],
            [
                'code' => 'ko',
                'name' => 'Korean',
                'native_name' => '한국어',
                'flag' => '🇰🇷',
                'is_rtl' => false
            ],
            [
                'code' => 'hi',
                'name' => 'Hindi',
                'native_name' => 'हिन्दी',
                'flag' => '🇮🇳',
                'is_rtl' => false
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'native_name' => 'Русский',
                'flag' => '🇷🇺',
                'is_rtl' => false
            ]
        ];
    }
}
