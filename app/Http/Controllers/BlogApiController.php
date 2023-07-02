<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogsResource;
use App\Models\Blogs;
use Dotenv\Util\Str;
use Dotenv\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blogs::latest('id')->get();
//            ->paginate(10)->withQueryString();
        return \App\Http\Resources\BlogsResource::collection($blogs);
//        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'title'=>'required',
            'paragraph'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->messages(),422);
        }
        $blog = new Blogs();
        $blog->title = $request->title;
        $blog->slug = \Illuminate\Support\Str::slug($request->title);
        $blog->description = $request->paragraph;
        $blog->excerpt = \Illuminate\Support\Str::words($request->paragraph,15,'....');
        $blog->save();
        return response()->json(['message'=>'stock was created'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $blog = Blogs::where('slug',$slug)->first();
//        return response()->json($blog);
        return new BlogsResource($blog);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(),[
            'title'=>'required',
            'paragraph'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->messages(),422);
        }
        $blog = Blogs::find($request->id);
        if (is_null($blog)){
            return response()->json(['message'=>'stock not found'],404);
        }
        $blog->title = $request->title;
        $blog->slug = \Illuminate\Support\Str::slug($request->title);
        $blog->description = $request->paragraph;
        $blog->excerpt = \Illuminate\Support\Str::words($request->paragraph,15,'....');
        $blog->update();
        return response()->json(['message'=>'blog was updated'],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blogs::find($id);
        if (is_null($blog)){
            return response()->json(['message'=>'stock not found'],404);
        }
        $blog->delete();
        return response()->json([],204);
    }
}
