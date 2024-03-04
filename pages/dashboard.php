<?php require "header.php";
$registros = listar_registros($conn, 1);
// var_dump($registros);
?>

<div class="content_main" id="container-form">

    <div id="chartdiv"></div>
    <table id="tabelaCarros" class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Placa</th>
                <th scope="col">Modelo</th>
                <th scope="col">Vaga</th>
                <th style=" width: 20%;" scope="col">Entrada</th>
                <th scope="col">Saída</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php if ($registros) {
                foreach ($registros as $registro) {
                    echo "<tr>";
                    echo "<td>" . $registro['placa_carro'] . "</td>";
                    echo "<td>" . $registro['modelo_carro'] . "</td>";
                    echo "<td>" . $registro['vaga_carro'] . "</td>";
                    echo "<td>" . $registro['entrada_carro'] . "</td>";
                    echo "<td>" . $registro['saida_carro'] . "</td>";
                    echo "</tr>";
                }
                ?>

                <?php
            } else {
                echo "Nenhum Registro...";
            } ?>
            <td></td>
        </tbody>
    </table>
</div>