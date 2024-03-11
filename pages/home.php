<?php require "header.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Home | Estac</title>
  </head>

  <body>
    <div class="content_main">

      <div id="container_infos_vagas">
        <div id="container_total" style="margin-right:10px">
          <div class="title">
            <vg style="color: green;">Vagas Carro | Vaga Moto</vg>
          </div>
          <div class="value">
            <!-- ^^ GAMBIARRA TEMPORARIA HEHEHE  -->
            <h1 id="total_vagas_carro"><?php echo $_SESSION['user']['total_vagas_carro']; ?></h1>
            <h1 id="total_vagas_moto"><?php echo $_SESSION['user']['total_vagas_moto']; ?></h1>
            <!-- ^^ GAMBIARRA TEMPORARIA HEHEHE  -->
          </div>
        </div>
        <div id="container_ocupada">
          <div class="title">
            <vg href="" style="color: red; text-decoration: none;">Ocupadas Carro | Ocupadas Moto</vg>
          </div>
          <div class="value container_ocupada">
            <!-- ^^ GAMBIARRA TEMPORARIA HEHEHE  -->
            <h1 id="vagas_ocupadas_carro"></h1>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <h1 id="vagas_ocupadas_moto"></h1>
            <!-- ^^ GAMBIARRA TEMPORARIA HEHEHE  -->
          </div>
        </div>
      </div>
      <div id="car-table">
        <div class="container_btn_entrada_vaga">
          <h5>Vagas Ocupadas</h5>
          <button class="btn btn-success" id="btn_estacionar" data-bs-toggle="modal"
            data-bs-target="#Estacionar">Estacionar</button>
        </div>
        <table id="tabelaCarros" class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Categoria</th>
              <th scope="col">Vaga</th>
              <th scope="col">Placa</th>
              <th scope="col">Modelo</th>
              <th style=" width: 20%;" scope="col">Entrada</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody id="tbody">
          </tbody>
        </table>
      </div>
      <div class="modal fade" id="Estacionar" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Adicionar carro no estacionamento</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="form">
                <div class="field">
                  <label>Categoria</label>
                  <select class="form-select" name='c00_categoria'>
                    <option selected value="Selecionar">--Selecionar--</option>
                    <option value="carro">Carro</option>
                    <option value="moto">Moto</option>
                  </select>
                </div>
                <div class="field">
                  <label>Placa</label>
                  <input name="c00_placa" type="text" placeholder="123ABC...">
                </div>
                <div class="field">
                  <label>Modelo</label>
                  <input name="c00_modelo" type="text" placeholder="Ford KA...">
                </div>
                <div class="field">
                  <label>Vaga</label>
                  <input name="c00_vaga" type="text" placeholder="1,2,3...">
                </div>
                <div class="field">
                  <label>Entrada</label>
                  <input name="c00_entrada" type="text" disabled>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-success" onclick="estacionar()">Estacionar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="Saida" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true"
        data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Realizar saída do carro de placa - <span
                  id="placa-titulo-saida"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="titulo-saida">
                <h6>Deseja dar saída neste carro?</h6>
              </div>
              <p>Este carro ficou das <b id="entrada-modal"></b> às <b id="saida-modal"></b></p>
              <p>Para dar saída, cobre dele <b id="total-modal"></b></p>
              <div id="checkmark"><input type="checkbox" id="box"><label>Pagamento Recebido</label></div>
              <p style="font-size:0.8rem ;">Uma vez marcada a opção acima, não será possível reverter</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" id="btn-saida" data-bs-dismiss="modal" disabled
                onclick="saidaCarro()">Dar Saída</button>
            </div>
          </div>
        </div>

      </div>

      <div class="modal fade" id="Mover" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true"
        data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Mover <span id='categoria-titulo-mover'></span> de vaga - <span
                  id="placa-titulo-mover"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="titulo-saida">
                <h6>Deseja mover de vaga?</h6>
              </div>
              <div class="form">
                <div class="field">
                  <label>Vaga atual</label>
                  <input name="vaga_atual" type="number" value="" disabled>
                </div>
                <div class="field">
                  <label>Vaga direcionada</label>
                  <input name="vaga_direcionada" type="number">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btn-mover-carro" data-bs-dismiss="modal"
                onclick="moverCarro()">Mover</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </body>
  </div>
  </div>
  <script>
    $(document).ready(function () {
      $('#sidebar_active').on('click', function () {
        $('.sidebar').toggleClass('active');
      });
    });
  </script>
  <script src="../js/jquery-3.7.1.min.js"></script>
  <script src="../js/javascript.js"></script>
  </body>

</html>