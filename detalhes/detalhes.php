
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Brinquedo</title>
    <link rel="stylesheet" href="detalhes.css">
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id'])) {

                //Carrega os brinquedos existentes do arquivo json de acordo com o ID
                $id = $_POST['id'];

                $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);
                $brinquedo = $brinquedos[$id];
                $nome = $brinquedo['nome'];
                $descricao = $brinquedo['descricao'];
                $imagem = "../img/" . $brinquedo['img'][0];
                $comojogar = $brinquedo['comojogar'];

            } else {
                echo "ID não recebido.";
                exit;
            }
        }
    ?>
    <div id="page">
        <div id="background-image">
            <img src="../img/background.jpg" alt="Imagem de brinquedos com o nome do site em destaque">
        </div>
        <div id="content">
            <a href="../index/index.php" id="btn">Voltar</a>
            <h1><?php echo $nome; ?></h1>
            <div class="box">
                <img src="<?php echo $imagem; ?>" alt="Imagem do brinquedo <?php echo $nome; ?>">
            </div>
            <div id="desc">
                <p><?php echo $descricao; ?></p>
                <h2>Como jogar</h2>
                <p  id="espaco"><?php echo $comojogar;?></p>
                <h2>Imagens</h2>
                <div class="imagens">
                    <?php
                        for($i = 1; $i < sizeof($brinquedo['img']); $i++){
                    ?>
                        <img src="../img/<?php echo $brinquedo['img'][$i];?>" alt="imagem do brinquedo <?php echo ' ' . $nome;?>">
                    <?php
                        }
                    ?>
                </div>
            </div>
            <form action="../editar/editar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Editar Brinquedo" name="editar" class="btn">
            </form>
            <form action="../funcoes/excluirbrinquedo.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Excluir Brinquedo" name="excluir" id="btnExcluir">
            </form>

        </div>
    </div>
</body>
</html>
