<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Facility;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminFacilityController extends Controller
{
    protected $facilityModel;
    protected $categoryModel;
    protected $kelasModel;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->facilityModel = new Facility();
        $this->categoryModel = new Category();
        $this->kelasModel = new Kelas();
    }
    public function index()
    {
        $data = [
            'title' => 'Add Facility',
            'facilities' => Facility::all()
        ];
        // var_dump($data);
        return view('admin.Facilities.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Add Facility',
            'categories' => Category::all()
        ];
        return view('admin.Facilities.addfacility', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:facilities',
            'category_id' => 'required',
            'description' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //Log::info('Data tervalidasi:', $validatedData);

        $imagePaths = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $index => $image) {
                // Ambil slug dari data yang sudah divalidasi
                $slug = $validatedData['slug'];

                // Buat nama file dengan menggabungkan slug, sufiks, dan timestamp
                $imageName = $slug . '-' . ($index + 1) . '.' . $image->getClientOriginalExtension();

                // Simpan file ke penyimpanan yang diinginkan (dalam contoh ini, 'public/assets/fasilitas')
                $imagePaths[] = $image->storeAs('Fasilitas', $imageName, 'public');
            }
        }

        // Mengubah array imagePaths menjadi string dengan koma sebagai pemisah
        $validatedData['image'] = implode(', ', $imagePaths);

        Facility::create($validatedData);
        return redirect('/admin/facilities')->with('success', 'New Facility has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show(Facility $facility)
    {
        $data = [
            'facility' => $facility,
            'title' => 'View Facility'
        ];
        return view("admin.Facilities.viewFacility", $data);
        // return $facility;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        $data = [
            'title' => 'Edit Facility',
            'categories' => Category::all(),
            'facility' => $facility
        ];
        return view('admin.Facilities.editfacility', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    // sebelum
    public function update(Request $request, Facility $facility)
    {
        // ddd($request);
        $rules = [
            'category_id' => 'required',
            'description' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tambahan
        ];

        $validatedData = $request->validate($rules);

        // // print_r($validatedData);
        Facility::where('id', $facility->id)
            ->update($validatedData);

        return redirect('/admin/facilities')->with('success', 'Facility has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facility $facility)
    {
        Facility::destroy($facility->id);
        return redirect('/admin/facilities')->with('delete', 'Facility has been deleted!');
    }
    public function openEdit($facility_id)
    {
        $facility = $this->facilityModel->getByID($facility_id);
        $data = [
            'title' => 'Edit Facility',
            'facility' => $facility,
            'categories' => $this->categoryModel::all()
        ];
        return view('admin.Facilities.editFacility', $data);
    }
}
