<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminScheduleController extends Controller
{

    public function index()
    {
        $facilities = Facility::all();
        $data = ['title' => 'Jadwal Fasilitas'];
        return view('admin.schedules.index', compact('facilities'), $data);
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

    public function edit(Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required|string',
        ]);

        // Cek konflik jadwal
        $conflict = Schedule::checkScheduleConflict(
            $validated['facility_id'],
            $validated['date'],
            $validated['start_time'],
            $validated['end_time']
        );

        if ($conflict) {
            return response()->json([
                'message' => 'Jadwal bertabrakan dengan jadwal lain'
            ], 422);
        }

        $schedule = Schedule::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $schedule
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'facility_id' => 'sometimes|exists:facilities,id',
            'date' => 'sometimes|date',
            'start_time' => 'sometimes|required',
            'end_time' => 'sometimes|required',
            'title' => 'sometimes|string',
        ]);

        $schedule->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil diupdate'
        ]);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}
