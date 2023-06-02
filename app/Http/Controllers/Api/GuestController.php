<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\guest;

class GuestController extends Controller
{
    public function index()
    {
        // untuk show data guest
        $guest = guest::all();

        if(count($guest) > 0)
        {
            return response([
                'message' => 'Retrieve All Guest Success',
                'data' => $guest
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        // untuk menambahkan data guest baru
        $guestData = $request->all();
        $validate = Validator::make($guestData, [
            'nama_tamu' => 'required|max:60',
            'nomor_hp' => 'required',
            'nomor_kamar' => 'required',
            'tipe_kamar' => 'required',
            'tanggal_booking' => 'required',
            'metode_pembayaran' => 'required',
            'harga' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => $validate->errors()
            ],400);
        }

        $guest = guest::create($guestData);
        return response([
            'message' => 'Add Guest Success',
            'data' => $guest
        ], 200);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        // untuk show guest berdasarkan pencarian
        $guest = guest::find($id);

        if(!is_null($guest)) {
            return response([
                'message' => 'Retrieve Guest Success',
                'data' => $guest
            ], 200);
        }

        return response([
            'message' => 'Guest Not Found',
            'data' => null
        ], 404);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(customer $customer)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        //untuk mengubah 1 data guest
        $guest = guest::find($id);
        if(is_null($guest))
        {
            return response([
                'message' => 'Guest Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_tamu' => 'required|max:60',
            'nomor_hp' => 'required',
            'nomor_kamar' => 'required',
            'tipe_kamar' => 'required',
            'tanggal_booking' => 'required',
            'metode_pembayaran' => 'required',
            'harga' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => $validate->errors()
            ], 400);
        }

        $guest->nama_tamu = $updateData['nama_tamu'];
        $guest->nomor_hp = $updateData['nomor_hp'];
        $guest->nomor_kamar = $updateData['nomor_kamar'];
        $guest->tipe_kamar = $updateData['tipe_kamar'];
        $guest->tanggal_booking = $updateData['tanggal_booking'];
        $guest->metode_pembayaran = $updateData['metode_pembayaran'];
        $guest->harga = $updateData['harga'];

        if($guest->save())
        {
            return response([
                'message' => 'Update Guest Success',
                'data' => $guest
            ], 200);
        }

        return response([
            'message' => 'Update Guest Failed',
            'data' => null
        ], 400);
    }
    

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\customer  $customer
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {
        // untuk menghapus data guest
        $guest = guest::find($id);

        if(is_null($guest)) {
            return response([
                'message' => 'Guest Not Found',
                'data' => null
            ], 404);
        }

        if($guest->delete())
        {
            return response ([
                'message' => 'Delete Guest Success',
                'data' => $guest
            ], 200);
        }

        return response ([
            'message' => 'Delete Guest Failed',
            'data' => null,
        ], 400);
    }
}
