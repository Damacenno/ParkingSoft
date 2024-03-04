<?php require "header.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title>Configuraçoões</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>

    <body>
        <div class="content_main" id="container-form">
            <form class="row g-3">
                <h5>Informações do Estacionamento <span>!</span></h5>
                <div class="col-md-6">
                    <label for="input_razao" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="input_razao" value='João Estacionamentos' disabled>
                </div>
                <div class="col-md-6">
                    <label for="input_cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="input_cnpj" value="69.696.696/6969-69" disabled>
                </div>
                <div class="col-md-6">
                    <label for="input_endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="input_endereco" value="Rua Barao de Jundiai"
                        disabled>
                </div>
                <div class="col-md-3">
                    <label for="input_bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="input_bairro" value="Jardim Italia" disabled>
                </div>
                <div class="col-md-3">
                    <label for="input_numero" class="form-label">Numero</label>
                    <input type="number" class="form-control" id="input_numero" value="69" disabled>
                </div>
                <div class="col-md-3">
                    <label for="inputTotal" class="form-label">Email de contato</label>
                    <input type="email" class="form-control" id="inputTotal" disabled value="estacionamento@gmail.com">
                </div>
                <div class="col-md-3">
                    <label for="inputTelefone" class="form-label">Telefone de contato</label>
                    <input type="email" class="form-control" id="inputTelefone" disabled value="14 96654-9865">
                </div>
                <div class="col-md-3">
                    <label for="inputTotal" class="form-label">Total de vagas</label>
                    <input type="number" class="form-control" id="inputTotal">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Enviar SMS para os clientes
                        </label>
                    </div>
                </div>
                <hr>
                <h5 style="padding:0; margin:0;">Informações de Cobrança</h5>
                <div class="col-md-8">
                    <label for="inputState" class="form-label">Tipo de cobrança</label>
                    <select id="inputState" class="form-select">
                        <option selected>Por hora</option>
                        <option>Por dia</option>
                        <option>Taxa única</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="inputCity" class="form-label">Preço/hr</label>
                    <input type="number" class="form-control" id="inputCity">
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Aceita pagamento antecipado
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Aceita convênio
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Aceita Diária
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Aceita Mensal
                        </label>
                    </div>
                </div>
                <hr>
                <h5 style="padding:0; margin:0;">Informações de SMS</h5>
                <div class="col-md-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Mensagem SMS</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="col-md-12">
                    <p style="text-align:justify;">O profissional responsável pelo seu treinamento, possui a
                        obrigação de te instruir em como construir uma mensagem SMS automática para seus clientes,
                        portanto, caso não tenha recebido devido treinamento, entre em contato <a href="#">clicando
                            aqui</a></p>
                </div>
                <div class="accordion" id="expandirExplicacoes">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#variavel-1" aria-expanded="true" aria-controls="variavel-1">
                                Informações do cliente
                            </button>
                        </h2>
                        <div id="variavel-1" class="accordion-collapse collapse" data-bs-parent="#expandirExplicacoes">
                            <div class="accordion-body">
                                <strong>?-nome-? /</strong> Use este valor para atribuir o Nome do cliente à
                                mensagem
                                <br>
                                <strong>?-telefone-? /</strong> Use este valor para atribuir o Numero do cliente à
                                mensagem
                                <br>
                                <strong>?-agendamento-? /</strong> Use este valor para atribuir as Horas Agendadas
                                pelo cliente à mensagem
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#variavel-2" aria-expanded="false" aria-controls="variavel-2">
                                Informações do carro
                            </button>
                        </h2>
                        <div id="variavel-2" class="accordion-collapse collapse" data-bs-parent="#expandirExplicacoes">
                            <div class="accordion-body">
                                <strong>?-placa-? /</strong> Use este valor para atribuir a Placa do Carro do
                                Cliente à mensagem
                                <br>
                                <strong>?-modelo-? /</strong> Use este valor para atribuir o Modelo do Carro do
                                Cliente à mensagem
                                <br>
                                <strong>?-vaga-? /</strong> Use este valor para atribuir a Vaga que o Carro do
                                Cliente ocupa à mensagem
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#variavel-3" aria-expanded="false" aria-controls="variavel-3">
                                Informações do Estacionamento
                            </button>
                        </h2>
                        <div id="variavel-3" class="accordion-collapse collapse" data-bs-parent="#expandirExplicacoes">
                            <div class="accordion-body">
                                <strong>?-endereco-? /</strong> Use este valor para atribuir o Endereço do
                                Estacionamento à mensagem
                                <br>
                                <strong>?-horario-? /</strong> Use este valor para atribuir o Horário de Fechamento
                                do Estacionamento à mensagem
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                    <a href="termos/politica-parking.html" target="_blank">Termos de Uso</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                    <a href="termos/politica-parking.html" target="_blank">Politicas de Privacidade</a>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </body>

</html>