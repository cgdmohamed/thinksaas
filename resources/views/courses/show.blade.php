@extends(view: 'layouts.master')

@section('title')
    {{ __('Manage Courses') }}
@endsection

@section('content')
    <div class="container">
        <h2>{{ $course->title }}</h2>
        <p>{{ $course->description }}</p>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to Courses</a>
    </div>
@endsection
