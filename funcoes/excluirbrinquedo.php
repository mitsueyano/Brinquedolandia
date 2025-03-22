<?php
if (isset($_POST['id'])) {
    $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);
    $id = $_POST['id'];

    if (isset($brinquedos[$id])) {
        $brinquedo = $brinquedos[$id];
        $imagemPrincipal = "../img/" . $brinquedo['img'][0];

        //Exclui as imagens do diretório
        foreach ($brinquedo['img'] as $imagem) {
            $caminhoImagem = "../img/" . $imagem;
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        //Exclui o brinquedo do array
        unset($brinquedos[$id]);

        //Reindexa o array para evitar "buracos" nos índices (id)
        $brinquedos = array_values($brinquedos);

        //Salva o array atualizado de volta no arquivo json
        file_put_contents('../brinquedos.json', json_encode($brinquedos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        header('Location: ../index/index.php');
        exit();
    } else {
        echo "Brinquedo não encontrado!";
    }
} else {
    echo "ID não recebido.";
}
?>
