<?php
require("Function_registros.php");

if ($_REQUEST) {
    $registros = listar_registros($conn, 1);

    $registros_vagas = array();
    foreach ($registros as $registro) {
        // Extrai a data de entrada do registro e converte para milissegundos
        $valorX = $registro['entrada_auto'] * 1000; // Multiplica por 1000 para converter para milissegundos

        // Extrai o valor Y do registro (substitua 'valorY' pelo nome do campo correto)
        $valorY = 1; // Substitua 'valorY' pelo nome do campo correto

        $registro_vaga = array($valorX, $valorY); // Inverte a ordem dos valores
        $registros_vagas[] = $registro_vaga;
    }

    $dados = Array(
        Array(
            "name" => 'estacionados',
            "data" => $registros_vagas
        )
    );

    echo json_encode($dados); // Alterado para echo em vez de return}
}
