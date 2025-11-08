<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_item_to_cart()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['price' => 10000]);
        $this->actingAs($user);

        $resp = $this->postJson(route('cart.items.add'), [
            'book_id' => $book->id,
            'quantity' => 2,
        ]);
        $resp->assertStatus(200)->assertJson(['success' => true]);

        $cart = Cart::where('user_id', $user->id)->first();
        $this->assertNotNull($cart);
        $item = CartItem::where('cart_id', $cart->id)->where('book_id', $book->id)->first();
        $this->assertNotNull($item);
        $this->assertEquals(2, $item->quantity);
        $this->assertEquals(10000, $item->unit_price);
    }

    public function test_user_can_update_item_quantity()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['price' => 5000]);
        $this->actingAs($user);
        $cart = Cart::create(['user_id' => $user->id]);
        $item = CartItem::create(['cart_id' => $cart->id, 'book_id' => $book->id, 'quantity' => 1, 'unit_price' => 5000]);

        $resp = $this->patchJson(route('cart.items.update', $item), ['quantity' => 3]);
        $resp->assertStatus(200)->assertJson(['success' => true]);
        $item->refresh();
        $this->assertEquals(3, $item->quantity);
    }

    public function test_user_cannot_update_other_users_item()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $book = Book::factory()->create(['price' => 5000]);
        $cart = Cart::create(['user_id' => $other->id]);
        $item = CartItem::create(['cart_id' => $cart->id, 'book_id' => $book->id, 'quantity' => 1, 'unit_price' => 5000]);

        $this->actingAs($user);
        $resp = $this->patchJson(route('cart.items.update', $item), ['quantity' => 2]);
        $resp->assertStatus(403);
    }

    public function test_cart_count_endpoint_returns_total_quantity()
    {
        $user = User::factory()->create();
        $book1 = Book::factory()->create(['price' => 3000]);
        $book2 = Book::factory()->create(['price' => 7000]);
        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create(['cart_id' => $cart->id,'book_id'=>$book1->id,'quantity'=>1,'unit_price'=>3000]);
        CartItem::create(['cart_id' => $cart->id,'book_id'=>$book2->id,'quantity'=>2,'unit_price'=>7000]);

        $this->actingAs($user);
        $resp = $this->getJson(route('cart.count'));
        $resp->assertStatus(200)->assertJson(['count' => 3]);
    }
}