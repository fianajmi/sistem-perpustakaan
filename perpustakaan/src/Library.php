<?php

namespace LibrarySystem;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

class Library
{
  private $books = [];
  private $log;

  public function __construct()
  {
    // Inisialisasi logger
    $this->log = new Logger('library');
    $this->log->pushHandler(new StreamHandler(__DIR__.'/../logs/library.log', Logger::INFO));
  }

  // Menambahkan buku ke perpustakaan
  public function addBook($title, $author)
  {
    $this->books[] = [
      'title' => $title,
      'author' => $author,
      'borrowed' => false,
      'borrowed_at' => null,
      'returned_at' => null
    ];
    $this->log->info("Buku baru ditambahkan: {$title} oleh {$author}");
  }

  // Meminjam buku
  public function borrowBook($title)
  {
    foreach ($this->books as &$book) {
      if ($book['title'] === $title && !$book['borrowed']) {
        $book['borrowed'] = true;
        $book['borrowed_at'] = Carbon::now();
        $this->log->info("Buku dipinjam: {$title} pada {$book['borrowed_at']}");
        return "Buku '{$title}' telah dipinjam. \n";
      }
    }

    return "Buku '{$title}' tidak tersedia atau sudah dipinjam. \n";
  }

  // Mengembalikan buku
  public function returnBook($title)
  {
    foreach ($this->books as &$book) {
      if ($book['title'] === $title && $book['borrowed']) {
        $book['borrowed'] = false;
        $book['returned_at'] = Carbon::now();
        $this->log->info("Buku dikembalikan: {$title} pada {$book['returned_at']}");
        return "Buku '{$title}' telah dikembalikan. \n";
      }
    }

    return "Buku '{$title}' belum dipinjam. \n";
  }

  // Melihat semua buku di perpustakaan
  public function listBooks() {
    return $this->books;
  }

}
