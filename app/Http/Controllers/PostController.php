<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function uploadImage(Request $request)
    {

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }
}
