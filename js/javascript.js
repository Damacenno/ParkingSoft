window.onload = function () {
    listarCarrosDashboard();
};

// VERIFICACAO DA CHECKBOX DO MODAL DE DAR SAIDA NO CARRO 
$("#box").on("change", function () {
    if ($('#box').prop('checked')) {
        $("#btn-saida").prop("disabled", false);
        $("#box").prop("disabled", true);
    }
});


// BOTAO QUE ABRE O MODAL DE ESTACIONAR -- DEFINI PRA ELE SETAR O HORARIO AUTOMATICAMENTE NO INPUT SEM O USUARIO PODER ALTERAR
$("#btn_estacionar").on("click", function (e) {
    var timestamp = new Date().getTime();
    var hora = new Date(timestamp);
    var dataExibicao = hora.toString().substring(16, 25);
    $("input[name='c00_entrada']").val(dataExibicao); // O VALOR EXIBIDO PRO USUARIO É SÓ HH:MM:SS
    $("input[name='c00_entrada']").attr("realdate", timestamp);
});

// FUNCAO DE LISTAR OS CARROS - CARREGADA SEMPRE QUE home.html EH CARREGADO
function listarCarrosDashboard() {
    var response = callAjaxFunctions('listarCarros'); // FAZ O CALLBACK DO AJAX PASSANDO A FUNCAO DO PHP DESEJADA
    if (response != "0") {
        FillTable(response);
        // FUNCAO QUE PREENCHA A TABELA COM AS INFOS
    } else {
        FillTable(0);
    }
}

function FillTable(carlist) {
    const table = document.getElementById("tbody");
    if (carlist.length === 0) {
        $("#vagas_ocupadas").hmtl(0);
        table.innerHTML = "";
    } else {
        var cont = 0;
        table.innerHTML = "";
        for (var i = 0; i < carlist.length; i++) {
            const row = document.createElement('tr');
            row.classList.add('car-row');
            for (var b = 1; b <= 5; b++) { // Ajuste o limite para 5 para incluir todas as colunas
                const col = document.createElement('td');
                // Renderiza cada propriedade do objeto na tabela
                switch (b) {
                    case 1:
                        col.innerHTML = carlist[i]['placa_carro']; // Placa do carro
                        break;
                    case 2:
                        col.innerHTML = carlist[i]['modelo_carro']; // Modelo do carro
                        break;
                    case 3:
                        col.innerHTML = carlist[i]['vaga_carro']; // Vaga do carro
                        break;
                    case 4:
                        col.innerHTML = new Date(carlist[i]['entrada_carro']).toString().substring(16, 21);  // Entrada do carro
                        break;
                    case 5:
                        const colBotao = document.createElement('td');
                        row.appendChild(colBotao);
                        const btn = document.createElement('button');
                        btn.innerHTML = "Saída";
                        btn.classList.add('btn');
                        btn.classList.add('btn-danger');
                        btn.classList.add('btn-carro-saida');
                        btn.dataset.bsToggle = "modal";
                        btn.dataset.bsTarget = "#Saida";
                        btn.setAttribute('onclick', 'abrirModalPreenchido("' + carlist[i]['placa_carro'] + '")'); // Passa a placa do carro para a função abrirModalPreenchido
                        colBotao.appendChild(btn);
                        break;
                }
                row.appendChild(col);
            }
            cont++;
            table.appendChild(row);
        }
        $("#vagas_ocupadas").html(cont);
    }
}


function callAjaxFunctions(funcao, infos) {
    var response = "";
    $.ajax({
        url: "../func/FunctionCarros.php",
        type: "POST",
        async: false,
        data: { function: funcao, info: infos }, // DADOS PARA SEREM JOGADOS NO ARQUIVO PHP
        datatype: "json",
    }).done(function (phpReturnFunction) {
        if (phpReturnFunction == 0) {
            response = "0";
        } else {
            let res = JSON.parse(phpReturnFunction);
            response = res; // PEGA A LISTA CONVERTIDA DE JSON E ATRIBUI A VARIAVEL DE MAIOR ESCOPO PRA DAR UM RETORNO
        }
    }).fail(function (textStatus) {
        response = "Falha";
    });
    return response;
}
// MODAL DE DAR SAIDA PREENCHIDO
function abrirModalPreenchido(placa) {
    var response = callAjaxFunctions('selectCarro', placa);
    $("#placa-titulo").html(response[0][1]);
    $("#entrada-modal").html(new Date(response[0][4]).toString().substring(16, 21));
    $("#saida-modal").html(new Date().toString().substring(16, 21))
    var dataTemp = new Date();
    var horasPermanecidas = Math.floor((dataTemp.getTime() - response[0][4]) / 60 / 60 / 1000);
    calcularPrecoSaida(horasPermanecidas);
}

function calcularPrecoSaida(horas) {
    if (horas < 1) {
        var response = callAjaxFunctions('calcularPrecoSaida', 'taxaFixa');
        $("#total-modal").html("R$" + response);
    } else {
        var res = callAjaxFunctions('calcularPrecoSaida','0');
        total = res * horas;
        $("#total-modal").html("R$" + total);
    }
}

function saidaCarro() {
    var placa = $("#placa-titulo").html();
    var response = callAjaxFunctions('saidaCarro', placa);
    if (response != 0) {
        listarCarrosDashboard();
        $('#box').prop('checked', false);
        $('#box').prop('disabled', false);
        $('#btn-saida').prop('disabled', true);
    } else {
        alert("Ocorreu um erro inesperado - Contate um admnistrador"); // ERRO PRA REMOVER O CARRO
    }
}

function NoResults() {
    const table = $("#tbody");
    const div = document.createElement('div');
    div.style.textAlign = 'center';
    table.appendChild(div);
    const msg = document.createElement('h6');
    msg.innerHTML = "Sem carros estacionados";
    div.appendChild(msg);
}
function camposNulos() {
    alert("Preencha todos os campos igualmente");
}
function estacionar() {
    var Cplaca = $("input[name='c00_placa']").val();
    var Cmodelo = $("input[name='c00_modelo']").val();
    var Cvaga = $("input[name='c00_vaga']").val();
    var Centrada = $("input[name='c00_entrada']").attr('realdate');

    let infos = [
        Cplaca,
        Cmodelo,
        Cvaga,
        Centrada
    ];

    var i = 0;
    for (a in infos) {
        if (infos[a] == "") {
            camposNulos();
            break;
        } else {
            i++
        }
    }
    if (i == 4) {
        var response = callAjaxFunctions('estacionarCarro', infos);
        switch (response) {
            case 1:
                $("#Estacionar").modal('hide');
                $("input[name='c00_placa']").val("");
                $("input[name='c00_modelo']").val("");
                $("input[name='c00_vaga']").val("");
                listarCarrosDashboard();
                break;
            case '201':
                alert("Limite de carros atingido");
                break;
            case '202':
                alert('Este carro já está estacionado');
                break;
            case '203':
                alert('Um carro já está ocupando está vaga');
                break;
        }
    }
}