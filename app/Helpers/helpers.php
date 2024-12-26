<?php
use App\Models\Country;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\App;

if (!function_exists('translate')) {
    function translate($key)
    {
        $locale = App::getLocale();
        
        // If the locale is English, return the key itself
        if ($locale === 'en') {
            return $key; // Return the key_text directly as it is the English content
        }

        // Fetch the translation from the database for the current locale
        $translation = Translation::where('key_text', $key)->where('lang', $locale)->first();
        
        // Return the translation if found, otherwise return the key_text
        return $translation ? $translation->translate : $key;
    }
}
if (!function_exists('getCountries')) {
    function getCountries()
    {
        return Country::all();
    }
}

if (!function_exists('getLanguages')) {
    function getLanguages()
    {
        return Language::all();
    }
}

