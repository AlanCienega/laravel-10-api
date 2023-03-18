<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreBook, UpdateBook};
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBook $request)
    {
        Book::create($request->validated());
        return response()->json(
            ['message' => 'Libro guardado exitosamente']
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBook $request, Book $book)
    {
        $book->fill($request->validated());
        $book->save();
        return response()->json(
            ['message' => 'Libro actualizado exitosamente']
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(
            ['message' => 'Libro eliminado exitosamente']
        );
    }
}
