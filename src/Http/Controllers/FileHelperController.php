<?php

namespace Keltron\Filehelper\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Keltron\Filehelper\Filehelper;

class FileHelperController extends Controller
{
    public function index(Request $request)
    {
        $directories = Storage::directories();
        $files = Storage::files();
        return view('keltron::pages.file_helper_dashboard', compact('directories', 'files'));
    }

    public function openFolder(Request $request)
    {
        $directories = Storage::directories($request->directory);
        $files = Storage::files($request->directory);
        return json_encode([
            'directories' => $directories,
            'files' => $files,
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file_upload');
        $file_name = $request->name;

        $res = Filehelper::putFile('testfiles', $file, $file_name);
        return json_encode($res);

    }

    public function download(Request $request)
    {
        // return Storage::download('testfiles/18958255.jpg');
    }
}
