<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the classes.
     */
    public function index()
    {
        $data = [
            'title' => 'Add Facility',
            'kelas' => Kelas::with('facility')->get()
        ];
        return view('admin.kelas.index', $data);
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        $data = [
            'title' => 'Add Facility',
            'facilities' => Facility::where('category_id', '1')->get()
        ];
        return view('admin.kelas.create', $data);
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'room' => 'required|string|max:255',
            'id_facility' => 'required|exists:facilities,id'
        ]);

        // Create the new class
        $kelas = Kelas::create($validatedData);

        // Redirect with success message
        return redirect()->route('kelas.index')
            ->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified class.
     */
    public function show(Kelas $kelas)
    {
        // Load facility relationship
        $kelas->load('facility');
        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(Kelas $kelas)
    {
        $data = [
            'title' => 'Edit Facility',
            'facilities' => Facility::where('category_id', '1')->get(),
            'kelas' => $kelas // Langsung gunakan instance $kelas yang sudah di-resolve oleh Laravel
        ];
        return view('admin.kelas.edit', $data);
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        // Validate the request
        $validatedData = $request->validate([
            'room' => 'required|string|max:255',
            'id_facility' => 'required|exists:facilities,id'
        ]);
        Kelas::where('id', $kelas->id)->update($validatedData);
        // Update the class

        // Redirect with success message
        return redirect()->route('kelas.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(Kelas $kelas)
    {
        // Delete the class
        Kelas::destroy($kelas->id);

        // Redirect with success message
        return redirect()->route('kelas.index')
            ->with('delete', 'Class deleted successfully.');
    }
}
