<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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
		$file = $request->file('file');
        return response()->json(['status' => true,'message' => 'File uploaded', 'path' => $file]);;
    }

    public function updatePhoto(Request $request) {
        $this->validate($request, [
			'file' => 'required'
		]);
        $user = auth()->user();
        $original = $request->file('file');
        $file = Image::make($original)
        ->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->orientate()
        ->encode($original->getClientOriginalExtension(), 40);
		$tujuan_upload = 'assets/img/users';
        $file_name = (auth()->user()->email).'.'.$original->getClientOriginalExtension();
		$path = 'assets/img/users/'.$file_name;//$file->move($tujuan_upload,$file_name);
        $file->save(public_path($path));
        Files::where('email', '=', auth()->user()->email)->update(['path' => $path]);
        User::where('email', '=', auth()->user()->email)->update(['foto_profile' => $path]);
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
