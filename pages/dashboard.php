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
                <th scope="col">Ação</th>

            </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
    <table id="tabelaCarros_dashboard" class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Placa</th>
                <th scope="col">Modelo</th>
                <th scope="col">Vaga</th>
                <th style=" width: 20%;" scope="col">Entrada</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php if ($registros) {
                foreach ($registros as $registro) {
                    echo "<td>" . $registro['id_registro'] . "<td>";
                    echo "<td>" . $registro[''] . "<td>";
                    echo "<td>" . $registro[''] . "<td>";
                    echo "<td>" . $registro[''] . "<td>";
                    echo "<td>" . $registro[''] . "<td>";
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