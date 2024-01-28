<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Spatie\ImageOptimizer\Image;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\ImageOptimizer\Optimizers\Pngquant;


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

    public function updatePhoto(Request $request) {
        $this->validate($request, [
			'file' => 'required'
		]);
        $user = auth()->user();
        $file = $request->file('file');
		$tujuan_upload = 'assets/img/users';
        $file_name = (auth()->user()->email).'.png';
		$path = $file->move($tujuan_upload,$file_name);
        Files::where('email', '=', auth()->user()->email)->update(['path' => $path]);
        User::where('email', '=', auth()->user()->email)->update(['foto_profile' => $path]);

        $optimizer = new OptimizerChain();
        $optimizer->setTimeout(10);
        $optimizer->addOptimizer((new Pngquant([
            '--all-progressive',
        ]))->setBinaryPath($path));

        return redirect()->route('user');
    }

    public function deletePhoto() {
        if (!(auth()->check())) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        File::delete($user->foto_profile);
        Files::where('email', '=', auth()->user()->email)->update(['path' => '/assets/img/users/user_default.png']);
        User::where('email', '=', auth()->user()->email)->update(['foto_profile' => '/assets/img/users/user_default.png']);
        return redirect()->route('user');
    }
}
