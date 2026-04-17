<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings'   => 'nullable|array',
            'settings.*' => 'nullable|string|max:500',
        ]);

        $submitted = $data['settings'] ?? [];

        // Unchecked boolean checkboxes are absent from POST — explicitly set them to '0'
        $booleanKeys = Setting::where('type', 'boolean')->pluck('key');
        foreach ($booleanKeys as $key) {
            if (!array_key_exists($key, $submitted)) {
                $submitted[$key] = '0';
            }
        }

        foreach ($submitted as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value ?? '']);
        }

        ActivityLogger::log('settings_updated', null, null, [
            'keys' => array_keys($submitted),
        ]);

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }
}
