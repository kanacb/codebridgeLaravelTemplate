<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function set(Request $request, String $key)
    {
        $value = $request->input('value');
        $ttl = $request->input('ttl', 60); // Time to live in seconds, defaults to 60 seconds

        Cache::put($key, $value, $ttl);

        return response()->json(['message' => 'Value cached successfully.']);
    }

    // Get a value from the cache
    public function get(Request $request, String $key)
    {
        $value = Cache::get($key, null); // Returns null if key does not exist

        if ($value === null) {
            return response()->json(['message' => 'Key not found in cache.'], 404);
        }

        return response()->json(['key' => $key, 'value' => $value]);
    }

    // Delete a value from the cache
    public function delete(Request $request, String $key)
    {
        if (Cache::has($key)) {
            Cache::forget($key);
            return response()->json(['message' => 'Key deleted from cache.']);
        }

        return response()->json(['message' => 'Key not found in cache.'], 404);
    }

    // Check if a key exists in the cache
    public function exists(Request $request, String $key)
    {
        $exists = Cache::has($key);

        return response()->json(['key' => $key, 'exists' => $exists]);
    }
}
