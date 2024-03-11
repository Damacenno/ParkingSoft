<?php
session_start();
require_once("conectDB.php");


function listar_usuarios($conn, $id_usuarios)
{
    $query = "SELECT * FROM usuarios WHERE id_estac = ?";

    // Preparar a consulta
    $stmt = $conn->prepare($query);

    // Verificar se a preparação da consulta falhou
    if (!$stmt) {
        // Retornar uma mensagem de erro
        return "Erro ao preparar a consulta: " . $conn->error;
    }

    // Bind o parâmetro id_estacionamento ao statement
    $stmt->bind_param("i", $id_usuarios);

    // Executar a consulta
    if (!$stmt->execute()) {
        // Retornar uma mensagem de erro
        return "Erro ao executar a consulta: " . $stmt->error;
    }

    // Obter o resultado da consulta
    $result = $stmt->get_result();

    // Verificar se há algum resultado
    if ($result->num_rows === 0) {
        // Se não houver resultados, retornar uma mensagem indicando isso
        return "Nenhum carro encontrado para o estacionamento com o ID " . $id_usuarios;
    }

    // Criar um array para armazenar os dados
    $dados = array();

    // Loop através dos resultados e adicionar cada linha ao array de dados
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    // Retornar os dados
    return $dados;
}
