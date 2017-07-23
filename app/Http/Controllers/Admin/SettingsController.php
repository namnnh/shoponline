<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Settings\Updated as SettingsUpdated;
use Settings;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function general()
    {
        return view('admin.settings.general');
    }

    public function auth()
    {
        return view('admin.settings.auth');
    }

    public function notifications()
    {
        return view('admin.settings.notifications');
    }

    public function update(Request $request)
    {
        $this->updateSettings($request->except("_token"));

        return back()->withSuccess(trans('app.settings_updated'));
    }

    public function enableCaptcha()
    {
         $this->updateSettings(['registration.captcha.enabled' => true]);

        return back()->withSuccess(trans('app.recaptcha_enabled'));
    }

    public function disableCaptcha()
    {
        $this->updateSettings(['registration.captcha.enabled' => false]);

        return back()->withSuccess(trans('app.recaptcha_disabled'));
    }


    /**
    * ================= PRIVATE FUNCTION =====================
    */
    private function updateSettings($input)
    {
        foreach($input as $key => $value) {
            Settings::set($key, $value);
        }

        Settings::save();

        event(new SettingsUpdated);
    }
}
