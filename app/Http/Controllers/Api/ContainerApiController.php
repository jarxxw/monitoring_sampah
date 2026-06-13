<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Container;
use Illuminate\Http\Request;

class ContainerApiController extends Controller
{
    public function update(Request $request)
    {
        $exists = Container::where('kode_containers', $request->kode_containers)->exists();

        if (!$exists) {
            return response()->json(['message' => 'Kontainer tidak ditemukan'], 404);
        }

        Container::where('kode_containers', $request->kode_containers)
            ->update([
                'persen'    => $request->persen,
                'status'    => $request->status,
                'baterai'   => $request->baterai,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'updated_at' => now(),
            ]);

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function index()
    {
        return response()->json(Container::with(['kecamatan', 'kelurahan'])->get());
    }
}