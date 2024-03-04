<!DOCTYPE html>
<html lang="en">
    <?php require_once ("conectDB.php");?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estac.css">
    <title>Tentando a imagem</title>
</head>
<body>
    <main>
        <div id="estacionamento">
           <?php 
           $sql = "SELECT `total_vagas_estac` FROM usuarios WHERE `id_estac`= 1";
           $stmt = $conn->prepare($sql);
           if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                foreach ($row as $r) {
                    for ($a=1; $a <=  $r; $a++){
                        echo "<div class='vaga'>";
                        $sql2 = "SELECT * FROM registros WHERE `id_estacionamento`= 1 AND `status_pago_carro` = 0 AND `vaga_carro` = $a";
                        $stmt2 = $conn->prepare($sql2);
                        if($stmt2->execute()){
                            $result2 = $stmt2->get_result();
                            while ($row2 = $result2->fetch_array(MYSQLI_NUM)){
                                    echo "<img class='carro' src='carro.jpg'>";
                            }
                        }
                        echo "</div>";
                    }
                }
            }
           }
           ?>
        </div>
    </main>
    <div id="detalhes">
        <p>Placa</p>
        <p>Entrada</p>
    </div>
</body>
<script src="estac.js"></script>
</html>