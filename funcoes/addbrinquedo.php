<?php

//Função para gerar o nome do arquivo (.png) baseado no nome do brinquedo
function salvarImagem($imagem, $nomeBrinquedo, $indice) {
    $diretorio = '../img/';
    
    //Cria o nome da imagem com base no nome do brinquedo e o índice
    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION); //Identifica a extensão (.algumacoisa) do arquivo original
    $novoNome = $nomeBrinquedo . $indice . '.' . $extensao;
    
    $caminho = $diretorio . $novoNome; //("../img/nome.png")
    
    //Move a imagem para o diretório
    if (move_uploaded_file($imagem['tmp_name'], $caminho)) {
        return $novoNome;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['desc'];
    $comojogar = $_POST['comojogar'];
    $pecas = isset($_POST['pecas']) ? $_POST['pecas'] : [];

    //Salva as imagens com os nomes renomeados
    $imgprincipal = salvarImagem($_FILES['imgprincipal'], $nome, '');
    $img1 = salvarImagem($_FILES['img1'], $nome, 1);
    $img2 = salvarImagem($_FILES['img2'], $nome, 2);

    if (!$imgprincipal || !$img1 || !$img2) {
        echo "Erro ao salvar as imagens.";
        exit;
    }

    //Carrega os brinquedos existentes do arquivo json
    $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);

    //Adiciona o novo brinquedo no array
    $novoBrinquedo = [
        'endereco' => strtolower(str_replace(' ', '', $nome)),
        'nome' => $nome,
        'descricao' => $descricao,
        'comojogar' => $comojogar,
        'img' => [$imgprincipal, $img1, $img2],
        'pecas' => $pecas 
    ];
    $brinquedos[] = $novoBrinquedo;

    //Salva o array atualizado de volta no arquivo json
    file_put_contents('../brinquedos.json', json_encode($brinquedos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header('Location: ../index/index.php');
}

?>
