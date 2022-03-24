<?php

namespace Keltron\Filehelper\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileHelperAuthController extends Controller
{
    public function login()
    {
        return view('keltron::pages.file_helper_login');
    }

    public function auth(Request $request)
    {
        $validated = validator($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        if ($request->username == config('filehelper.username') && $request->password == config('filehelper.password')) {
            session()->put('filehelper_user', $request->username);
            return redirect('/files/file_helper_dashboard');
        } else {
            return redirect()->back()->withErrors(['Invalid username or password'])->withInput();
        }
    }

    public function logout()
    {
        session()->forget('filehelper_user');
        return redirect('/files/file_helper_login');
    }
}
