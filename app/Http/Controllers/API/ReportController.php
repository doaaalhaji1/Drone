<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        $q = DisasterReport::with('attachments')
            ->when($r->boolean('mine'), fn($qq) => $qq->where('user_id', $r->user()->id))
            ->when($r->filled('status'), fn($qq) => $qq->where('status', $r->status))
            ->when($r->filled('type'), fn($qq) => $qq->where('type', $r->type))
            ->latest();

        return $q->paginate(15);
    }

    public function store(Request $r)
    {
         // تحقق من صحة البيانات
    $data = $r->validate([
        'type'        => 'required|in:fire,flood,earthquake,other',
        'severity'    => 'required|in:low,medium,high',
        'lat'         => 'required|numeric',
        'lng'         => 'required|numeric',
        'title'       => 'nullable|string',
        'address'     => 'nullable|string',
        'description' => 'nullable|string',
        'status'      => 'nullable|in:pending,approved,rejected,in_progress,completed,failed',
    ]);

    $data['user_id'] = $r->user()->id;

    // إذا المستخدم ليس أدمن، لا تسمح بتحديد status
    if ($r->user()->role !== 'admin') {
        unset($data['status']);
    }

    $report = DisasterReport::create($data);

    // حفظ الصورة إذا موجودة
    if ($r->hasFile('photo')) {
        $path = $r->file('photo')->store("reports/{$report->id}", 'public');
        $report->attachments()->create(['path'=>$path, 'kind'=>'image']);
    }

    return response()->json($report->load('attachments'), 201);
    }

    public function show(DisasterReport $report)
    {
        $report->load('attachments','user','mission');
        // منع الوصول لبلاغ غيرك (إلا إذا كنت أدمن)
        if (auth()->user()->role !== 'admin' && $report->user_id !== auth()->id()) {
            return response()->json(['message'=>'Forbidden'], 403);
        }
        return $report;
    }
}
