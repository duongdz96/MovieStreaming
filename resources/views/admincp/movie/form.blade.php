@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <a href="{{ route('movies.index') }}" class="btn btn-primary">Liệt kê phim</a>
                    <div class="card-header">{{ __('Quản lý phim') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!isset($movie))
                            {!! Form::open(['route' => 'movies.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        @else
                            {!! Form::open([
                                'route' => ['movies.update', $movie->id],
                                'method' => 'PUT',
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('time', 'Time', []) !!}
                            {!! Form::text('time', isset($movie) ? $movie->time : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Ten Tieng anh', 'Ten Tieng anh', []) !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug : '', [
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                                'id' => 'description',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Tags phim', []) !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Nhap vao du lieu...',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không hiển thị'], isset($movie) ? $movie->status : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('resolution', 'Resolution', []) !!}
                            {!! Form::select(
                                'resolution',
                                ['0' => 'HD', '1' => 'SD', '2' => 'HDCam', '3' => 'Cam', '4' => 'FullHD'],
                                isset($movie) ? $movie->resolution : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('phude', 'Phu De', []) !!}
                            {!! Form::select('phude', ['0' => 'VietSub', '1' => 'Thuyết Minh'], isset($movie) ? $movie->phude : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('Category', 'Category', []) !!}
                            {!! Form::select('category_id', $category, isset($movie) ? $movie->category : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Country', 'Country', []) !!}
                            {!! Form::select('country_id', $country, isset($movie) ? $movie->country : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Genre', 'Genre', []) !!}
                            {!! Form::select('genre_id', $genre, isset($movie) ? $movie->genre : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Hot', 'Hot', []) !!}
                            {!! Form::select('phim_hot', ['1' => 'Có', '0' => 'Không'], isset($movie) ? $movie->phim_hot : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Image', 'Image', []) !!}
                            {!! Form::file('image', ['class' => 'form-control-file']) !!}
                            @if (isset($movie))
                                <img width="20%" src="{{ asset('uploads/movie/' . $movie->image) }}">
                            @endif
                        </div>
                        @if (!isset($movie))
                            {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
