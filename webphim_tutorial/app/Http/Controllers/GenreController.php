<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $list = Genre::all();
        return view('admincp.genre.form',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique:genres', 'max:255'],
            'slug' => ['required', 'unique:genres', 'max:255'],
            'description' => ['required'],
            'status' => ['required'],
            ],
            [
                'title.unique' => ' Tên thể loại này đã có , xin điền tên khác ' ,
                'slug.unique' => ' Slug thể loại này đã có , xin điền Slug khác ' ,
                'title.required' => ' Vui lòng điền tên thể loại ' ,
                'description.required' => ' Vui lòng điền mô tả ' ,
                'slug.required' => ' Vui lòng điền Slug thể loại ' ,
                'status.required' => ' Vui lòng chọn trạng thái ' ,
            ]);

        $genre = new Genre();        
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->status = $data['status'];
        $genre->save();
        toastr()->success('Thành công',' Thêm thể loại ');
        return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genre = Genre::find($id);
        $list = Genre::all();
        return view('admincp.genre.form',compact('list','genre'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique: genres', 'max:255'],
            'slug' => ['required', 'unique: genres', 'max:255'],
            'description' => ['required'],
            'status' => ['required'],
            ],
            [
                'title.unique' => ' Tên thể loại này đã có , xin điền tên khác ' ,
                'slug.unique' => ' Slug thể loại này đã có , xin điền Slug khác ' ,
                'title.required' => ' Vui lòng điền tên thể loại ' ,
                'description.required' => ' Vui lòng điền mô tả ' ,
                'slug.required' => ' Vui lòng điền Slug thể loại ' ,
                'status.required' => ' Vui lòng chọn trạng thái ' ,
            ]);
        $genre = Genre::find($id);        
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->status = $data['status'];
        $genre->save();
        // return redirect()->back(); 
        toastr()->success('Thành công',' Cập nhật thể loại ');
        return redirect()->route('genre.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Genre::find($id)->delete();
        toastr()->warning('Thành Công',' Xóa thể loại ');
       return redirect()->back();
    }
}
