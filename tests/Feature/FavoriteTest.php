<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_toggle_favorite()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user);

        // Add
        $resp = $this->postJson(route('favorites.toggle'), ['book_id' => $book->id]);
        $resp->assertStatus(200)->assertJson(['status' => 'added']);
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'book_id' => $book->id]);

        // Remove
        $resp = $this->postJson(route('favorites.toggle'), ['book_id' => $book->id]);
        $resp->assertStatus(200)->assertJson(['status' => 'removed']);
        $this->assertDatabaseMissing('favorites', ['user_id' => $user->id, 'book_id' => $book->id]);
    }

    public function test_favorites_count_endpoint()
    {
        $user = User::factory()->create();
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();
        Favorite::create(['user_id' => $user->id, 'book_id' => $book1->id]);
        Favorite::create(['user_id' => $user->id, 'book_id' => $book2->id]);

        $this->actingAs($user);
        $resp = $this->getJson(route('favorites.count'));
        $resp->assertStatus(200)->assertJson(['count' => 2]);
    }
}