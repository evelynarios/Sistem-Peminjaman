<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\RequestGedung;
use App\Models\User;
use Illuminate\Contracts\Support\ValidatedData;

class RentController extends Controller
{
    protected $facilityModel;
    public function __construct()
    {
        $this->facilityModel = new Facility();
    }
    public function index(Request $request)
    {
        $facilityId = $request->input('facility_id');
        $user_id = $request->input('user_id');
        $tanggalSewa = $request->input('tanggalSewa');
        $nama = $request->input('nama');
        $nim = $request->input('nim');
        $email = $request->input('email');
        $noTel = $request->input('noTel');
        $file = $request->file("inputFile");

        $data = [
            'facility_id' => $facilityId,
            'user_id' => $user_id,
            'tanggalSewa' => $tanggalSewa,
            'nama' => $nama,
            'nim' => $nim,
            'email' => $email,
            'noTel' => $noTel,
            'file' => $file,
        ];

        //dd($data);

        return view('modules.rentpage.index', $data);
    }

    public function store(Request $request)
    {
        $facilityId = $request->input('facility_id');
        $user_id = $request->input('user_id');
        $tanggalSewa = $request->input('tanggalSewa');
        $nama = $request->input('nama');
        $nim = $request->input('nim');
        $email = $request->input('email');
        $noTel = $request->input('noTel');
        $file = $request->file("inputFile");
        // $facility = Facility::findOrFail($facilityId);
        $validatedData = $request->validate([
            "facility_id" => "required",
            "user_id" => "required",
            "noTel" => "required",
            "tanggalSewa" => "required",
            "nama" => "required",
            "nim" => "required",
            "email" => "required",
            "inputFile" => "required|file|mimes:pdf"
        ]);

        $facilitySlug = $this->facilityModel->getSlugbyID($facilityId);

        if ($request->hasFile('inputFile')) {
            $name = $validatedData['nama'];
            $nim = $validatedData['nim'];
            $facilityID = $validatedData['facility_id'];
            $extension = $file->getClientOriginalExtension();
            // $namafile = $name . '-' . $facilityID . '-' . $validatedData['tanggalSewa'] . '-' . $nim;
            $namafile = $name . '-' . $nim . '-' . $facilitySlug . '-' . $validatedData['tanggalSewa'];
            $filename = $name . '-' . $nim . '-' . $facilitySlug . '-' . $validatedData['tanggalSewa'] . '.' . $extension;

            // Here you can use $filename as the complete filename with extension
            // For example, you can save it to storage or move it to a specific directory
            $file->storeAs('PDF', $filename, 'public');

            $filepath = $filename;
        }
        // dd($validatedData, $filename);
        $validatedData['nomor_tlp'] = $noTel;
        $validatedData['tanggal_pemesanan'] = $tanggalSewa;
        $validatedData['nama_file'] = $namafile;
        $validatedData['file_path'] = $filename;
        Pemesanan::create($validatedData);
        return redirect('/status_pemesanan')->with('success', 'Berhasil mengajukan pesanan');
    }
}
