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
}
