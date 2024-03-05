<?php
require "header.php";
require "../func/Function_grafico.php";

$registros = listar_registros($conn, 1);
// var_dump($registros);
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<div class="content_main" id="container-form">
    <figure class="highcharts-figure">
        <div id="container" style="width:95%;"></div>
    </figure>

  
    <figure class="highcharts-figure">
        <div id="container" style="width:95%;"></div>
    </figure>

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
        <?php if ($registros) {
            foreach ($registros as $registro) {
                echo "<tr>";
                echo "<td>" . $registro['placa_carro'] . "</td>";
                echo "<td>" . $registro['modelo_carro'] . "</td>";
                echo "<td>" . $registro['vaga_carro'] . "</td>";
                echo "<td>" . date('H:i', $registro['entrada_carro'] / 1000) . "</td>";
                echo "<td>" . date('H:i', $registro['saida_carro'] / 1000) . "</td>";
                echo "</tr>";
            }
        } ?></tbody>

    </table>
</div>
<script>
    function atualizaGrafico(dadosGrafico) {
        $("#container").html("");

        var newType = $(".tipo_grafico:checked").val() == 1 ? "column" : "line";
        if (dadosGrafico == null)
            ajaxBuscaDadosGrafico();

        chart = Highcharts.chart('container', {
            chart: {
                type: 'column', //"column"
            },
            plotOptions: {
                column: {
                    borderWidth: 0, // Remover a borda branca
                    stroke: "none",
                }
            },
            title: {
                text: null
            },
            legend: {
                itemStyle: {
                    color: 'black' // Cor das legendas
                }
            },
            yAxis: {
                labels: {
                    style: {
                        color: 'black' // Cor das "legendas" do eixo Y
                    }
                },
                title: {
                    text: '',
                },
                stackLabels: {
                    enabled: true
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            xAxis: {
                labels: {
                    style: {
                        color: 'black' // Cor das "legendas" do eixo X
                    },
                },
                type: 'datetime', // Tipo do eixo X
            },
            series: dadosGrafico,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },
            time: {
                useUTC: false,
                timezone: 'America/Sao_Paulo',
            },
            colors: ["#8AE4D2", "#FFAFA3", "#FF7673", "#F27649", "#CA8D8D", "#C287FF", "#9747FF", "#5962FF", "#7E81B0", "#1CB8F2", "#028FC3", "#48DBDB", "#58C900", "#096066"]
        });
    }


    function ajaxBuscaDadosGrafico() {

        $.ajax(
            {
                type: "POST",
                url: "../func/Function_grafico.php",
                data:
                {
                    ajax: true
                },
                cache: false,
                dataType: "json",
                success: function (dados) {
                    dadosGrafico = dados;
                    console.log(dadosGrafico);
                    atualizaGrafico(dadosGrafico);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Erro gráfico");
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
    }


    ajaxBuscaDadosGrafico();

</script>
