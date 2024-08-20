<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $list = Category::orderBy('position','ASC')->get();
        return view('admincp.category.form',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
       // $data = $request->all();
       $data = $request->validate([
        'title' => ['required', 'unique:categories', 'max:255'],
        'slug' => ['required', 'unique:categories', 'max:255'],
        'description' => ['required'],
        'status' => ['required'],
        
        ],
        [
            'title.unique' => ' Tên danh mục này đã có , xin điền tên khác ' ,
            'slug.unique' => ' Slug danh mục này đã có , xin điền Slug khác ' ,
            'title.required' => ' Vui lòng điền tên danh mục ' ,
            'description.required' => ' Vui lòng điền mô tả ' ,
            'slug.required' => ' Vui lòng điền Slug danh mục ' ,
            'status.required' => ' Vui lòng chọn trạng thái ' ,
        ]);


        $category = new Category();        
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();
        toastr()->success('Thành công',' Thêm danh mục ');
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
        $category = Category::find($id);
        $list = Category::orderBy('position','ASC')->get();
        return view('admincp.category.form',compact('list','category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique:categories', 'max:255'],
            'slug' => ['required', 'unique:categories', 'max:255'],
            'description' => ['required'],
            'status' => ['required'],
            
            ],
            [
                'title.unique' => ' Tên danh mục này đã có , xin điền tên khác ' ,
                'slug.unique' => ' Slug danh mục này đã có , xin điền Slug khác ' ,
                'title.required' => ' Vui lòng điền tên danh mục ' ,
                'description.required' => ' Vui lòng điền mô tả ' ,
                'slug.required' => ' Vui lòng điền Slug danh mục ' ,
                'status.required' => ' Vui lòng chọn trạng thái ' ,
            ]);
    
        $category = Category::find($id);        
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();
        // return redirect()->back();
        toastr()->success('Thành công',' Cập nhật danh mục ');
        return redirect()->route('category.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Category::find($id)->delete();
       toastr()->warning('Thành Công',' Xóa danh mục ');
       return redirect()->back();
    }

    public function resorting(Request $request)
    {   
        $data = $request->all();

       foreach($data['array_id'] as $key => $value){
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
       }

    }
}
