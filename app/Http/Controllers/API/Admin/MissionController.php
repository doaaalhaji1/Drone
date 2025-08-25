<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\DisasterReport;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'disaster_report_id' => 'required|exists:disaster_reports,id',
            'notes'      => 'nullable|string',
            'stream_url' => 'nullable|string',
        ]);

        $report = DisasterReport::findOrFail($data['disaster_report_id']);
        // مجرد احتياط: لازم يكون Approved قبل المهمة (اختياري)
        if (!in_array($report->status, ['approved','in_progress'])) {
            return response()->json(['message'=>'Report must be approved first'], 422);
        }

        $mission = Mission::create([
            'disaster_report_id' => $report->id,
            'assigned_by' => $r->user()->id,
            'notes' => $data['notes'] ?? null,
            'stream_url' => $data['stream_url'] ?? null,
            'status' => 'assigned',
        ]);

        $report->update(['status'=>'in_progress']);

        return response()->json($mission, 201);
    }

    public function updateStatus(Request $r, Mission $mission)
    {
        $r->validate([
            'status' => 'required|in:assigned,launched,streaming,returning,completed,failed',
        ]);

        $mission->update(['status'=>$r->status]);

        if (in_array($r->status, ['completed','failed'])) {
            $mission->report()->update(['status' => $r->status === 'completed' ? 'completed' : 'failed']);
        }

        return $mission->load('report');
    }

    public function show(Mission $mission)
    {
        return $mission->load('report','updates','admin');
    }

    public function timeline(Mission $mission)
    {
        return $mission->updates()->latest()->paginate(50);
    }
}
