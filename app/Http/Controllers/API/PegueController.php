<?php

namespace App\Http\Controllers\API;

use App\AI\Assistant;
use App\Models\Citation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegueController {

    public function store(Request $request): JsonResponse
    {
        \Log::info($request->input('citation'));
        $assistant = new Assistant();
        $assistant->systemMessage(null);
        $metadata = $assistant->send($request->input("citation"));
        $metadata = json_decode($metadata, true);

        $citation = new Citation();
        $citation->author = json_encode($metadata['author']);
        $citation->title = $metadata['title'];
        $citation->publication  = $metadata['publication'];
        $citation->volume = $metadata['volume'];
        $citation->issue = $metadata['issue'];
        $citation->year = json_encode($metadata['issued']);
        $citation->pages = $metadata['pages'];
        $citation->mesh_headings = json_encode($metadata['mesh-headings']);
        $citation->drug_type = $metadata['drug_type'];

        \Log::info($citation);

        \Log::info($citation->save());

        return response()->json($citation, 200);
    }
}
