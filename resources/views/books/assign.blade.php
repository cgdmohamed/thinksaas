@extends('layouts.master')

@section('title')
    {{ __('Assign Books to School') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('Assign Books') }}
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Assign Books to a School</h4>

                        <form action="{{ route('books.assign.store', $school->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="book_ids" class="form-label">Select Books</label>
                                <select class="form-control select2" name="book_ids[]" id="book_ids" multiple required>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }} by {{ $book->author }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="float-right ml-3 btn btn-theme">Assign Books</button>
                            <a href="{{ route('schools.index') }}" class="float-right btn btn-secondary">Cancel</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
