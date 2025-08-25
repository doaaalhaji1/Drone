<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;

class MissionFeedController extends Controller
{
    public function push(Request $r, Mission $mission)
    {
        // يسمح للي معهم توكن (طيّار/تطبيق) يرفعوا تحديثات
        $data = $r->validate([
            'lat'       => 'nullable|numeric',
            'lng'       => 'nullable|numeric',
            'battery'   => 'nullable|numeric',
            'altitude'  => 'nullable|numeric',
            'speed'     => 'nullable|numeric',
            'message'   => 'nullable|string',
            'photo'     => 'nullable|image|max:4096',
            'video_clip'=> 'nullable|file|mimetypes:video/mp4,video/quicktime|max:10240',
        ]);

        if ($r->hasFile('photo')) {
            $data['photo_path'] = $r->file('photo')->store("missions/{$mission->id}/photos", 'public');
        }
        if ($r->hasFile('video_clip')) {
            $data['video_clip'] = $r->file('video_clip')->store("missions/{$mission->id}/clips", 'public');
        }

        $update = $mission->updates()->create($data);

        // خيار: بثّ حدث WebSocket لو بدّك realtime
        // event(new MissionUpdated($update));

        return response()->json($update, 201);
    }
}
