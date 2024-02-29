<?php
$localhost = "127.0.0.1";
$usuario = "root";
$senha_db = "";
$nome_db = "parkingsoft";
$porta_db = "3306";

$conn = new mysqli($localhost, $usuario, $senha_db, $nome_db, $porta_db);

// Verifique se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

