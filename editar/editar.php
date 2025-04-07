<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Editar Brinquedo</title>
    <link rel="stylesheet" href="editar.css"/>
  </head>
  <body>
  <?php
    //Recebe os dados
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);
      if (isset($brinquedos[$id])) {
        $brinquedo = $brinquedos[$id];
        $nome = $brinquedo['nome'];
        $descricao = $brinquedo['descricao'];
        $comojogar = $brinquedo['comojogar'];
        $imgPrincipal = $brinquedo['img'][0];
        $img1 = $brinquedo['img'][1];
        $img2 = $brinquedo['img'][2];
        $pecas = $brinquedo['pecas'];
      }
    } else {
      echo "ID não encontrado!";
      exit;
    }
  ?>
  <div id="page">
    <div id="background-image">
      <img src="../img/background.jpg" alt="Imagem de brinquedos com o nome do site em destaque" />
    </div>
    <div id="content">
      <a href="../index/index.php" id="btn">Voltar</a>
      <h1>Editar Brinquedo</h1>
      <div id="formulario">
        <form action="../funcoes/editarbrinquedo.php" method="POST" enctype="multipart/form-data">
          <div class="line"> <!--Nome -->
            <div class="l"> 
              <label for="nome">Nome do Brinquedo:</label>
            </div>
            <div class="l">
              <input type="text" name="nome" value="<?php echo $nome; ?>" required="true" />
            </div>
          </div>
          <div class="line"> <!-- Descrição -->
            <div class="l">
              <label for="desc">Descrição:</label>
            </div>
            <div class="l">
              <input type="text" name="desc" value="<?php echo $descricao; ?>" required="true" />
            </div>
          </div>
          <div class="line"> <!-- Como jogar -->
            <div class="l">
              <label for="comojogar">Como jogar:</label>
            </div>
            <div class="l">
              <textarea name="comojogar" id="comojogar" required="true"><?php echo $comojogar; ?></textarea>
            </div>
          </div>
          <div class="line"> <!-- Imagem Principal -->
            <div class="l">
              <label for="imgprincipal">Selecionar Imagem Principal:</label>
            </div>
            <div class="l">
              <input type="file" name="imgprincipal" id="imgprincipal" accept="image/*" />
              <p><?php echo $imgPrincipal; ?></p>
            </div>
          </div>
          <div class="line"> <!-- Imagem 1 -->
            <div class="l">
              <label for="img1">Selecionar Imagem 1:</label>
            </div>
            <div class="l"> 
              <input type="file" name="img1" id="img1" accept="image/*" />
              <p><?php echo $img1; ?></p>
            </div>
          </div>
          <div class="line"> <!-- Imagem 2 -->
            <div class="l">
              <label for="img2">Selecionar Imagem 2:</label>
            </div>
            <div class="l">
              <input type="file" name="img2" id="img2" accept="image/*" />
              <p><?php echo $img2; ?></p>
            </div>
          </div>
          <div class="line"> <!-- Peças -->
            <div class="l">
              <label for="pecas[]">Peças:</label>
            </div>
            <div class="l" id="pecas-container">
              <?php foreach ($pecas as $peca): ?>
                <div class="peca">
                  <input type="text" name="pecas[]" value="<?php echo htmlspecialchars($peca); ?>" required />
                  <button type="button" onclick="removerPeca(this)" class="btnExcluir">Excluir peça</button>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="line"> <!-- Adicionar nova peça -->
            <button type="button" onclick="adicionarPeca()" id="addPeca">Adicionar nova peça</button>
          </div>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="submit" value="Salvar" class="btn" />
        </form>
      </div>
    </div>
  </div>
    <script>
      let erroMensagem;
      document.addEventListener("DOMContentLoaded", function () {
        //Cria a "Mensagem de Erro"
        const form = document.querySelector("form");
        const nomeInput = document.querySelector('input[name="nome"]');
        erroMensagem = document.createElement("p");
        erroMensagem.style.color = "red";
        erroMensagem.style.display = "none";
        form.appendChild(erroMensagem);

        //Função para verificar se o Brinquedo já existe
        function removerAcentos(texto) {
          return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }
        function verificarBrinquedoExistente(nome) {
          fetch("../brinquedos.json")
            .then((response) => response.json())
            .then((data) => {
              const nomeSemAcento = removerAcentos(nome).toLowerCase();
              let brinquedoExistente = false;

              for (let i in data) {
                const b = data[i];
                if (
                  removerAcentos(b.nome).toLowerCase() === nomeSemAcento &&
                  b.nome !== "<?php echo $nome; ?>"
                ) {
                  brinquedoExistente = true;
                  break;
                }
              }
              if (brinquedoExistente) {
                erroMensagem.textContent = "Já existe um brinquedo com esse nome!";
                erroMensagem.style.display = "block";
                form.querySelector('input[type="submit"]').disabled = true;
              } else {
                erroMensagem.textContent = "";
                erroMensagem.style.display = "none";
                form.querySelector('input[type="submit"]').disabled = false;
              }
            })
            .catch((error) => console.error("Erro ao carregar o json:", error));
        }
        nomeInput.addEventListener("input", function () {
          verificarBrinquedoExistente(nomeInput.value);
        });
      });

      //Função para adicionar nova peça
      function adicionarPeca() {
        const container = document.getElementById("pecas-container");
        const div = document.createElement("div");
        div.className = "peca";
        const input = document.createElement("input");
        input.type = "text";
        input.name = "pecas[]";
        input.required = true;
        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = "Excluir peça";
        btn.className = "btnExcluir";
        btn.onclick = function () {
          removerPeca(btn);
        };
        div.appendChild(input);
        div.appendChild(btn);
        container.appendChild(div);
      }

      //Função para remover peça
      function removerPeca(botao) {
        const container = document.getElementById("pecas-container");
        const totalPecas = container.querySelectorAll(".peca").length;
        if (totalPecas <= 1) {
          erroMensagem.textContent = "O brinquedo deve ter pelo menos uma peça.";
          erroMensagem.style.display = "block";
          return;
        }
        erroMensagem.textContent = "";
        erroMensagem.style.display = "none";
        botao.parentElement.remove();
      }
    </script>
  </body>
</html>
