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
        public function index()
        {
            $books = Book::all();
            return view("books.index", ["books"=>$books]);
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
            // $request->validate([
            //     'name'        => 'required',
            //     'author'      => 'required',
            //     'pages'       => 'required|numeric'

            // ]);
        
            // Book::create(Request::all());
         
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
            
            
            $book->update($request->all());
        
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
                        ->with('success','Product deleted successfully');
        
        }
}