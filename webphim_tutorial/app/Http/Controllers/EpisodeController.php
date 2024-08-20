<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use Carbon\Carbon;
class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $list_episode = Episode::with('movie')->orderBy('episode','DESC')->get();
        return view('admincp.episode.index',compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');

        return view('admincp.episode.form',compact('list_movie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$data = $request->all();
        $data = $request->validate([
            'movie_id' => ['required'],
            'linkphim' => ['required'],
            'episode' => ['required'],
   
            ],
            [
                'movie_id.required' => ' Vui lòng điền tên phim ' ,
                'linkphim.required' => ' Vui lòng điền link phim ' ,
                'episode.required' => ' Vui lòng điền tập phim ' ,               
            ]);

        $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        //dd($episode_check);
        if($episode_check>0){

            return redirect()->back(); 
        }else{
            $ep = new Episode();
            $ep->movie_id = $data['movie_id'];
            $ep->linkphim = $data['linkphim'];
            $ep->episode = $data['episode'];
            $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->save();

        }
        toastr()->success('Thành công',' Thêm tập phim ');
        return redirect()->back(); 
    }


    public function add_episode($id){
        $movie = Movie::find($id);
        $list_episode = Episode::with('movie')->where('movie_id',$id)->orderBy('episode','DESC')->get();
        return view('admincp.episode.add_episode',compact('list_episode','movie'));

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
        $episode = Episode::find($id);
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.episode.form',compact('episode','list_movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$data = $request->all();
        $data = $request->validate([
            'movie_id' => ['required'],
            'linkphim' => ['required'],
            'episode' => ['required'],
   
            ],
            [
                'movie_id.required' => ' Vui lòng điền tên phim ' ,
                'linkphim.required' => ' Vui lòng điền link phim ' ,
                'episode.required' => ' Vui lòng điền tập phim ' ,               
            ]);
        $ep = Episode::find($id);
        $ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['linkphim'];
        $ep->episode = $data['episode'];
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
       
        $ep->save();
        toastr()->success('Thành công',' Cập nhật tập phim ');
        return redirect()->route('episode.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ep = Episode::find($id)->delete();
        toastr()->warning('Thành Công',' Xóa tập phim ');
        return redirect()->route('episode.index'); 
    }

    public function select_movie()
    {   
        $id = $_GET['id'];
        $movie = Movie::find($id);
        $output ='<option value="">---chọn tập phim----</option>';
        
        if($movie->thuocphim==1){
        for($i=1;$i <= $movie->sotap;$i++){
            $output .='<option value="'.$i.'">'.$i.'</option>';

        }
        }else{
            $output .='<option value="HD">HD</option>';
            $output .='<option value="FullHD">FullHD</option>';
            $output .='<option value="CAM">CAM</option>';
        } 
        echo $output;
    }
}
