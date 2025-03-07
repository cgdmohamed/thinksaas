@extends(view: 'layouts.master')

@section('title')
    {{ __('Manage Courses') }}
@endsection

@section('content')
    <div class="container">
        <h2>Edit Training Course</h2>
        <form action="{{ route('courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $course->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Course</button>
        </form>
    </div>
@endsection
