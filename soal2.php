<?php
$n = intval(readline("Masukkan batas bilangan prima: "));

// Fungsi untuk mengecek apakah suatu bilangan prima
function isPrime($num)
{
    if ($num < 2) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

// Looping untuk menampilkan bilangan prima
for ($i = 2; $i <= $n; $i++) {
    if (isPrime($i)) {
        echo $i . ", ";
    }
}

echo "\n"; // Pindah ke baris baru