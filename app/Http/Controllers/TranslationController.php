<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    
    public function transLanguageList(){
        $admin = auth()->user();
        $user = $admin->user;

        return view('/admin/languages', compact('user'));
    }
    public function updateTranslationStatus(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->translation_status = $request->has('transStatus') ? 1 : null;
        $language->save();

        return redirect()->back();
    }
    public function updateTranslation(Request $request)
    {
        $id = $request->input('id');
        $field = $request->input('field');
        $text = $request->input('text');

        $translation = Translation::findOrFail($id);
        $translation->$field = $text;
        $translation->save();

        return response()->json(['success' => true]);
    }
    public function removeTranslation(Request $request)
        {
            $id = $request->input('id');

            try {
                $translation = Translation::findOrFail($id);
                $translation->delete();

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete translation'], 500);
            }
        }
}
