<?php

namespace App\Http\Controllers\API;

use App\AI\Assistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegueController {

    public function store(Request $request): JsonResponse
    {
        \Log::info($request->input('citation'));
        $assistant = new Assistant();
        $assistant->systemMessage(null);
        $metadata = $assistant->send($request->input("citation"));
        Storage::disk('local')->put(json_encode($metadata), JSON_PRETTY_PRINT);

        return response()->json($metadata, 200);
    }
}
