<?php

require __DIR__ . '/vendor/autoload.php'; // Pastikan autoload dari Composer

use LibrarySystem\Library;
use Carbon\Carbon;

// Membuat objek perpustakaan
$library = new Library();

// Menambahkan buku ke perpustakaan
$library->addBook('Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling');
$library->addBook('The Great Gatsby', 'F. Scott Fitzgerald');

// Meminjam buku
echo "Meminjam buku: " . $library->borrowBook('Harry Potter and the Sorcerer\'s Stone') . " pada " . Carbon::now()->toDateTimeString() . "<br><br>";

// Menampilkan daftar buku setelah peminjaman
echo "<h3>Daftar Buku Setelah Peminjaman:</h3>";
$listBooks = $library->listBooks();
displayBooks($listBooks);

// Mengembalikan buku
echo "<br>Mengembalikan buku: " . $library->returnBook('Harry Potter and the Sorcerer\'s Stone') . " pada " . Carbon::now()->toDateTimeString() . "<br><br>";

// Menampilkan daftar buku setelah pengembalian
echo "<h3>Daftar Buku Setelah Pengembalian:</h3>";
$listBooks = $library->listBooks();
displayBooks($listBooks);

// Fungsi untuk menampilkan buku dalam format HTML tabel
function displayBooks($books) {
    if (!is_array($books) || empty($books)) {
        echo "Tidak ada buku dalam perpustakaan.";
        return;
    }

    echo '<table border="1" cellpadding="10" cellspacing="0">';
    echo '<tr><th>Judul Buku</th><th>Penulis</th><th>Status</th></tr>';

    foreach ($books as $book) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($book['title']) . '</td>';
        echo '<td>' . htmlspecialchars($book['author']) . '</td>';
        echo '<td>' . ($book['borrowed'] ? 'Dipinjam' : 'Tersedia') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

?>

<!-- Tombol Download PDF -->
<form action="generate_pdf.php" method="post">
    <button type="submit">Download Daftar Buku</button>
</form>
