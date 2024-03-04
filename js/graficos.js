function ajaxBuscaDadosGrafico() {
    $.ajax({
        type: "POST",
        url: "../func/Function_grafico.php",
        data: {},
        cache: false,
        dataType: "json",
        success: function(dados) {
            atualizaGrafico(dados);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Erro gráfico");
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

function atualizaGrafico(dadosGrafico) {
    am5.ready(function() {
        // Create root element
        var root = am5.Root.new("chartdiv");

        const myTheme = am5.Theme.new(root);

        // Move minor label a bit down
        myTheme.rule("AxisLabel", ["minor"]).setAll({
            dy: 1
        });

        // Tweak minor grid opacity
        myTheme.rule("Grid", ["minor"]).setAll({
            strokeOpacity: 0.08
        });

        // Set themes
        root.setThemes([
            am5themes_Animated.new(root),
            myTheme
        ]);

        // Create chart
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            paddingLeft: 0
        }));

        // Add cursor
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "zoomX"
        }));
        cursor.lineY.set("visible", false);

        // Create axes
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0,
            baseInterval: {
                timeUnit: "day",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
                minorGridEnabled: true,
                minGridDistance: 200,
                minorLabelsEnabled: true
            }),
            tooltip: am5.Tooltip.new(root, {})
        }));

        xAxis.set("minorDateFormats", {
            day: "dd",
            month: "MM"
        });

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        // Add series
        var series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
        }));

        // Actual bullet
        series.bullets.push(function() {
            var bulletCircle = am5.Circle.new(root, {
                radius: 5,
                fill: series.get("fill")
            });
            return am5.Bullet.new(root, {
                sprite: bulletCircle
            })
        });

        // Add scrollbar
        chart.set("scrollbarX", am5.Scrollbar.new(root, {
            orientation: "horizontal"
        }));

        // Update chart data with the received data
        series.data.setAll(dadosGrafico);

        // Make stuff animate on load
        series.appear(1000);
        chart.appear(1000, 100);
    }); // end am5.ready()
}

// Chamada da função para buscar dados do gráfico via AJAX
ajaxBuscaDadosGrafico();
