<?php

namespace App\Http\Controllers;

use App\Models\TrainingCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Teacher')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = TrainingCourse::all();  // Fetch all books from the database

        //return TrainingCourse::where('school_id', Auth::user()->school_id)->get();
        return view('courses.index', compact('courses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = TrainingCourse::create([
            'title' => $request->title,
            'description' => $request->description,
            'school_id' => Auth::user()->school_id,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['message' => 'Course created successfully.', 'course' => $course]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingCourse $trainingCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingCourse $trainingCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCourse $trainingCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingCourse $trainingCourse)
    {
        //
    }
}
