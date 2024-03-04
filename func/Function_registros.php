<?php
require_once("conectDB.php");
session_start();


if (isset($_POST["function"])) {
    switch ($_POST['function']) { //SWITCH CASE PRA FAZER A VERIFICACAO DE QUAL FUNCAO VAI USAR, DEPOIS QUE USAR DA UM BREAK NO DOCUMENTO PRA NAO LER MAIS CODIGOS
        case 'listarRegistros':
            echo json_encode(listarRegistros($conn));
            break;
        case 'estacionarRegistro':
            echo json_encode(estacionarRegistro($conn, $_POST['info']));
            break;
        case 'saidaRegistro':
            echo json_encode(saidaRegistro($conn, $_POST['info']));
            break;
        case 'moverRegistro':
            echo json_encode(moverRegistro($conn, $_POST['info']));
            break;
        case 'selectRegistro':
            echo json_encode(selectRegistro($conn, $_POST['info']));
            break;
        case 'calcularPrecoSaida':
            echo json_encode(calcularPrecoSaida($conn, $_POST['info']));
            break;
    }
} else {
    echo "não passou";
}

function estacionarRegistro($conn, $infos)
{
    $id = $_SESSION['user']['id'];
    $total = $_SESSION['user']['total-vagas'];
    if ($infos[2] > $total) {
        return '199';
    } else if ($infos[2] <= 0) {
        return '200';
    } else {
        $sql = "SELECT * FROM registros WHERE `status_pago_carro`= 0 AND `id_estacionamento`= $id AND `placa_carro`= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $infos[0]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                return '201'; // O CARRO COM A MESMA PLACA ESTA ESTACIONADO ATUALMENTE
            } else {
                $sql = "SELECT * FROM registros WHERE `status_pago_carro`= 0 AND `id_estacionamento`= $id AND `vaga_carro`= ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $infos[2]);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows > 0) {
                        return '202'; // EXISTE UM CARRO NESTA VAGA
                    } else {
                        $query = "SELECT COUNT(*) as total FROM registros WHERE `id_estacionamento` = ? AND `status_pago_carro` = 0";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $id);

                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $count = $row['total'];

                            if ($count + 1 > $total) {
                                $stmt->close();
                                return '203'; // CHEGOU AO LIMITE DE CARROS ESTACIONADOS
                            } else {
                                $stmt->close();

                                $query = "INSERT INTO registros (`placa_carro`, `modelo_carro`, `vaga_carro`, `entrada_carro`, `status_pago_carro`,`id_estacionamento`) VALUES (?, ?, ?, ?, '0',$id)";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ssii", $infos[0], $infos[1], $infos[2], $infos[3]);

                                if ($stmt->execute()) {
                                    $stmt->close();
                                    $conn->close();
                                    return 1; // Sucesso inserir
                                } else {
                                    $stmt->close();
                                    $conn->close();
                                    return 0; // Falha na inserção no banco
                                }
                            }
                        } else {
                            $stmt->close();
                            return 0; // Falha na consulta
                        }
                    }
                } else {
                    $stmt->close();
                    return 0; // Falha na consulta
                }
            }
        }
    }
}

function listarRegistros($conn)
{
    $id = $_SESSION['user']['id'];
    $sql = "SELECT * FROM registros WHERE `status_pago_carro`= 0 AND `id_estacionamento` = ?";
    echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();

        $output = array(); // Inicializa $output

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = array(
                    'placa_carro' => $row['placa_carro'],
                    'modelo_carro' => $row['modelo_carro'],
                    'vaga_carro' => $row['vaga_carro'],
                    'entrada_carro' => $row['entrada_carro'],
                    'saida_carro' => $row['saida_carro']
                );
            }
            return $output;
        } else {
            return array(); // Retorna um array vazio se não houver resultados
        }
    } else {
        return false; // Retorna false se a consulta falhar
    }
}


function selectRegistro($conn, $placa)
{
    $id = $_SESSION['user']['id'];
    $sql = "SELECT * FROM registros WHERE `placa_carro` = '$placa' AND `status_pago_carro`= 0 AND `id_estacionamento`= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            foreach ($result as $row) {
                $output[] = array(
                    null,
                    $row['placa_carro'],
                    $row['modelo_carro'],
                    $row['vaga_carro'],
                    $row['entrada_carro']
                );
            }
            return($output);
        } else {
            return 0;
        }
    }
}

function calcularPrecoSaida($conn, $switch)
{
    $id = $_SESSION['user']['id'];
    if ($switch == "taxaFixa") {
        $sql = "SELECT preco_fixo FROM config_estacionamento WHERE `id_estacionamento` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output = $row['preco_fixo'];
                }
                return $output;
            } else {
                return 0;
            }
        }
    } else {
        $sql = "SELECT preco_hora FROM config_estacionamento WHERE `id_estacionamento` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $output = $row['preco_hora'];
                }
                return $output;
            } else {
                return 0;
            }
        }
    }
}

function saidaRegistro($conn, $placa)
{
    $id = $_SESSION['user']['id'];
    $sql = "DELETE FROM registros WHERE `placa_carro` = ? AND  `id_estacionamento` = ? AND `status_pago_carro`= 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $placa, $id);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return 1;
    } else {
        $stmt->close();
        $conn->close();
        return 0;
    }
}

function moverRegistro($conn, $infos)
{
    $id = $_SESSION['user']['id'];
    $total = $_SESSION['user']['total-vagas'];
    if ($infos[0] > $total) {
        return '199';
    } else if ($infos[0] <= 0) {
        return '200';
    } else {
        $sql = "SELECT * FROM registros WHERE `id_estacionamento` = ? AND  `vaga_carro` = ? AND `status_pago_carro` = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $infos[0]);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                return '201';
            } else {
                $sql = "UPDATE `registros` SET `vaga_carro`=? WHERE `placa_carro` = ? AND  `id_estacionamento` = ? AND `status_pago_carro`= 0";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isi", $infos[0], $infos[1], $id);
                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();
                    return 1;
                } else {
                    $stmt->close();
                    $conn->close();
                    return '0';
                }
            }
        }
    }
}

function listar_registros($conn, $id_estacionamento)
{
    $query = "SELECT * FROM registros WHERE id_estacionamento = ?";

    // Preparar a consulta
    $stmt = $conn->prepare($query);

    // Verificar se a preparação da consulta falhou
    if (!$stmt) {
        // Retornar uma mensagem de erro
        return "Erro ao preparar a consulta: " . $conn->error;
    }

    // Bind o parâmetro id_estacionamento ao statement
    $stmt->bind_param("i", $id_estacionamento);

    // Executar a consulta
    if (!$stmt->execute()) {
        // Retornar uma mensagem de erro
        return "Erro ao executar a consulta: " . $stmt->error;
    }

    // Obter o resultado da consulta
    $result = $stmt->get_result();

    // Verificar se há algum resultado
    if ($result->num_rows === 0) {
        // Se não houver resultados, retornar uma mensagem indicando isso
        return "Nenhum carro encontrado para o estacionamento com o ID " . $id_estacionamento;
    }

    // Criar um array para armazenar os dados
    $dados = array();

    // Loop através dos resultados e adicionar cada linha ao array de dados
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    // Retornar os dados
    return $dados;
}

