<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CardImageTemplate;
use Illuminate\Support\Facades\Validator;

class CardImageController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'event_info_id' => 'required|integer|exists:event_infos,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imagePath = $request->file('image')->store('images', 'public');

        $image = new CardImageTemplate();
        $image->name = $request->input('name');
        $image->event_info_id =$request->input('event_info_id');
        $image->path = $imagePath;
        $image->save();

        return response()->json(['success' => 'Image uploaded successfully']);
    }
}
