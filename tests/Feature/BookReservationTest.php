<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library() {
        $this->withoutExceptionHandling();
        $response = $this->post('/book', [
                                    'title' => 'Cool Book Title',
                                    'author' => 'Victor'
                                ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required() {
        $response = $this->post('/book', [
            'title' => '',
            'author' => 'Kingsley'
        ]);

        $response->assertSessionHasErrors('title');

    }
    /** @test */
    public function author_is_required() {
        $response = $this->post('/book', [
            'title' => 'Cool Book Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated() {
        $this->withoutExceptionHandling();
        $this->post('/book', [
            'title' => 'Cool Book',
            'author' => 'Kingsley'
        ]);

        $book = Book::first();

        $response = $this->patch('/book/'.$book->id, [
            'title' => 'New Cool Book',
            'author' => 'Kingsley Amaitsa'
        ]);

        $this->assertEquals('New Cool Book', Book::first()->title);
        $this->assertEquals('Kingsley Amaitsa', Book::first()->author);
    }

}
