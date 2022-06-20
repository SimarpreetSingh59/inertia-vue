<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Posts/Index',[
            "posts" => Post::orderBy('id','DESC')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->getValidate($request);

        $post = new Post();

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if($request->file('image')){
            $post->image = $this->upload($request);
        }

        $post->save();

        $request->session()->flash('success', 'Post Created Successfully!');

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Posts/Edit', [
            'post' => Post::findOrFail($id)
        ]);
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
        $this->getValidate($request, $id);
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        if($request->file('image')) {
            $post->image = $this->upload($request);
        }
        $post->save();
        $request->session()->flash('success', 'Post updated successfully!');
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        Post::find($id)->delete();
        $request->session()->flash('success', 'Post deleted successfully!');
        return redirect()->route('post.index');
    }

    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'title' => 'required',
            'content' => 'required'
        ];
        $this->validate($request, $data);
    }
    private function upload($request)
    {
        $image = $request->file('image');
        $imageName = md5(uniqid()) . "." . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);
        return $imageName;
    }
}
