<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
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
        $list = Country::all();
        return view('admincp.country.form',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {  
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique:countries', 'max:255'],
            'slug' => ['required', 'unique:countries', 'max:255'],
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

        $country = new Country();        
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->status = $data['status'];
        $country->save();
        toastr()->success('Thành công',' Thêm quốc gia ');
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
        $country = Country::find($id);
        $list = Country::all();
        return view('admincp.country.form',compact('list','country'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique:countries', 'max:255'],
            'slug' => ['required', 'unique:countries', 'max:255'],
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

        $country = Country::find($id);        
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->status = $data['status'];
        $country->save();
        // return redirect()->back(); 
        toastr()->success('Thành công',' Cập nhật quốc gia ');
        return redirect()->route('country.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::find($id)->delete();
        toastr()->warning('Thành Công',' Xóa quốc gia ');
       return redirect()->back();
    }
}
