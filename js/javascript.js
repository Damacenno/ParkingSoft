window.onload = function () {
    listarCarrosDashboard(); // QUANDO CARREGAR A PAGIMNA
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
    $("input[name='c00_entrada']").attr("realdate", timestamp); // PASSA O TIMESTAMP POR UM ATRIBUTO DA TAG
});

function callAjaxFunctions(funcao, infos) {
    var response = "";
    $.ajax({
        url: "../func/Function_registros.php",
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


// FUNCAO DE LISTAR OS CARROS - CARREGADA SEMPRE QUE home.html EH CARREGADO
function listarCarrosDashboard() {
    var response = callAjaxFunctions('listarRegistros'); // FAZ O CALLBACK DO AJAX PASSANDO A FUNCAO DO PHP DESEJADA
    if (response != "0") {
        FillTable(response);
        // FUNCAO QUE PREENCHA A TABELA COM AS INFOS
    } else {
        FillTable(0); // PASSA O VALOR PRA VERIFICAÇÃO NA FUNÇÃO
    }
}

function FillTable(carlist) {
    const table = document.getElementById("tbody"); //PEGA O CORPO DA TABELA
    if (carlist.length === 0) { // SE IGUAL A 0 RESULTADOS
        $("#vagas_ocupadas_carro").html("0");
        $("#vagas_ocupadas_moto").html("0"); // DEFINE COMO ZERO OS ESTACIONADOS
        table.innerHTML = ""; // LIMPA A TABLE PARA NÃO FICAR REGISTROS APAGADOS
        NoResults(); // FUNÇÃO PRA EXIBIR SEM CARRO ESTACIONADOS
    } else {
        var contCarro = 0; // VARIAVEL DE CONTAGEM DE CARROS ESTACIONADOS
        var contMoto = 0; // VARIAVEL DE CONTAGEM DE MOTOS ESTACIONADAS
        table.innerHTML = "";
        for (var i = 0; i < carlist.length; i++) {
            const row = document.createElement('tr');
            row.classList.add('car-row');
            for (var b = 1; b <= 7; b++) { // Ajuste o limite para 5 para incluir todas as colunas
                const col = document.createElement('td');
                // Renderiza cada propriedade do objeto na tabela
                switch (b) {
                    case 1:
                        col.innerHTML = carlist[i]['categoria'];
                        if (carlist[i]['categoria'] == 'Moto') {
                            contMoto++; // SE CATEGORIA MOTO ADD 1 MOTO NA CONTAGEM
                        } else if (carlist[i]['categoria'] == 'Carro') {
                            contCarro++; // SE CATEGORIA CARRO ADD 1 CARRO NA CONTAGEM
                        }
                        break;
                    case 2:
                        col.innerHTML = carlist[i]['vaga_auto']; // Vaga do carro
                        break;
                    case 3:
                        col.innerHTML = carlist[i]['placa_auto']; // Placa do carro
                        break;
                    case 4:
                        col.innerHTML = carlist[i]['modelo_auto']; // Modelo do carro
                        break;
                    case 5:
                        col.innerHTML = new Date(carlist[i]['entrada_auto']).toString().substring(16, 21);  // Entrada do carro
                        break;
                    case 6:
                        // CRIANDO A COLUNA DE AÇÕES - BOTOES
                        const colBotao = document.createElement('td');
                        colBotao.style.display = "flex";
                        row.appendChild(colBotao);
                        // CRIANDO O BOTAO DE SAIDA
                        const btnSaida = document.createElement('button');
                        btnSaida.innerHTML = "Saída";
                        btnSaida.classList.add('btn');
                        btnSaida.classList.add('btn-danger');
                        btnSaida.classList.add('btn-carro-saida');
                        btnSaida.dataset.bsToggle = "modal";
                        btnSaida.dataset.bsTarget = "#Saida";
                        btnSaida.setAttribute('onclick', 'abrirModalPreenchidoSaida("' + carlist[i]['placa_auto'] + '")'); // Passa a placa do carro para a função abrirModalPreenchido
                        // CRIANDO O BOTÃO DE MOVER
                        const btnMover = document.createElement('button');
                        btnMover.innerHTML = "Mover";
                        btnMover.classList.add('btn');
                        btnMover.classList.add('btn-primary');
                        btnMover.classList.add('btn-carro-mover');
                        btnMover.dataset.bsToggle = "modal";
                        btnMover.dataset.bsTarget = "#Mover";
                        btnMover.setAttribute('onclick', 'abrirModalPreenchidoMover("' + carlist[i]['placa_auto'] + '")'); // Passa a placa do carro para a função abrirModalPreenchido
                        // ADICIONANDO AMBOS OS BOTOES NA TABLE
                        colBotao.appendChild(btnMover);
                        colBotao.appendChild(btnSaida);
                        break;
                }
                row.appendChild(col); // DEPOIS DE VERIFICAR QUAL COLUNA É E CRIAR ELA - ANEXA NA LINHA
            }
            table.appendChild(row); // DEPOIS DE ANEXAR TODAS AS COLUNAS ANEXA A  LINHA NA TABELA
        }
        // FORA DO LAÇO FOR FINALIZA SETANDO O TOTAL CONTABILIZADO NO PAINEL DE VAGAS OCUPADAS
        $("#vagas_ocupadas_carro").html(contCarro);
        $("#vagas_ocupadas_moto").html(contMoto);
    }
}

// MODAL DE DAR SAIDA PREENCHIDO
function abrirModalPreenchidoSaida(placa) { // O PARAMETRO PLACA É PASSADO PELO BOTAO
    var response = callAjaxFunctions('selectRegistro', placa);  // USA A FUNÇÃO DE SELECT NO PHP PRA PEGAR O CARRO EM QUESTÃO USANDO A PLACA
    // DEFININDO OS CAMPOS DE ACORDO COM A RESPOSTA
    // COLOCA A PLACA REFERENTE NO TITULO DO MODAL DE SAIDA
    $("#placa-titulo-saida").html(placa);
    // COLOCA A ENTRADA DO MODAL NO CAMPO DE ENTRADA NO MODAL DE SAIDA
    // O VALOR DA RESPOSTA É EM TIMESTAMP - ENTÃO NESSA LINHA CONVERTE PRA DATA E FORMATA PRA EXCLUIR INFOS EXTRAR -- SOMENTE VISUAL
    $("#entrada-modal").html(new Date(response[0][5]).toString().substring(16, 21));
    // COLOCA NA SAIDA A HORA EM QUE O BOTÃO DE SAIDA FOI CLICADO NAO SENDO POSSIVEL ALTERAR -- EVITAR FRAUDES
    // MESMA LOGICA DO VALOR DE ENTRADA, PEGA EM TIMESTAMP CONVERTE E DEPOIS FORMATA VISUALMENTE
    $("#saida-modal").html(new Date().toString().substring(16, 21));
    // CRIA UMA VARIAVEL TEMPORARIA PRA CALCULAR O TEMPO QUE FICOU ESTACIONADO
    var dataTemp = new Date();
    // VARIAVEL DE HORAS PERMANECIDAS -- SUBTRAI OS TIMESTAMP DE ENTRADA E SAIDA E CONVERTE OS MILISSEGUNDOS EM HORAS
    // ARREDONDA O RESULTADO PRA BAIXO -- OU SEJA SE FICOU 4.75 HORAS ELE FICOU 4 HORAS FECHADAS
    var horasPermanecidas = Math.floor((dataTemp.getTime() - response[0][5]) / 60 / 60 / 1000);
    // USANDO AS HORAS PERMANECIDAS CALCULADAS CHAMA A FUNÇÃO QUE VAI CALCULAR O PREÇO QUE DEVE SE PAGAR
    calcularPrecoSaida(horasPermanecidas);
}

function abrirModalPreenchidoMover(placa) { // O PARAMETRO PLACA É PASSADO PELO BOTAO
    var response = callAjaxFunctions('selectRegistro', placa); // USA A FUNÇÃO DE SELECT NO PHP PRA PEGAR O CARRO EM QUESTÃO USANDO A PLACA
    // DEFININDO OS CAMPOS DE ACORDO COM A RESPOSTA
    // COLOCA A PLACA REFERENTE NO TITULO DO MODAL DE MOVER
    $("#placa-titulo-mover").html(placa);
    // COLOCA A VAGA EM QUE ESTA ESTACIONADO
    $("input[name='vaga_atual']").val(response[0][4]);
    // COLOCA A CATEGORIA DO AUTOMOVEL NO TITULO PARA O USUARIO IDENTIFICAR MELHOR
    $("#categoria-titulo-mover").html(response[0][2]);
}

function calcularPrecoSaida(horasPermanecidas) {
    if (horasPermanecidas < 1) { // SE FOR MENOS DE UMA HORA USA A TAXA FIXA DO ESTACIONAMENTO
        var response = callAjaxFunctions('calcularPrecoSaida', 'taxaFixa');
        $("#total-modal").html("R$" + response);
    } else if (horasPermanecidas > 24){ // SE FOR MAIS DE UMA HORA
        var checagem = callAjaxFunctions('checaAceitaDiaria'); // VERIFICA SE O ESTACIONAMENTO EM QUESTÃO ACEITA DIARIA
        if(checagem == 0){ // SE NAO ACEITA DIARIA
            var res = callAjaxFunctions('calcularPrecoSaida', 'taxaComum'); // BUSCA A TAXA COMUM - O PRECO POR HORA
            total = res * horasPermanecidas;
            $("#total-modal").html("R$" + total);
        } else if (checagem == 1) { // SE ACEITA DIARIA
            var resp = callAjaxFunctions('calcularPrecoSaida', 'taxaDiaria'); // BUSCA A TAXA DIARIA - PRECO DIARIA
            $("#total-modal").html("R$" + resp);
        }
    } else {
        var res = callAjaxFunctions('calcularPrecoSaida', 'taxaComum');
        total = res * horasPermanecidas;
        $("#total-modal").html("R$" + total);
    }
}

function saidaCarro() {
    var placa = $("#placa-titulo-saida").html();
    var response = callAjaxFunctions('saidaRegistro', placa);
    if (response != 0) {
        listarCarrosDashboard();
        $('#box').prop('checked', false);
        $('#box').prop('disabled', false);
        $('#btn-saida').prop('disabled', true);
    } else {
        alert("Ocorreu um erro inesperado - Contate um admnistrador"); // ERRO PRA REMOVER O CARRO
    }
}

function moverCarro() {
    var placa = $("#placa-titulo-mover").html();
    var categoria = $("#categoria-titulo-mover").html();
    var direcionada = $("input[name='vaga_direcionada']").val();

    let infos = [
        direcionada,
        placa,
        categoria
    ];

    console.log(infos);
    var response = callAjaxFunctions('moverRegistro', infos);
    if (response != 0) {
        listarCarrosDashboard();
    } else if (response == 200) {
        alert("Vaga inválida");  // ERRO PRA MOVER O CARRO!
    } else {
        alert("Ocorreu um erro inesperado - Contate um admnistrador");
    }

    switch (response) {
        case '199':
            alert('Vaga além do limite');
            break;
        case '200':
            alert("Vaga inválida");
            break;
        case '202':
            alert("Vaga já ocupada");
            break;
        case '0':
            alert("Erro inesperado - Contate um administrador");
            break;

    }
}


// FUNCAO QUE INSERE O "SEM RESULTADOS QUANDO NÃO TEM NENHUM CARRO REGISTRADO"
function NoResults() {
    const table = $("#tbody");
    const div = document.createElement('div');
    table.append(div);
    const msg = document.createElement('h6');
    msg.innerHTML = "Nenhum automóvel estacionado";
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
    var Ccat = $("select[name='c00_categoria']").find(":selected").val();


    let infos = [
        Cplaca,
        Cmodelo,
        Cvaga,
        Centrada,
        Ccat
    ];

    $("#Estacionar").modal('hide');
    $("input[name='c00_placa']").val("");
    $("input[name='c00_modelo']").val("");
    $("input[name='c00_vaga']").val("");
    $("select[name='c00_categoria']").val('Selecionar').change();

    var i = 0;
    for (a in infos) {
        if (infos[a] == "") {
            camposNulos();
            break;
        } else {
            i++
        }
    }
    if (i == 5) {
        var response = callAjaxFunctions('estacionarRegistro', infos);

        switch (response) {
            case 1:
                $("#Estacionar").modal('hide');
                $("input[name='c00_placa']").val("");
                $("input[name='c00_modelo']").val("");
                $("input[name='c00_vaga']").val("");
                $("select[name='c00_categoria']").val(1);
                listarCarrosDashboard();
                break;
            case '199':
                alert('Seu estacionamento não possui essa quantidade de vagas');
                break;
            case '200':
                alert('Vaga inválida. Insira um valor válido.');
                break;
            case '201':
                alert("Um automóvel com esta placa está estacionado atualmente");
                break;
            case '202':
                alert('Esta vaga já está ocupada');
                break;
            case '203':
                alert('Não cabem mais carros no seu estacionamento');
                break;
        }
    }
}
