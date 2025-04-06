<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div id="page">
        <div id="background-image">
            <img src="../img/background.jpg" alt="Imagem de brinquedos com o nome do site em destaque">
        </div>
        <div id="content">
            <form action="../novobrinquedo/novobrinquedo.php" method="POST">
                <input type="submit" value="Novo Brinquedo" id="btn">
            </form>
            <?php
                $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);
                $id = 0;
                foreach ($brinquedos as $brinquedo) {
                    $endereco = $brinquedo['endereco'];
                    $nome = $brinquedo['nome'];
                    $descricao = $brinquedo['descricao'];
                    $imagem = "../img/" . $brinquedo['img'][0];
            ?>

                    <div class="box">
                        <img src="<?php echo $imagem; ?>" alt="imagem do brinquedo <?php echo $nome; ?>">
                        <div class="desc">
                            <h1><?php echo $nome; ?></h1>
                            <p><?php echo $descricao; ?></p>
                        </div>
                        <form action="../detalhes/detalhes.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" value="Saiba mais" class="btn">
                        </form>

                    </div>

            <?php
                    $id++;
                }
            ?>
                <a href="integrantes.php">Integrantes</a>           
        </div>
    </div>
</body>
</html>
