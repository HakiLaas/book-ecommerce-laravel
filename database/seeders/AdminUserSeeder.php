<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Econic',
            'email' => 'admin@econic.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create sample user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // // Create sample books
        // $books = [
        //     [
        //         'title' => 'Harry Potter and the Philosopher\'s Stone',
        //         'author' => 'J.K. Rowling',
        //         'description' => 'The first book in the Harry Potter series, following the adventures of a young wizard.',
        //         'price' => 150000,
        //         'format' => 'print',
        //         'pages' => 223,
        //         'dimensions' => '5.5 x 8.5 inches',
        //         'language' => 'English',
        //         'publisher' => 'Bloomsbury Publishing',
        //         'author_info' => 'J.K. Rowling is a British author, best known for writing the Harry Potter fantasy series.',
        //         'category' => 'Fantasy',
        //         'tags' => 'magic, wizard, adventure, fantasy',
        //     ],
        //     [
        //         'title' => 'The Great Gatsby',
        //         'author' => 'F. Scott Fitzgerald',
        //         'description' => 'A classic American novel set in the Jazz Age, exploring themes of wealth, love, and the American Dream.',
        //         'price' => 120000,
        //         'format' => 'print',
        //         'pages' => 180,
        //         'dimensions' => '5.1 x 7.8 inches',
        //         'language' => 'English',
        //         'publisher' => 'Scribner',
        //         'author_info' => 'F. Scott Fitzgerald was an American novelist and short story writer.',
        //         'category' => 'Classic Literature',
        //         'tags' => 'classic, american literature, jazz age, romance',
        //     ],
        //     [
        //         'title' => '1984',
        //         'author' => 'George Orwell',
        //         'description' => 'A dystopian social science fiction novel about totalitarian control and surveillance.',
        //         'price' => 130000,
        //         'format' => 'print',
        //         'pages' => 328,
        //         'dimensions' => '5.2 x 8.0 inches',
        //         'language' => 'English',
        //         'publisher' => 'Secker & Warburg',
        //         'author_info' => 'George Orwell was an English novelist, essayist, and critic.',
        //         'category' => 'Dystopian Fiction',
        //         'tags' => 'dystopia, politics, surveillance, science fiction',
        //     ],
        //     [
        //         'title' => 'To Kill a Mockingbird',
        //         'author' => 'Harper Lee',
        //         'description' => 'A novel about racial injustice and childhood innocence in the American South.',
        //         'price' => 140000,
        //         'format' => 'print',
        //         'pages' => 281,
        //         'dimensions' => '5.2 x 8.0 inches',
        //         'language' => 'English',
        //         'publisher' => 'J.B. Lippincott & Co.',
        //         'author_info' => 'Harper Lee was an American novelist best known for her Pulitzer Prize-winning novel.',
        //         'category' => 'Literary Fiction',
        //         'tags' => 'racial injustice, coming of age, american south, classic',
        //     ],
        //     [
        //         'title' => 'The Catcher in the Rye',
        //         'author' => 'J.D. Salinger',
        //         'description' => 'A coming-of-age story about teenage rebellion and alienation.',
        //         'price' => 110000,
        //         'format' => 'print',
        //         'pages' => 214,
        //         'dimensions' => '5.1 x 7.8 inches',
        //         'language' => 'English',
        //         'publisher' => 'Little, Brown and Company',
        //         'author_info' => 'J.D. Salinger was an American writer who is known for his widely read novel.',
        //         'category' => 'Coming of Age',
        //         'tags' => 'teenage, rebellion, alienation, coming of age',
        //     ],
        //     [
        //         'title' => 'Pride and Prejudice',
        //         'author' => 'Jane Austen',
        //         'description' => 'A romantic novel about manners, upbringing, morality, education, and marriage.',
        //         'price' => 125000,
        //         'format' => 'print',
        //         'pages' => 432,
        //         'dimensions' => '5.2 x 8.0 inches',
        //         'language' => 'English',
        //         'publisher' => 'T. Egerton, Whitehall',
        //         'author_info' => 'Jane Austen was an English novelist known primarily for her six major novels.',
        //         'category' => 'Romance',
        //         'tags' => 'romance, manners, marriage, classic literature',
        //     ],
        // ];

        // foreach ($books as $bookData) {
        //     Book::create($bookData);
        // }

        $this->command->info('Admin user and sample books created successfully!');
        $this->command->info('Admin Login: admin@econic.com / admin123');
        $this->command->info('User Login: john@example.com / user123');
    }
}