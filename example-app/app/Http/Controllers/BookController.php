<?php

namespace App\Http\Controllers;

use App\Jobs\ThumbnailJob;
use \Illuminate\Http\Request;
use App\Models\Book;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_by = $request->query('sortby');

        $order = 'ASC';

        $sort_by_key = $sort_by;

        if ($sort_by != null) {
            if ($sort_by[0] == '-') {
                $order = 'DESC';
                $sort_by = substr($sort_by, 1);
            }
        }

        if ($sort_by == null) {
            $sort_by = "id";
        }

        $books = Book::orderBy($sort_by, $order)->paginate(15);    

        return view("books.index", ["books" => $books, "sortby" => $sort_by_key]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Auth::check() == false) {
            return redirect()->back()
                ->withErrors('Only authorized users can create books');
        }

        return view("books.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check() == false) {
            return redirect()->back()
                ->withErrors('Only authorized users can create books');
        }

        $book = new Book;
        $book->book   = $request->get('book');
        $book->author = $request->get('author');
        $book->pages  = $request->get('pages');
        $book->save();

        $image = $request->file('image');
        $description = $request->get('description');

        $image->store('files', 'public');
        dispatch(new ThumbnailJob($image->getRealPath(), $image->hashName()));
        $file = new File;
        $file->path = $image->hashName();
        $file->description = $description;
        $file->book = $book->id;

        $file->save();

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $files = File::where('book', '=', $id)->get();
        // ddd($files);

        return view('books.show', compact(['book', 'files']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $book = Book::find($id);
        if (Auth::id() != $book->user_id) {
            return redirect()->back()
                ->withErrors('Only authorized users can edit this book');
        }


        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $book = Book::find($id);
        $book->book   = $request->get('book');
        $book->author = $request->get('author');
        $book->pages  = $request->get('pages');
        $book->user_id = Auth::id();

        $book->save();

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $book = Book::find($id);
        $book->delete();

        if (Auth::id() != $book->user_id) {
            return redirect()->route('books.index')
                ->withErrors('Only authorized users can delete this book')
                ->withInput($request->except('password'));
        }

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
