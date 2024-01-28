<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Traits\Upload; //import the trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FilesController extends Controller
{
    // use Upload;//add this trait

    // function create(Request $request) {
    //     Files::create([
    //         'path' => '123'
    //     ]);
    // }

    public function store(Request $request)
    {
        // $this->validate($request, [
		// 	'file' => 'required'
		// ]);

		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');
        return response()->json(['status' => true,'message' => 'File uploaded', 'path' => $file]);
        // Session::flash('file', $request->file);
        // $path = $this->UploadFile($request->file('file'), 'Products');//use the method in the trait
        // Files::create([
        //     'path' => $path
        // ]);
        // return response()->json(['status' => true,'message' => 'File uploaded', 'path' => $path]);
        // if ($request->hasFile('file')) {
        //     return response()->json(['status' => true,'message' => 'File uploaded']);
        //     $path = $this->UploadFile($request->file('file'), 'Products');//use the method in the trait
        //     Files::create([
        //         'path' => $path
        //     ]);
        //     return response()->json(['status' => true,'message' => 'File uploaded', 'path' => $path]);
        // }
        // return response()->json(['status' => false, 'message' => 'Upload failed', 'file' => $request->all()]);
    }
}
