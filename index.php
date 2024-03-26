<?php

session_start();

// Kelas Singleton
class Mahasiswa {

    private static $instance;
    private $daftarMahasiswa = array();

    private function __construct() {}

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Mahasiswa();
        }
        return self::$instance;
    }

    public function addMahasiswa($nama, $nim) {
        // Mendapatkan daftar mahasiswa dari session
        if (isset($_SESSION["daftarMahasiswa"])) {
            $this->daftarMahasiswa = $_SESSION["daftarMahasiswa"];
        }

        // Menambahkan data mahasiswa baru ke daftar
        $mahasiswaBaru = array(
            "nama" => $nama,
            "nim" => $nim
        );
        $this->daftarMahasiswa[] = $mahasiswaBaru;

        // Menyimpan daftar mahasiswa ke session
        $_SESSION["daftarMahasiswa"] = $this->daftarMahasiswa;
    }

    public function getDaftarMahasiswa() {
        return $this->daftarMahasiswa;
    }

}

// Mendapatkan instance singleton
$mahasiswa = Mahasiswa::getInstance();

// Menangani formulir
if (isset($_POST["nama"]) && isset($_POST["nim"])) {
    $nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $mahasiswa->addMahasiswa($nama, $nim);
}

if (isset($_POST["reset"])) {
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .reset {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Daftar Mahasiswa</h1>
    <form method="post">
        <input type="text" name="nama" placeholder="Masukkan nama" required>
        <input type="number" name="nim" placeholder="Masukkan NIM" required>
        <button type="submit">Tambahkan</button>
    </form>
    <form method="post">
        <button type="submit" name="reset" class="reset">Reset</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $daftarMahasiswa = $mahasiswa->getDaftarMahasiswa();
            foreach ($daftarMahasiswa as $mahasiswa) {
                echo "<tr>";
                echo "<td>" . $mahasiswa["nama"] . "</td>";
                echo "<td>" . $mahasiswa["nim"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

