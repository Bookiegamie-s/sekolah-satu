<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookLoan;
use App\Models\Student;
use App\Models\Book;
use Carbon\Carbon;

class BookLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::with('user')->get();
        $books = Book::where('is_active', true)->take(10)->get();

        if ($students->count() == 0 || $books->count() == 0) {
            $this->command->info('No students or books found. Please seed students and books first.');
            return;
        }

        $statusOptions = ['borrowed', 'returned', 'overdue'];

        foreach ($students as $student) {
            // Create 2-4 book loans per student
            $loanCount = rand(2, 4);
            
            for ($i = 0; $i < $loanCount; $i++) {
                $book = $books->random();
                $loanDate = Carbon::now()->subDays(rand(1, 30));
                $dueDate = $loanDate->copy()->addDays(14); // 2 weeks loan period
                $status = $statusOptions[array_rand($statusOptions)];
                
                $returnDate = null;
                if ($status === 'returned') {
                    $returnDate = $loanDate->copy()->addDays(rand(1, 14));
                }

                BookLoan::create([
                    'user_id' => $student->user_id,
                    'book_id' => $book->id,
                    'loan_date' => $loanDate,
                    'due_date' => $dueDate,
                    'return_date' => $returnDate,
                    'status' => $status,
                    'notes' => 'Peminjaman untuk ' . $student->user->name,
                ]);
            }
        }

        $this->command->info('Book loans seeded successfully!');
    }
}
