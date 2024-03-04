<?php
require("Function_registros.php");

$registros = listar_registros($conn, 1);

$dados = array();
foreach ($registros as $registro) {
    $timestamp = strtotime($registro['entrada_carro']) * 1000;

    $valorY = 1;

    $registro_vaga = array($timestamp, $valorY);

    $dados[] = $registro_vaga;
}

echo json_encode($dados);
?>