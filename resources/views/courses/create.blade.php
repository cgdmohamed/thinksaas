@extends(view: 'layouts.master')

@section('title')
    {{ __('Manage Courses') }}
@endsection

@section('content')
    <div class="container">
        <h2>Create Training Course</h2>
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Create Course</button>
        </form>
    </div>
@endsection
