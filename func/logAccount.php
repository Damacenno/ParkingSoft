<?php
require_once('conectDB.php');
session_start();

$login = $_POST["login"];
$senha = $_POST["senha"];

$sql = "SELECT * FROM usuarios WHERE login_estac = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows >= 1) {
        $row = $result->fetch_assoc();
        $senha_hash = $row['senha_estac'];
        if (password_verify($senha, $senha_hash)) {
            $_SESSION['user'] = [
                'id' => $row['id_estac'],
                'total-vagas_carro' => $row['total_vagas_carro_estac'],
                'total-vagas_moto' => $row['total_vagas_moto_estac'],
            ];
            echo json_encode(200);
        } else {
            echo json_encode(203);
        }
    } else {
        echo json_encode(401);
    }
}
