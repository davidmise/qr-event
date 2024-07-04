<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CardImageTemplate;
use App\Models\TextOverlay;
use Intervention\Image\Facades\Image as ImageFacade;
use Illuminate\Support\Facades\Validator;

class CardImageController extends Controller
{
    public function index()
    {
        $cardTemplate = CardImageTemplate::get();
        return response()->json($cardTemplate);
    }

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
        $image->event_info_id = $request->input('event_info_id');
        $image->path = $imagePath;
        $image->save();

        return response()->json(['success' => 'Image uploaded successfully']);
    }

    public function show($id)
    {
        $cardTemplate = CardImageTemplate::find($id);
        if (!$cardTemplate) {
            return response()->json(['message' => 'Template not found'], 404);
        }
        return response()->json($cardTemplate);
    }

    public function generateCustomizedTemplate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'guest_name' => 'required|string',
            'event_info_id' => 'required|integer|exists:event_infos,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $template = CardImageTemplate::where('event_info_id', $request->event_info_id)
                                      ->where('name', $request->name)
                                      ->first();
        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }

        $overlays = TextOverlay::where('identifier', $request->identifier)
                               ->where('event_info_id', $request->event_info_id)
                               ->get();

        // // Load the template image
        // $imagePath = storage_path('app/public/' . $template->path);
        // $img = ImageFacade::make($imagePath);

        // // Add the guest name at the specified coordinates
        // foreach ($overlays as $overlay) {
        //     $img->text($request->guest_name, $overlay->x, $overlay->y, function($font) use ($overlay) {
        //         $font->file(public_path('fonts/your-font.ttf')); // Update the path to your font file
        //         $font->size($overlay->font_size);
        //         $font->color($overlay->font_color);
        //         $font->align('left');
        //         $font->valign('top');
        //     });
        // }

    //     // Save the customized image
    //     $customizedImagePath = 'customized_templates/' . uniqid() . '.png';
    //     $img->save(storage_path('app/public/' . $customizedImagePath));

    //     return response()->json(['path' => $customizedImagePath]);
    }
}
