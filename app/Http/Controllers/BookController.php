<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Kiwilan\Ebook\Ebook;
use Illuminate\Support\Facades\DB;
use App\Models\Chapter;

class BookController extends Controller
{
    // Constructor to restrict access to Super Admins only
    public function __construct()
    {
        $this->middleware('role:Super Admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }



    /**
     * Show the form to upload a book (for Super Admin).
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a new book in the database.
     */

    public function store(Request $request)
    {
        // Validate the file upload
        $validatedData = $request->validate([
            'ebook_file' => 'required|mimes:pdf,epub|max:10240', // Only PDF & EPUB, max 10MB
        ]);


        // Store the uploaded ebook file
        $filename = 'book_' . uniqid() . '.' . $request->file('ebook_file')->getClientOriginalExtension();
        $filePath = $request->file('ebook_file')->storeAs('ebooks', $filename);

        // Extract metadata using Kiwilan\Ebook\Ebook
        $ebook = Ebook::read(storage_path('app/' . $filePath));

        // Extract details
        $title = $ebook->getTitle() ?? 'Unknown Title';
        $author = $ebook->getAuthorMain() ?? 'Unknown Author';
        $description = $ebook->getDescription() ?? 'No description available';
        $fileFormat = $request->file('ebook_file')->getClientOriginalExtension();

        // Handle cover image extraction
        $coverPath = null;
        if ($coverImage = $ebook->getCover()) {
            $coverFilename = 'cover_' . uniqid() . '.png';
            $coverContents = $coverImage->getContents();
            $fullCoverPath = 'covers/' . $coverFilename;

            // Store the cover image
            Storage::disk('public')->put($fullCoverPath, $coverContents);
            $coverPath = $fullCoverPath;
        }

        // Save book details and extract chapters
        DB::transaction(function () use ($title, $author, $description, $filePath, $fileFormat, $coverPath, $ebook) {
            $book = Book::create([
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'ebook_file' => $filePath,
                'file_format' => $fileFormat,
                'status' => 1, // Default active
                'cover_image' => $coverPath,
            ]);

            // Extract and save chapters if available
            $epubParser = $ebook->getParser()?->getEpub();
            if ($epubParser) {
                $chapters = $epubParser->getChapters();
                foreach ($chapters as $chapter) {
                    Chapter::create([
                        'name' => $chapter->label(),
                        'content' => $chapter->content(),
                        'book_id' => $book->id,
                    ]);
                }
            }
        });

        return redirect()->route('books.index')->with('success', 'Book and chapters uploaded successfully!');
    }

    /**
     * Show all books in the system.
     */
    public function index()
    {
        $books = Book::all();  // Fetch all books from the database
        return view('books.index', compact('books'));
    }

    /**
     * Assign books to a specific school.
     */
    public function assignBooks(Request $request, $schoolId)
    {
        // Validate the incoming request (array of book IDs)
        $request->validate([
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',  // Ensure the books exist in the database
        ]);

        // Find the school by ID
        $school = School::findOrFail($schoolId);

        // Get package and book limit
        $package = $school->subscription->package ?? null;
        $bookLimit = $package ? $package->book_limit : 0;

        // Count current books assigned to the school
        $currentBookCount = $school->books()->count();
        $newBookCount = count($request->book_ids);

        // Check if total books after assignment exceed the limit
        if (($currentBookCount + $newBookCount) > $bookLimit) {
            return redirect()->back()->with('error', "Cannot assign more than $bookLimit books to this school.");
        }

        // Attach new books without exceeding the limit
        $existingBookIds = $school->books()->pluck('id')->toArray();
        $booksToAdd = array_diff($request->book_ids, $existingBookIds);

        if (count($booksToAdd) + $currentBookCount > $bookLimit) {
            return redirect()->back()->with('error', "Cannot assign more than $bookLimit books. Try removing some before adding.");
        }

        $school->books()->attach($booksToAdd);

        // Return a success message
        return redirect()->route('schools.show', $schoolId)->with('success', 'Books assigned to the school successfully!');
    }


    public function show($id)
    {
        $book = Book::with('chapters')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function destroy($id)
    {
        // Find the book
        $book = Book::findOrFail($id);

        DB::transaction(function () use ($book) {
            // Delete associated chapters
            $book->chapters()->delete();

            // Delete ebook file from storage
            if ($book->ebook_file && Storage::exists($book->ebook_file)) {
                Storage::delete($book->ebook_file);
            }

            // Delete cover image from storage (if available)
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            // Delete the book record from the database
            $book->delete();
        });

        return redirect()->route('books.index')->with('success', 'Book and associated data deleted successfully!');
    }
}
