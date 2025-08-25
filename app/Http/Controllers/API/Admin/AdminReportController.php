<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisasterReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $r)
    {
          $reports = DisasterReport::with('user') // ✅ احضر كل بيانات المستخدم
        ->get()
        ->map(function ($report) {
            return [
                'id' => $report->id,
                'user' => [ // ✅ أرجِع كائن المستخدم كاملاً
                    'id' => $report->user->id,
                    'name' => $report->user->name,
                    'email' => $report->user->email,
                    // أضف أي حقول أخرى تريدها
                ],
                'requesterName' => $report->user->name, // ✅ احتفظ بالاسم أيضاً للتوافق
                'disasterType' => $report->type,
                'description' => $report->description,
                'lat' => (float) $report->lat,
                'lng' => (float) $report->lng,
                'status' => $report->status,
                'severity' => $report->severity,
                'requestDate' => $report->created_at
            ];
        });

    return response()->json(['data' => $reports]);
    }

    public function approve(DisasterReport $report)
    {
        $report->update(['status'=>'approved']);
        return $report->fresh();
    }

    public function reject(DisasterReport $report)
    {
        $report->update(['status'=>'rejected']);
        return $report->fresh();
    }
}
