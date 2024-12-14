<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;

class IndexController extends Controller
{
    public function home()
    {
        $phim_hot = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $category_home = Category::with('movie')->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('pages.home', compact('category', 'genre', 'country', 'category_home', 'phim_hot', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function category($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $cate_slug = Category::where('slug', $slug)->first();
        $movie = Movie::where('category_id', $cate_slug->id)->where('status', 1)->orderBy('date_update', 'DESC')->paginate(12);

        return view('pages.category', compact('category', 'genre', 'country', 'cate_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }

    public function year($year)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $year = $year;
        $movie = Movie::where('year', $year)->where('status', 1)->orderBy('date_update', 'DESC')->paginate(12);
        return view('pages.year', compact('category', 'genre', 'country', 'year', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }

    public function tag($tag)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $tag = $tag;
        $movie = Movie::where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->orderBy('date_update', 'DESC')->paginate(12);
        return view('pages.tag', compact('category', 'genre', 'country', 'tag', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function genre($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $genre_slug = Genre::where('slug', $slug)->first();
        $movie = Movie::where('genre_id', $genre_slug->id)->where('status', 1)->orderBy('date_update', 'DESC')->paginate(12);
        return view('pages.genre', compact('category', 'genre', 'country', 'genre_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function country($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $country_slug = Country::where('slug', $slug)->first();
        $movie = Movie::where('country_id', $country_slug->id)->where('status', 1)->orderBy('date_update', 'DESC')->paginate(12);
        return view('pages.country', compact('category', 'genre', 'country', 'country_slug', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function movie($slug)
    {
        $category = Category::orderBy('id', 'DESC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'DESC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take('30')->get();
        $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take('10')->get();

        $movie = Movie::with('category', 'genre', 'country')->where('slug', $slug)->where('status', 1)->first();
        $movie_related = Movie::with('category', 'genre', 'country')->where('category_id', $movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        return view('pages.movie', compact('category', 'genre', 'country', 'movie', 'movie_related', 'phimhot_sidebar', 'phimhot_trailer'));
    }
    public function watch()
    {
        return view('pages.watch');
    }
    public function episode()
    {
        return view('pages.episode');
    }
    public function timkiem()
    {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
            $genre = Genre::orderBy('id', 'DESC')->get();
            $country = Country::orderBy('id', 'DESC')->get();
            $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('date_update', 'DESC')->take(30)->get();
            $phimhot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('date_update', 'DESC')->take(10)->get();


            $movie = Movie::where('title', 'LIKE', '%' . $search . '%')->orderBy('date_update', 'DESC')->paginate(40);

            return view('pages.timkiem', compact('category', 'genre', 'country', 'search', 'movie', 'phimhot_sidebar', 'phimhot_trailer'));
        } else {
            return redirect()->to('/');
        }
    }

}
