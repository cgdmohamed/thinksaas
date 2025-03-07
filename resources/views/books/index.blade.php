@extends('layouts.master')

@section('title')
    {{ __('Manage Books') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('Manage Books') }}</h3>
        </div>

        <div class="row">
            <!-- Book Upload Form -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload Book</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="ebook_file" class="form-label">Upload eBook (EPUB/PDF)</label>
                                <input type="file" class="form-control" name="ebook_file" id="ebook_file" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Book List Section -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <h4 class="card-title">{{ __('List of Books') }}</h4>
                            <input type="search" placeholder="Search books" class="float-right form-control search-input">
                        </div>

                        <div class="d-block">
                            <!-- Responsive Book Grid -->
                            <div class="row">
                                @foreach ($books as $book)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"> <!-- Adjusted for responsiveness -->
                                        <div class="card h-100 shadow-sm">
                                            <a href="{{ route('books.show', $book->id) }}">
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    class="card-img-top img-fluid" alt="Book Cover">
                                            </a>
                                            <div class="p-1 card-body text-center">
                                                <h5 class="card-title">{{ $book->title }}</h5>
                                                <p class="card-text">Author: {{ $book->author }}</p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('books.show', $book->id) }}"
                                                    class="btn btn-primary btn-sm">View Chapters</a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this book?');">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($books->isEmpty())
                                <div class="text-center col-12">
                                    <p>No books available.</p>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
