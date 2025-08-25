<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            [
                "title" => "Matematika SMP Kelas 7",
                "author" => "Tim Penulis Matematika",
                "isbn" => "978-602-1234-001",
                "publisher" => "Penerbit Pendidikan",
                "publication_year" => 2023,
                "category" => "Matematika",
                "description" => "Buku pelajaran matematika untuk SMP kelas 7",
                "total_copies" => 50,
                "available_copies" => 45,
                "shelf_location" => "A-1"
            ],
            [
                "title" => "Bahasa Indonesia SMP",
                "author" => "Dr. Bahasa Indonesia",
                "isbn" => "978-602-1234-002",
                "publisher" => "Penerbit Bahasa",
                "publication_year" => 2023,
                "category" => "Bahasa Indonesia",
                "description" => "Buku pelajaran bahasa Indonesia",
                "total_copies" => 40,
                "available_copies" => 38,
                "shelf_location" => "B-1"
            ],
            [
                "title" => "English for Junior High School",
                "author" => "John English Teacher",
                "isbn" => "978-602-1234-003",
                "publisher" => "English Publisher",
                "publication_year" => 2023,
                "category" => "Bahasa Inggris",
                "description" => "English textbook for junior high school",
                "total_copies" => 35,
                "available_copies" => 32,
                "shelf_location" => "C-1"
            ],
            [
                "title" => "IPA Terpadu SMP",
                "author" => "Tim IPA",
                "isbn" => "978-602-1234-004",
                "publisher" => "Sains Publisher",
                "publication_year" => 2023,
                "category" => "IPA",
                "description" => "Buku IPA terpadu untuk SMP",
                "total_copies" => 45,
                "available_copies" => 40,
                "shelf_location" => "D-1"
            ],
            [
                "title" => "IPS SMP Lengkap",
                "author" => "Tim IPS",
                "isbn" => "978-602-1234-005",
                "publisher" => "Sosial Publisher",
                "publication_year" => 2023,
                "category" => "IPS",
                "description" => "Buku IPS lengkap untuk SMP",
                "total_copies" => 40,
                "available_copies" => 35,
                "shelf_location" => "E-1"
            ],
            [
                "title" => "Kamus Bahasa Indonesia",
                "author" => "Tim Kamus",
                "isbn" => "978-602-1234-006",
                "publisher" => "Kamus Publisher",
                "publication_year" => 2022,
                "category" => "Referensi",
                "description" => "Kamus lengkap bahasa Indonesia",
                "total_copies" => 20,
                "available_copies" => 18,
                "shelf_location" => "F-1"
            ],
            [
                "title" => "English Dictionary",
                "author" => "Dictionary Team",
                "isbn" => "978-602-1234-007",
                "publisher" => "Dictionary Publisher",
                "publication_year" => 2022,
                "category" => "Referensi",
                "description" => "Complete English dictionary",
                "total_copies" => 25,
                "available_copies" => 22,
                "shelf_location" => "F-2"
            ],
            [
                "title" => "Atlas Indonesia",
                "author" => "Tim Geografi",
                "isbn" => "978-602-1234-008",
                "publisher" => "Geografi Publisher",
                "publication_year" => 2023,
                "category" => "Geografi",
                "description" => "Atlas lengkap Indonesia",
                "total_copies" => 15,
                "available_copies" => 13,
                "shelf_location" => "G-1"
            ],
            [
                "title" => "Sejarah Indonesia",
                "author" => "Dr. Sejarah",
                "isbn" => "978-602-1234-009",
                "publisher" => "Sejarah Publisher",
                "publication_year" => 2023,
                "category" => "Sejarah",
                "description" => "Buku sejarah Indonesia lengkap",
                "total_copies" => 30,
                "available_copies" => 28,
                "shelf_location" => "H-1"
            ],
            [
                "title" => "Ensiklopedia Sains",
                "author" => "Tim Sains",
                "isbn" => "978-602-1234-010",
                "publisher" => "Sains Publisher",
                "publication_year" => 2022,
                "category" => "Sains",
                "description" => "Ensiklopedia sains untuk pelajar",
                "total_copies" => 10,
                "available_copies" => 8,
                "shelf_location" => "I-1"
            ],
            [
                "title" => "Fisika Dasar SMP",
                "author" => "Prof. Fisika",
                "isbn" => "978-602-1234-011",
                "publisher" => "Fisika Publisher",
                "publication_year" => 2023,
                "category" => "Fisika",
                "description" => "Buku fisika dasar untuk SMP",
                "total_copies" => 25,
                "available_copies" => 23,
                "shelf_location" => "J-1"
            ],
            [
                "title" => "Kimia untuk Pemula",
                "author" => "Dr. Kimia",
                "isbn" => "978-602-1234-012",
                "publisher" => "Kimia Publisher",
                "publication_year" => 2023,
                "category" => "Kimia",
                "description" => "Buku kimia untuk pemula",
                "total_copies" => 20,
                "available_copies" => 18,
                "shelf_location" => "K-1"
            ],
            [
                "title" => "Biologi SMP",
                "author" => "Tim Biologi",
                "isbn" => "978-602-1234-013",
                "publisher" => "Biologi Publisher",
                "publication_year" => 2023,
                "category" => "Biologi",
                "description" => "Buku biologi untuk SMP",
                "total_copies" => 30,
                "available_copies" => 27,
                "shelf_location" => "L-1"
            ],
            [
                "title" => "Ekonomi Sederhana",
                "author" => "Prof. Ekonomi",
                "isbn" => "978-602-1234-014",
                "publisher" => "Ekonomi Publisher",
                "publication_year" => 2023,
                "category" => "Ekonomi",
                "description" => "Pengantar ekonomi sederhana",
                "total_copies" => 20,
                "available_copies" => 18,
                "shelf_location" => "M-1"
            ],
            [
                "title" => "Geografi Indonesia",
                "author" => "Tim Geografi",
                "isbn" => "978-602-1234-015",
                "publisher" => "Geografi Publisher",
                "publication_year" => 2023,
                "category" => "Geografi",
                "description" => "Buku geografi Indonesia",
                "total_copies" => 25,
                "available_copies" => 22,
                "shelf_location" => "N-1"
            ],
            [
                "title" => "Seni dan Budaya",
                "author" => "Seniman Indonesia",
                "isbn" => "978-602-1234-016",
                "publisher" => "Seni Publisher",
                "publication_year" => 2022,
                "category" => "Seni",
                "description" => "Buku seni dan budaya Indonesia",
                "total_copies" => 15,
                "available_copies" => 13,
                "shelf_location" => "O-1"
            ],
            [
                "title" => "Olahraga dan Kesehatan",
                "author" => "Dr. Olahraga",
                "isbn" => "978-602-1234-017",
                "publisher" => "Olahraga Publisher",
                "publication_year" => 2023,
                "category" => "Olahraga",
                "description" => "Panduan olahraga dan kesehatan",
                "total_copies" => 20,
                "available_copies" => 18,
                "shelf_location" => "P-1"
            ],
            [
                "title" => "Teknologi Informasi",
                "author" => "IT Expert",
                "isbn" => "978-602-1234-018",
                "publisher" => "IT Publisher",
                "publication_year" => 2023,
                "category" => "Teknologi",
                "description" => "Pengantar teknologi informasi",
                "total_copies" => 15,
                "available_copies" => 12,
                "shelf_location" => "Q-1"
            ],
            [
                "title" => "Kewarganegaraan",
                "author" => "Dr. Civics",
                "isbn" => "978-602-1234-019",
                "publisher" => "Civics Publisher",
                "publication_year" => 2023,
                "category" => "PKN",
                "description" => "Buku pendidikan kewarganegaraan",
                "total_copies" => 35,
                "available_copies" => 32,
                "shelf_location" => "R-1"
            ],
            [
                "title" => "Agama dan Moral",
                "author" => "Tim Agama",
                "isbn" => "978-602-1234-020",
                "publisher" => "Agama Publisher",
                "publication_year" => 2023,
                "category" => "Agama",
                "description" => "Buku pendidikan agama dan moral",
                "total_copies" => 40,
                "available_copies" => 37,
                "shelf_location" => "S-1"
            ]
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ["isbn" => $book["isbn"]],
                $book
            );
        }
    }
}
