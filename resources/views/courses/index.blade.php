@extends('layouts.master')

@section('title')
    {{ __('Manage Courses') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Manage Courses') }}
            </h3>
        </div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">Add New Course</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->description }}</td>
                        <td>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
