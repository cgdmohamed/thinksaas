@extends('layouts.master')

@section('title')
    {{ $chapter->name }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ $chapter->name }}</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $chapter->name }}</h4>
                        <hr>
                        <div class="chapter-content">
                            {!! $chapter->content !!}
                        </div>
                        <a href="{{ route('books.show', $chapter->book_id) }}" class="mt-3 btn btn-secondary">Back to
                            Book</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
