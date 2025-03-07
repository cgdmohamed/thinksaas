@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Book</h2>
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
            </div>
            <div class="form-group">
                <label>Upload New File (Optional)</label>
                <input type="file" name="book_file" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Update Book</button>
        </form>
    </div>
@endsection
