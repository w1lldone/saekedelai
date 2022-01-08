<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserMediaController extends Controller
{
    public function store(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $request->validate([
            'collection' => ['required', Rule::in($user->getRegisteredMediaCollections()->pluck('name'))],
            'media' => 'required|file|max:5120'
        ]);

        $user->addMediaFromRequest('media')->toMediaCollection($request->collection);

        return redirect()->back()->with('status', __('messages.success'));
    }

    public function show(User $user, $media)
    {
        $this->authorize('view', $user);
        /** @var Media */
        $media = $user->media()->findOrFail($media);

        return response()->file($media->getPath());
    }

    /** @test */
    public function destroy(User $user, $media)
    {
        $this->authorize('update', $user);

        $user->media()->findOrFail($media)->delete();

        return redirect()->back()->with('status', __('messages.deleted'));
    }
}
