<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use Carbon\Carbon;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();

        $path = public_path() . "/json_file/";

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        File::put($path . 'movies.json', json_encode($list));
        return view('admincp.movie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', $data['value'])->orderBy('date_update', 'DESC')->take('20')->get();
        $output = '';

        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'FullHD';
            } else {
                $text = 'Trailer';
            }
            $output .= '<div class="item">
                <a href="' . url('movie/' . $mov->slug) . '" title="' . $mov->title . '">
                    <div class="item-link">
                        <img src="' . url('uploads/movie/' . $mov->image) . '"
                            class="lazy post-thumb" alt="' . $mov->title . '"
                            title="' . $mov->title . '" />
                        <span class="is_trailer">' . $text . '</span>
                    </div>
                    <p class="title">' . $mov->title . '</p>
                </a>
                <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                <div style="float: left;">
                    <span class="user-rate-image post-large-rate stars-large-vang"
                        style="display: block;/* width: 100%; */">
                        <span style="width: 0%"></span>
                    </span>
                </div>
            </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request)
    {
        $data = $request->all();
        $movie = Movie::where('topview', 0)->orderBy('date_update', 'DESC')->take('20')->get();
        $output = '';

        foreach ($movie as $key => $mov) {
            if ($mov->resolution == 0) {
                $text = 'HD';
            } elseif ($mov->resolution == 1) {
                $text = 'SD';
            } elseif ($mov->resolution == 2) {
                $text = 'HDCam';
            } elseif ($mov->resolution == 3) {
                $text = 'Cam';
            } elseif ($mov->resolution == 4) {
                $text = 'FullHD';
            } else {
                $text = 'Trailer';
            }
            $output .= '<div class="item">
                <a href="' . url('movie/' . $mov->slug) . '" title="' . $mov->title . '">
                    <div class="item-link">
                        <img src="' . url('uploads/movie/' . $mov->image) . '"
                            class="lazy post-thumb" alt="' . $mov->title . '"
                            title="' . $mov->title . '" />
                        <span class="is_trailer">' . $text . '</span>
                    </div>
                    <p class="title">' . $mov->title . '</p>
                </a>
                <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                <div style="float: left;">
                    <span class="user-rate-image post-large-rate stars-large-vang"
                        style="display: block;/* width: 100%; */">
                        <span style="width: 0%"></span>
                    </span>
                </div>
            </div>';
        }
        echo $output;
    }
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $list_genre = Genre::all();
        $country = Country::pluck('title', 'id');

        return view('admincp.movie.form', compact('genre', 'country', 'category', 'list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->trailer = $data['trailer'];
        $movie->tags = $data['tags'];
        $movie->time = $data['time'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->date_create = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->date_update = Carbon::now('Asia/Ho_Chi_Minh');
        //them hinh anh
        $get_image = $request->file('image');

        $path = 'public/uploads/movie/';

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $movie = Movie::find($id);
        return view('admincp.movie.form', compact('genre', 'country', 'category', 'movie'));
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
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->trailer = $data['trailer'];
        $movie->tags = $data['tags'];
        $movie->time = $data['time'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->date_update = Carbon::now('Asia/Ho_Chi_Minh');
        //them hinh anh
        $get_image = $request->file('image');

        $path = 'public/uploads/movie/';

        if ($get_image) {
            if (!empty($movie->image)) {
                unlink('uploads/movie/' . $movie->image);
            } else {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('uploads/movie/', $new_image);
                $movie->image = $new_image;
            }
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if (file_exists('uploads/movie/' . $movie->image)) {
            unlink('uploads/movie/' . $movie->image);
        }
        $movie->delete();
        return redirect()->back();
    }
}
