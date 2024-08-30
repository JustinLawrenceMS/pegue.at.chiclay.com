<?php

namespace App\Http\Controllers\API;

use App\AI\Assistant;
use App\Http\Controllers\Controller;
use App\Models\Citation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PegueController extends Controller
{

   public function store(Request $request): JsonResponse
    {
        Gate::authorize('create', (new Citation()));
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
        $citation->citation = json_encode($metadata);

        \Log::info($citation);

        \Log::info($citation->save());

        return response()->json($citation, 200);
    }
}
