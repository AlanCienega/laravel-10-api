<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_books()
    {
        $books = Book::factory(2)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertJsonFragment(
            [
                'title' => $books[0]->title,
            ]
        )->assertJsonFragment(
            [
                'title' => $books[1]->title,
            ]
        );
    }

    /** @test */
    public function can_show_book()
    {
        $book = Book::factory()->create();
        $response = $this->getJson(route('books.show', $book));
        $response->assertJsonFragment(
            ['title' => $book->title]
        );
    }

    /** @test */
    public function can_create_book()
    {
        $this->postJson(route('books.store'), [])->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'), ['title' => 'I robot'])
            ->assertJson(['message' => 'Libro guardado exitosamente']);

        $this->assertDatabaseHas('books', ['title' => 'I robot']);
    }

    /** @test */
    public function can_update_book()
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), [])->assertJsonValidationErrorFor('title');

        $this->putJson(route('books.update', $book),[
            'title' => 'updated book'
        ])->assertJson(['message' => 'Libro actualizado exitosamente']);

        $this->assertDatabaseHas('books', ['title' => 'updated book']);
    }

    /** @test */
    public function can_delete_book()
    {
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy', $book))->assertJson(
            ['message' => 'Libro eliminado exitosamente']
        );
    }
}
