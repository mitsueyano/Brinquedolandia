<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Brinquedo</title>
    <link rel="stylesheet" href="novobrinquedo.css">
</head>
<body>
<div id="page">
        <div id="background-image">
            <img src="../img/background.jpg" alt="Imagem de brinquedos com o nome do site em destaque">
        </div>
        <div id="content">
            <a href="../index/index.php" id="btn">Voltar</a>
           <h1>Novo Brinquedo</h1>
           <div id="formulario">
            <form action="../funcoes/addbrinquedo.php" method="POST" enctype="multipart/form-data"> <!-- enctype para o upload de arquivos (imagens) -->
                <div class="line">
                    <div class="l">
                        <label for="nome">Nome do Brinquedo:</label>
                    </div>
                    <div class="l">
                        <input type="text" name="nome" required="true">
                    </div> 
                </div>
                <div class="line">
                <div class="l">
                        <label for="desc">Descrição:</label>
                    </div>
                    <div class="l">
                        <input type="text" name="desc" required="true">
                    </div> 
                </div>
                <div class="line">
                <div class="l">
                        <label for="comojogar">Como jogar:</label>
                    </div>
                    <div class="l">
                        <textarea name="comojogar" id="comojogar" required="true"></textarea>
                    </div> 
                </div>
                <div class="line">
                    <div class="l">
                        <label for="imgprincipal">Selecionar Imagem Principal:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="imgprincipal" id="imgprincipal" accept="image/*" required>
                    </div>
                </div>
                <div class="line">
                    <div class="l">
                        <label for="img1">Selecionar Imagem 1:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="img1" id="img1" accept="image/*" required>
                    </div>
                </div>
                <div class="line">
                    <div class="l">
                        <label for="img2">Selecionar Imagem 2:</label>
                    </div>
                    <div class="l">
                        <input type="file" name="img2" id="img2" accept="image/*" required>
                    </div>
                </div>
                <input type="submit" value="Adicionar" class="btn">
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
                            if (removerAcentos(brinquedo.nome).toLowerCase() === nomeSemAcento) {
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
