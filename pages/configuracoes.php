<?php
require "header.php";
require "../func/Function_clientes.php";


$cliente = listar_usuarios($conn, $_SESSION['user']["id"]);


$tipos_vaga = isset($_REQUEST['tipos_vaga']) ? $_REQUEST['tipos_vaga'] : 0;
$tipo_pagamento = isset($_REQUEST['tipo_pagamento']) ? $_REQUEST['tipo_pagamento'] : 0;
$tipos_vaga = isset($_REQUEST['tipos_vaga']) ? $_REQUEST['tipos_vaga'] : 0;
$tipos_vaga = isset($_REQUEST['tipos_vaga']) ? $_REQUEST['tipos_vaga'] : 0;
$tipos_vaga = isset($_REQUEST['tipos_vaga']) ? $_REQUEST['tipos_vaga'] : 0;
?>
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
                    <label for="input_razao" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="input_razao"
                        value='<?php echo $cliente[0]['nome_estac']; ?>' disabled>
                </div>
                <div class="col-md-6">
                    <label for="input_cnpj" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="input_cnpj"
                        value='<?php echo $cliente[0]['endereco_estac']; ?>' disabled>
                </div>
                <div class="col-md-6">
                    <label for="input_endereco" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="input_endereco"
                        value="<?php echo $cliente[0]['cnpj_estac']; ?>" disabled>
                </div>
                <div class="col-md-3">
                    <label for="inputTotal" class="form-label">Numero de
                        contato</label>
                    <input type="email" class="form-control" id="inputTotal" disabled
                        value='<?php echo $cliente[0]['numero_contato_estac']; ?>'>
                </div>
                <div class="col-md-3">
                    <label for="inputTotal" class="form-label">Email de
                        contato</label>
                    <input type="email" class="form-control" id="inputTotal" disabled
                        value='<?php echo $cliente[0]['email_estac']; ?>'>
                </div>
                <hr>
                <h5>Informações Vagas</h5>
                <div class="col-md-3 tipo_vaga_carro">
                    <label for="inputTotal" class="form-label">Tipos de vagas</label>
                    <select name="tipos_vaga" id="tipos_vaga">
                        <option value="0">Apenas Carro</option>
                        <option value="1">Apenas Moto</option>
                        <option value="2">Carro e Moto</option>
                    </select>
                </div>
                <div class="col-md-3 tipo_vaga_carro">
                    <label for="inputTotal" class="form-label">Total de vagas para carros</label>
                    <input type="number" class="form-control" id="inputTotal"
                    value="<?php echo $cliente[0]['total_vagas_carro_estac']; ?>"
                    >
                </div>
                <div class="col-md-3 tipo_vaga_moto">
                    <label for="inputTotal" class="form-label">Total de vagas para motos</label>
                    <input type="number" class="form-control" id="inputTotal"
                    value="<?php echo $cliente[0]['total_vagas_moto_estac']; ?>"
                    >
                </div>

                <hr>
                <h5 style="padding:0; margin:0;">Informações de Cobrança</h5>
                <div class="col-md-8">
                    <label for="inputState" class="form-label">Tipo de cobrança</label>
                    <select id="inputState" name="tipo_pagamento" class="form-select">
                        <option selected>Por hora</option>
                        <option>Por Dia</option>
                        <option>Por Mensal</option>
                        <option>Taxa Única</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="inputCity" class="form-label">Preço/hr</label>
                    <input type="number" class="form-control" name="valor_pagamento" id="inputCity">
                </div>
                <hr>
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