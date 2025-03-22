<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Brinquedo</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>
    <?php
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            // Carrega os dados dos brinquedos
            $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);
            if (isset($brinquedos[$id])) {
                $brinquedo = $brinquedos[$id];
                $nome = $brinquedo['nome'];
                $descricao = $brinquedo['descricao'];
                $comojogar = $brinquedo['comojogar'];
                $imgPrincipal = $brinquedo['img'][0];
                $img1 = $brinquedo['img'][1];
                $img2 =$brinquedo['img'][2];
            }
        } else {
            echo "ID não encontrado!";
            exit;
        }
    ?>
<div id="page">
        <div id="background-image">
            <img src="../img/background.jpg" alt="Imagem de brinquedos com o nome do site em destaque">
        </div>
        <div id="content">
            <a href="../index/index.php" id="btn">Voltar</a>
           <h1>Editar Brinquedo</h1>
           <div id="formulario">
            <form action="../funcoes/editarbrinquedo.php" method="POST" enctype="multipart/form-data"> <!-- enctype para o upload de arquivos (imagens) -->
                <div class="line">
                    <div class="l">
                        <label for="nome">Nome do Brinquedo:</label>
                    </div>
                    <div class="l">
                        <input type="text" name="nome" value="<?php echo $nome; ?>" required="true" id="nome">
                    </div> 
                </div>
                <div class="line">
                    <div class="l">
                        <label for="desc">Descrição:</label>
                    </div>
                    <div class="l">
                        <input type="text" name="desc" value="<?php echo $descricao; ?>" required="true">
                    </div> 
                </div>
                <div class="line">
                    <div class="l">
                        <label for="comojogar">Como jogar:</label>
                    </div>
                    <div class="l">
                        <textarea name="comojogar" id="comojogar" required="true"><?php echo $comojogar; ?></textarea>
                    </div> 
                </div>
                <div class="line">
                    <div class="l">
                        <label for="imgprincipal">Imagem Principal:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="imgprincipal" id="imgprincipal" accept="image/*">
                        <p><?php echo $imgPrincipal; ?></p>
                    </div>
                </div>
                <div class="line">
                    <div class="l">
                        <label for="img1">Imagem 1:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="img1" id="img1" accept="image/*">
                        <p><?php echo $img1; ?></p>
                    </div>
                </div>
                <div class="line">
                    <div class="l">
                        <label for="img2">Imagem 2:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="img2" id="img2" accept="image/*">
                        <p><?php echo $img2; ?></p>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" value="Salvar" class="btn" id="submitBtn">
            </form>
           </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');
            const nomeInput = document.querySelector('input[name="nome"]');
            const erroMensagem = document.createElement('p');
            erroMensagem.style.color = 'red';
            erroMensagem.style.display = 'none';
            form.appendChild(erroMensagem);

            //Função para remover acentos (ex: Cubo Mágico = Cubo Magico)
            function removerAcentos(texto) {
                return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            }

            //Função para carregar o json e verificar se o brinquedo já existe
            function verificarBrinquedoExistente(nome) {
                fetch('../brinquedos.json')
                    .then(response => response.json())
                    .then(data => {
                        const nomeSemAcento = removerAcentos(nome).toLowerCase();

                        let brinquedoExistente = false;
                        data.forEach(brinquedo => { //Passa por todos os brinquedos e verifica
                            if (removerAcentos(brinquedo.nome).toLowerCase() === nomeSemAcento && brinquedo.nome !== "<?php echo $nome; ?>") {
                                brinquedoExistente = true;
                            }
                        });

                        if (brinquedoExistente) {
                            erroMensagem.textContent = 'Já existe um brinquedo com esse nome!';
                            erroMensagem.style.display = 'block';
                            form.querySelector('input[type="submit"]').disabled = true;
                        } else {
                            erroMensagem.textContent = '';
                            erroMensagem.style.display = 'none';
                            form.querySelector('input[type="submit"]').disabled = false;
                        }
                    })
                    .catch(error => console.error('Erro ao carregar o json:', error));
            }

            //Event listener para verificar o nome assim que o usuário digitar
            nomeInput.addEventListener('input', function() {
                verificarBrinquedoExistente(nomeInput.value);
            });
        });
    </script>
</body>
</html>
