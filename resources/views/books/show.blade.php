@extends('layouts.master')

@section('title')
    {{ $book->title }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ $book->title }}</h3>
        </div>

        <div class="row">
            <!-- Book Info Section -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="Book Cover">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text"><strong>Author:</strong> {{ $book->author }}</p>
                        <p class="card-text">{{ $book->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Chapters List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Chapters</h4>
                        <ul class="list-group">
                            @foreach ($book->chapters as $chapter)
                                <li class="list-group-item">
                                    <a href="{{ route('chapters.show', $chapter->id) }}" class="text-primary">
                                        {{ $chapter->name }}
                                    </a>
                                </li>
                            @endforeach

                            @if ($book->chapters->isEmpty())
                                <li class="list-group-item">No chapters available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
