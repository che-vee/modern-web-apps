<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Models\Book;

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
    
            if($sort_by != null) {
                if($sort_by[0] == '-'){
                    $order = 'DESC';
                    $sort_by = substr($sort_by, 1);
                }
            }

            if($sort_by == null) {
                $sort_by = "id";
            }

            $books = Book::orderBy($sort_by, $order)->Paginate(15);      

            return view("books.index", ["books"=>$books, "sortby"=>$sort_by_key]);
        }
    
        /**
            * Show the form for creating a new resource.
            *
            * @return \Illuminate\Http\Response
            */
        public function create()
        {
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
            $book = new Book;
            $book->book   = $request->get('book');
            $book->author = $request->get('author');
            $book->pages  = $request->get('pages');
            
            $book->save();
            return redirect()->route('books.index')
                            ->with('success','Book created successfully.');
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

            return view('books.show',compact('book'));
        }
    
        /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
        public function edit($id)
        {
            $book = Book::find($id);

            return view('books.edit',compact('book'));
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
            
            $book->save();
            // $book->update($request->all());
        
            return redirect()->route('books.index')
                            ->with('success','Book updated successfully');
        }
    
        /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
        public function destroy($id)
        {
            $book = Book::find($id);
            $book->delete();

    
            return redirect()->route('books.index')
                        ->with('success','Book deleted successfully');
        
        }
}