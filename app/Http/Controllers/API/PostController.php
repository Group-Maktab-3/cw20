<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    public function userPosts(){
        $posts = Post::where('user_id', auth()->user()->id)->get();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $myrequest = $request->all();
        // $myrequest['user_id'] = auth()->user()->id;
        // Post::create($myrequest);
    

        User::find(auth()->user()->id)->posts()->create($request->all());
        return response('post added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostResource(Post::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::where([['id', $id], ['user_id', auth()->user()->id]])->update($request->all());
        return $post == 1 ? response(['post upadated']) : response('this is not your post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //todo refactor

        $post = Post::where(['id', $id]);
        $gate = Gate::allows('delete', $post);

        if($gate) $post->delete();
            
        return $post == 1 ? response(['post deleted']) : response('this is not your post');
    }

    public function deleteAll(){

        $posts = Post::where('user_id', auth()->user()->id)->get();

        foreach ($posts as $post) {
            $post->delete();
        }

        return response('posts deleted');
    }
}
