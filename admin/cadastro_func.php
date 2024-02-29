<?php

require_once ("../func/conectDB.php");

$nome = $_POST['nome'];
$cnpj = $_POST['cnpj'];
$vagas = $_POST['total-vagas'];
$login = $_POST['login'];
$senha =  $_POST['senha'];


$sql = "SELECT COUNT(*) FROM estacionamentos WHERE cnpj_estac = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cnpj);

$count = null;
if ($stmt->execute()) {
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "O CNPJ já existe no banco de dados.";
    }
} else {
    $stmt->close();
    echo "Erro na consulta: " . mysqli_error($conn);
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$sql = "INSERT INTO estacionamentos (login_estac, senha_estac, nome_estac, cnpj_estac, total_vagas_estac) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $login, $senhaHash, $nome, $cnpj, $vagas);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    echo "Sucesso ao criar";
} else {
    $error_message = mysqli_error($conn);
    $stmt->close();
    $conn->close();
    echo "Erro na inserção: " . $error_message; // Retornar mensagem de erro
}
