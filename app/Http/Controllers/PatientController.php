<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// import model Patient untuk berinteraksi dengan database
use App\Models\Patient;

class PatientController extends Controller
{
    // membuat method index
    public function index()
    {
        // menampilkan data patient dari database
        $patients = Patient::all();

        $data = [
            'message' => 'Get all patients',
            'data' => $patients,
        ];

        // mengirim data (json) dan kode 200
        return response()->json($data, 200);

        // handling jika data kosong
        if ($patients->isEmpty()) {
            $data =[
                'message'=> 'Data not found',
                'data' => []
            ];

            return response()->json($data, 200);
        } 

        // handling  jika database tidak ada
        else {
            $data = [
                'message' => 'Database not found',
                'data'=> []
            ];

            // mengirim respon json dan kode 200
            return response()->json($data, 200);
        }
    }

    // membuat method store
    public function store(Request $request)
    {
        // untuk memvalidasi masing-masing data (harus diisi)
        $validatedData = $request->validate([
            'name'=> 'required',
            'phone'=> 'required | numeric',
            'address'=> 'required',
            'status'=> 'required',
            'in_date_at'=> 'required',
            'out_date_at'=> 'required',
        ]);

        // menggunakan model Patient untuk insert data
        $patient = Patient::create($validatedData);

        $data = [
            'message'=> 'Patient is added successfully',
            'data'=> $patient,
        ];

        // mengembalikan dalam bentuk bahasa (json) dan kode 201
        return response()->json($data, 201);
    }

    // membuat method show
    public function show(string $id)
    {
        // cari id patient yang ingin didapatkan
        $patient = Patient::find($id);

        // menghandle data yang akan ditampilkan
        if ($patient) {
            $data = [
                'message'=> 'Get detail patient',
                'data'=> $patient
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } 

        // handling data jika tidak ada
        else {
            $data = [
                'message'=> 'Patient not found'
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    // membuat method update
    public function update(Request $request, string $id)
    {
        // cari id patient yang ingin diupdate
        $patient = Patient::find($id); 

        // menghandle data yg akan di-update
        if ($patient) {
            // menangkap data request
            $input = [
                'name'=> $request->name ?? $patient->name,
                'phone'=> $request->phone ?? $patient->phone,
                'address'=> $request->address ?? $patient->address,
                'status'=> $request->status ?? $patient->status,
                'in_date_at'=> $request->in_date_at ?? $patient->in_date_at,
                'out_date_at'=> $request->out_date_at ?? $patient->out_date_at,
            ];
        
            // melakukan update data
            $patient->update($input);

            $data = [
                'message'=> "Patient's data successfully updated",
                'data'=> $patient
            ];

            // mengembalikan dalam bentuk data json dan kode 200 (success)
            return response()->json($data, 200);
        }

        // handling jika data tidak ada
        else {
            $data = [
                'message' => 'Patient not found'
            ];

            return response()->json($data, 404);
        }
    }

    // membuat method destroy
    public function destroy(string $id)
    {
        // cari id patient yang ingin dihapus
        $patient = Patient::find($id);

        // menghandle data yg tidak ada
        if ($patient) {
            // hapus patient tersebut
            $patient->delete();

            $data = [
                'message'=> 'Data deleted successfully'
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        }

        // handling data yang tidak ada
        else {
            $data = [
                'message'=> 'Student not found'
            ];

            // mengembalikan response json dan kode 404
            return response()->json($data, 404);
        }
    }

    // menampilkan data yang akan dicari
    public function search(Request $request, $name)
    {
        // mencari nama yang sesuai
        $patient = Patient::where('name', 'like', '%' . $name . '%')->get();

        // menghandle jika data tidak ada
        if ($patient) {
            $data = [
                'message'=> 'Get searched patient',
                'data' => $patient
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        }

        else {
            $data = [
                'message'=> 'Patient not found'
            ];

            // mengembalikan response json dan kode 404
            return response()->json($data, 404);
        }
    }

    // menampilkan data pasien positif
    public function positive(Request $request)
    {
        $patients = Patient::where('status', 'Positive')->get();

        // menghandle data yg tidak ada
        if ($patients->count() > 0) {
            $data = [
                'message'=> 'Get positive patients',
                'data' => $patients
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        }

        // handling data yang tidak ada
        else {
            $data = [
                'message'=> 'Patient not found'
            ];

            // mengembalikan response json dan kode 404
            return response()->json($data, 404);
        }
    }

    // menampilkan data pasien yang sembuh
    public function recovered(Request $request)
    {
        $patients = Patient::where('status', 'Recovered')->get();

        // menghandle data yg tidak ada
        if ($patients ->count() > 0) {
            $data = [
                'message'=> 'Get recovered patients',
                'data' => $patients
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        }

        // handling data yang tidak ada
        else {
            $data = [
                'message'=> 'Patient not found'
            ];

            // mengembalikan response json dan kode 404
            return response()->json($data, 404);
        }
    }

    // menampilkan data pasien yang meninggal
    public function dead(Request $request)
    {
        $patients = Patient::where('status', 'Dead')->get();

        // menghandle data yang akan ditampilkan
        if ($patients->count() > 0) {
            $data = [
                'message'=> 'Get dead patients',
                'data'=> $patients
            ];

            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } 

        // handling data jika tidak ada
        else {
            $data = [
                'message'=> 'Patient not found'
            ];

            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }
}
