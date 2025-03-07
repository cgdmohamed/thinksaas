<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('chapters.show', compact('chapter'));
    }
}
