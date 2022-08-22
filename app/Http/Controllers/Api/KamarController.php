<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $posts);
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
            'jenis kamar'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fasilitasnkamar'=> 'required',
            'reservasi'=> 'required',
            'harga'=> 'required',
        ]);



        

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $kamar = Post::create([
            'jenis kamar'=> $image->hashName(),
            'fasilitas kamar'=> $request->title,
            'reservasi'=> $request->content,
            'harga'=> $request->content,
        ]);
        //return response
        return new KamarResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
}