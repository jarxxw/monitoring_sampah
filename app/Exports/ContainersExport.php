<?php

namespace App\Exports;

use App\Models\Container;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContainersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Container::select(
            'kode_containers',
            'nama_lokasi',
            'persen',
            'baterai',
            'latitude',
            'longitude',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Container',
            'Lokasi',
            'Persentase',
            'Baterai',
            'Latitude',
            'Longitude',
            'Update Terakhir'
        ];
    }
}