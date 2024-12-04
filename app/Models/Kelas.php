<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika nama tabel mengikuti konvensi Laravel)
    protected $table = 'kelas';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_facility',
        'room',
    ];

    /**
     * Relasi ke model Facility (assuming you have a `Facility` model).
     * Misalnya, sebuah kelas terkait dengan satu fasilitas.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'id_facility');
    }
    public function getKelasbyFacilityId($facilityId)
    {
        return Kelas::where('id_facility', $facilityId)->get();
    }
}
