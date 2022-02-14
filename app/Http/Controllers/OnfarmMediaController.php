<?php

namespace App\Http\Controllers;

use App\Models\Onfarm;
use Illuminate\Http\Request;

class OnfarmMediaController extends Controller
{
    public function show(Onfarm $onfarm, $media)
    {
        $this->authorize('view', $onfarm->planting->field);

        $media = $onfarm->media()->findOrFail($media);

        return response()->file($media->getPath());
    }

    public function store(Onfarm $onfarm, Request $request)
    {
        $this->authorize('update', $onfarm->planting->field);

        $request->validate([
            'media' => 'required|file',
            'collection' => 'required'
        ]);

        $media = $onfarm->addMediaFromRequest('media')->toMediaCollection($request->collection);

        return redirect()->back();
    }

    public function destroy(Onfarm $onfarm, $media)
    {
        $this->authorize('update', $onfarm->planting->field);

        $onfarm->media()->find($media)->delete();

        return redirect()->back();
    }
}
