<?php
    class Koneksi {
        private $host;
        private $user;
        private $pass;
        private $db;
        private $conn;

        public function __construct($host, $user, $pass, $db) {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->db = $db;
            $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
            if (!$this->conn) {
                die("Koneksi gagal: " . mysqli_connect_error());
            }
        }

        public function getConn() {
            return $this->conn;
        }
    }

    $koneksi = new Koneksi('localhost', 'root', '', 'db_sekolah');
    $conn = $koneksi->getConn();
?>