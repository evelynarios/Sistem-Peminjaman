<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Kerusakan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan namespace Auth

class LaporankerusakanpageController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Laporankerusakanpage',
            'pemesanans' => Pemesanan::where('status', 'Completed')
                ->where('user_id', Auth::user()->id) // Gunakan Auth::user() secara eksplisit
                ->get(),
        ];
        return view('modules.laporankerusakanpage.index', $data);
    }

    public function getFacilityInfo(Request $request)
    {
        $facilityId = $request->input('facility_id');

        $facility = Facility::find($facilityId);

        if (!$facility) {
            return response()->json(['error' => 'Facility not found'], 404);
        }

        $images = explode(', ', $facility->image);
        $facilityData = [
            'id' => $facility->id,
            'name' => $facility->name,
            'slug' => $facility->slug,
            'price' => $facility->price,
            'image' => $images[0],
        ];

        return response()->json($facilityData);
    }

    public function getPemesananInfo(Request $request)
    {
        $pemesananId = $request->input('pemesanan_id');
        $pemesanan = Pemesanan::find($pemesananId);

        if (!$pemesanan) {
            return response()->json(['error' => 'Pemesanan not found'], 404);
        }

        $facility = $pemesanan->facility;

        if (!$facility) {
            return response()->json(['error' => 'Facility not found'], 404);
        }

        $images = explode(', ', $facility->image);
        $facilityData = [
            'id' => $facility->id,
            'name' => $facility->name,
            'slug' => $facility->slug,
            'price' => $facility->price,
            'image' => $images[0],
        ];

        return response()->json($facilityData);
    }

    public function postLaporanKerusakan(Request $request)
    {
        $request->validate([
            'selectedFacility' => 'required',
            'description' => 'required',
        ]);

        $pemesananId = $request->input('selectedFacility');
        $description = $request->input('description');

        Kerusakan::create([
            'pemesanan_id' => $pemesananId,
            'user_id' => Auth::user()->id, // Gunakan Auth::user() secara eksplisit
            'deskripsi' => $description,
            'status' => 'Waiting',
        ]);

        return redirect('status_pemesanan')->with('success', 'Laporan kerusakan berhasil diajukan');
    }
}
