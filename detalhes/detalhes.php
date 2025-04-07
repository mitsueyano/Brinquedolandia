<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Brinquedo</title>
    <link rel="stylesheet" href="detalhes.css">
</head>
<body>
    <?php
        //Recebe os dados
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id'])) {
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
            <!-- Descrição -->
            <div id="desc">
                <p><?php echo $descricao; ?></p>
            <!-- Como Jogar -->
                <h2>Como jogar</h2>
                <p id="espaco"><?php echo $comojogar;?></p>
            <!-- Imagens -->    
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
            <!-- Peças -->
                <?php if (isset($brinquedo['pecas']) && is_array($brinquedo['pecas']) && count($brinquedo['pecas']) > 0): ?>
                    <h2>Peças</h2>
                    <ul>
                        <?php foreach ($brinquedo['pecas'] as $peca): ?>
                            <li><?php echo htmlspecialchars($peca); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- Botão "Editar" -->
            <form action="../editar/editar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Editar Brinquedo" name="editar" class="btn">
            </form>
            <!-- Botão "Excluir" e Modal de confirmação -->
            <button id="btnExcluir" class="btn">Excluir Brinquedo</button>
            <div id="modalConfirmacao">
                <div class="modalconteudo">
                    <p>Deseja mesmo <strong>EXCLUIR</strong> esse brinquedo?</p>
                    <form id="formExcluir" action="../funcoes/excluirbrinquedo.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" name="excluir" id="excluir">Sim, excluir</button>
                        <button type="button" id="cancelar" onclick="fecharModal()">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const btnExcluir = document.getElementById('btnExcluir');
        const modal = document.getElementById('modalConfirmacao');
        btnExcluir.addEventListener('click', () => {
            modal.style.display = 'block';
        });
        function fecharModal() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
