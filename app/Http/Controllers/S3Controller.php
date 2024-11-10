<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    // Method to upload a file to S3
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        // Get the uploaded file
        $file = $request->file('file');
        $filePath = 'uploads/' . $file->getClientOriginalName();

        // Store the file on S3
        $result = Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

        if ($result) {
            return response()->json(['message' => 'File uploaded successfully', 'path' => $filePath], 200);
        } else {
            return response()->json(['message' => 'File upload failed'], 500);
        }
    }

    // Method to retrieve a file from S3
    public function get($fileName)
    {
        $filePath = 'uploads/' . $fileName;

        // Check if file exists in S3
        if (Storage::disk('s3')->exists($filePath)) {
            // $fileUrl = Storage::disk('s3')->url($filePath);
            // return response()->json(['url' => $fileUrl], 200);
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }
    }

    // Method to delete a file from S3
    public function delete($fileName)
    {
        $filePath = 'uploads/' . $fileName;

        // Delete the file from S3
        if (Storage::disk('s3')->exists($filePath)) {
            Storage::disk('s3')->delete($filePath);
            return response()->json(['message' => 'File deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }
    }
}
