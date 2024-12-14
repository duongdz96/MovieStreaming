@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('movies.create') }}" class="btn btn-primary">Thêm phim</a>
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Time</th>
                            <th scope="col">Hot</th>
                            <th scope="col">Resolution</th>
                            <th scope="col">Sub</th>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Active/Inactive</th>
                            <th scope="col">Category</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Country</th>
                            <th scope="col">Year</th>
                            <th scope="col">Top Views</th>
                            <th scope="col">Season</th>
                            <th scope="col">Create</th>
                            <th scope="col">Update</th>
                            <th scope="col">Manage</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $key => $cate)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>{{ $cate->title }}</td>
                                <td>{{ $cate->tags }}</td>
                                <td>{{ $cate->time }}</td>
                                <td>
                                    @if ($cate->phim_hot == 0)
                                        Không
                                    @else
                                        Có
                                    @endif
                                </td>
                                <td>
                                    @if ($cate->resolution == 0)
                                        HD
                                    @elseif ($cate->resolution == 1)
                                        SD
                                    @elseif ($cate->resolution == 2)
                                        HDCam
                                    @elseif ($cate->resolution == 3)
                                        Cam
                                    @elseif ($cate->resolution == 4)
                                        FullHD
                                    @else
                                        Trailer
                                    @endif
                                </td>
                                <td>
                                    @if ($cate->phude == 0)
                                        VietSub
                                    @else
                                        Thuyết minh
                                    @endif
                                </td>
                                <td><img width="50%" src="{{ asset('uploads/movie/' . $cate->image) }}"></td>
                                <td>{{ $cate->description }}</td>
                                <td>{{ $cate->slug }}</td>
                                <td>
                                    @if ($cate->status == 1)
                                        Hiển thị
                                    @else
                                        Không hiển thị
                                    @endif
                                </td>
                                <td>{{ $cate->category->title }}</td>
                                <td>
                                    @foreach ($cate->movie_genre as $gen)
                                        <span class="badge badge-dark">{{ $gen->title }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $cate->country->title }}</td>
                                <td>
                                    {!! Form::selectYear('year', 2002, 2024, isset($cate->year) ? $cate->year : '', [
                                        'class' => 'select-year',
                                        'id' => $cate->id,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::select(
                                        'topviews',
                                        ['0' => 'Ngày', '1' => 'Tuần', '2' => 'Tháng'],
                                        isset($cate->topview) ? $cate->topview : '',
                                        [
                                            'class' => 'select-topview',
                                            'id' => $cate->id,
                                        ],
                                    ) !!}
                                </td>
                                <td>
                                    <form method="POST">
                                        @csrf
                                        {{-- @php
                                            $season = [];
                                            for ($season = 1; $season <= 20; $season++) {
                                                $season[$season] = $season;
                                            }
                                        @endphp --}}
                                        {!! Form::selectRange('season', 0, 20, isset($cate->season) ? $cate->season : '', [
                                            'class' => 'select-season',
                                            'id' => $cate->id,
                                        ]) !!}
                                    </form>
                                </td>
                                <td>{{ $cate->date_create }}</td>
                                <td>{{ $cate->date_update }}</td>
                                <td>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['movies.destroy', $cate->id],
                                        'onsubmit' => 'return confirm("Bạn muốn xóa không")',
                                    ]) !!}
                                    {!! Form::submit('Xóa', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                    <a href="{{ route('movies.edit', $cate->id) }}" class="btn btn-warning">Sửa</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
