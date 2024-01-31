<?php
// app/Http/Controllers/ImageController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Customer;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'customer_id' => 'required|exists:customers,id',
        ]);

        // Handle image upload and store in the 'public/images' directory
        $imagePath = $request->file('image')->store('images', 'public');

        // Create a new image record in the database
        Image::create([
            'customer_id' => $request->input('customer_id'),
            'image_path' => $imagePath,
            // Add other image fields if needed
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }
}
