<?php

require __DIR__ . '/vendor/autoload.php'; // Pastikan autoload dari Composer

use LibrarySystem\Library;
use Carbon\Carbon;

// Membuat objek perpustakaan
$library = new Library();
$library->addBook('Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling');
$library->addBook('The Great Gatsby', 'F. Scott Fitzgerald');

// Peminjaman dan Pengembalian Buku (sama seperti di index.php)
$library->borrowBook('Harry Potter and the Sorcerer\'s Stone');
$library->returnBook('Harry Potter and the Sorcerer\'s Stone');

// Daftar buku
$books = $library->listBooks(); // Pastikan ini mengembalikan array

// Membuat PDF baru dengan TCPDF
$pdf = new \TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

// Menambahkan judul PDF
$pdf->Cell(0, 10, 'Laporan Perpustakaan', 1, 1, 'C');

// Menambahkan tabel daftar buku ke PDF
$html = '<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>';

foreach ($books as $book) {
    $html .= '<tr>
        <td>' . htmlspecialchars($book['title']) . '</td>
        <td>' . htmlspecialchars($book['author']) . '</td>
        <td>' . ($book['borrowed'] ? 'Dipinjam' : 'Tersedia') . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Menambahkan tabel ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Menghasilkan dan mendownload PDF
$pdf->Output('laporan_perpustakaan.pdf', 'D');
