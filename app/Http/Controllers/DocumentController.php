<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        return Storage::disk($document->disk)->download($document->path);
    }

    public function destroy(Document $document)
    {
        if (Storage::disk($document->disk)->exists($document->path)) {
            Storage::disk($document->disk)->delete($document->path);
        }

        $document->delete();

        return back();
    }
}
