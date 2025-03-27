<?php require_once __DIR__ . '../config/db.php';

class Usuario {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = conectarDB();
    }

    public function findByCorreo($correo) {
        $query = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crear_usuario($correo, $clave) {
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (correo, passwd) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $correo, $claveHash);
        return $stmt->execute();
    }
}
