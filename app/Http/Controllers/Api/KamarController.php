<?php

namespace App\Http\Controllers\Api;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KamarResource;
use Illuminate\Support\Facades\Validator;

class KamarController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $kamar = Kamar::latest()->paginate(5);

        //return collection of posts as a resource
        return new KamarResource(true, 'List Data Posts', $kamar);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'jeniskamar'=> 'required',
            'fasilitaskamar'=> 'required',
            'reservasi'=> 'required',
            'harga'=> 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $kamar = Kamar::create([
            'jeniskamar'=> $request->jeniskamar,
            'fasilitaskamar'=> $request->fasilitaskamar,
            'reservasi'=> $request->reservasi,
            'harga'=> $request->harga,
        ]);
        //return response
        return new KamarResource(true, 'Data Post Berhasil Ditambahkan!', $kamar);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Kamar $kamar)
    {
        //return single post as a resource
        return new KamarResource(true, 'Data Post Ditemukan!', $kamar);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Kamar $kamar)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'jeniskamar'=> 'required',
            'fasilitaskamar'=> 'required',
            'reservasi'=> 'required',
            'harga'=> 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            // $image = $request->file('image');
            // $image->storeAs('public/posts', $image->hashName());

            //delete old image
            // Storage::delete('public/posts/'.$post->image);

            //update post with new image
            $kamar->update([
                'jeniskamar'=> $request->jeniskamar,
                'fasilitaskamar'=> $request->fasilitaskamar,
                'reservasi'=> $request->reservasi,
                'harga'=> $request->harga,
            ]);

        } else {

            //update post without image
            $kamar->update([
                'jeniskamar'=> $request->jeniskamar,
            'fasilitaskamar'=> $request->fasilitaskamar,
            'reservasi'=> $request->reservasi,
            'harga'=> $request->harga,
            ]);
        }

        //return response
        return new KamarResource(true, 'Data Post Berhasil Diubah!', $kamar);
    }

    public function destroy(Kamar $kamar)
    {
        //delete image
        // Storage::delete('public/posts/'.$post->image);

        //delete post
        $kamar->delete();

        //return response
        return new KamarResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}