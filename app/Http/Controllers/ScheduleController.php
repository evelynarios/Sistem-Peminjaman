<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Facility;
use Carbon\Carbon;


class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::all();
        $data = ['title' => 'Jadwal Fasilitas'];
        return view('modules.schedule.index', compact('facilities'), $data);
    }
    public function listSchedule(Request $request)
    {
        try {
            $start = Carbon::parse($request->start)->toDateString();
            $end = Carbon::parse($request->end)->toDateString();

            $schedules = Schedule::with('facility')
                ->whereBetween('date', [$start, $end])
                ->get()
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'title' => $schedule->facility->name . ' - ' . $schedule->title,
                        'start' => $schedule->date . 'T' . $schedule->start_time,
                        'end' => $schedule->date . 'T' . $schedule->end_time,
                        'allDay' => false,
                    ];
                });

            return response()->json($schedules);
        } catch (\Exception $e) {
            // \Log::error('Schedule List Error', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);

            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
