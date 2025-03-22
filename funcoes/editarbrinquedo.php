<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $brinquedos = json_decode(file_get_contents('../brinquedos.json'), true);

        if (isset($brinquedos[$id])) {
            $brinquedo = $brinquedos[$id];

            //Atualiza os dados do brinquedo com os valores editados (UTF-8 para não prejudicar o json)
            $nome = mb_convert_encoding($_POST['nome'], 'UTF-8', 'UTF-8');
            $descricao = mb_convert_encoding($_POST['desc'], 'UTF-8', 'UTF-8');
            $comojogar = mb_convert_encoding($_POST['comojogar'], 'UTF-8', 'UTF-8');

            //Verifica se as imagens foram alteradas
            $imgPrincipal = $brinquedo['img'][0];
            $img1 = isset($brinquedo['img'][1]) ? $brinquedo['img'][1] : '';
            $img2 = isset($brinquedo['img'][2]) ? $brinquedo['img'][2] : '';

            //Faz o upload de novas imagens
            if (isset($_FILES['imgprincipal']) && $_FILES['imgprincipal']['error'] == 0) {
                $imgPrincipal = $_FILES['imgprincipal']['name'];
                move_uploaded_file($_FILES['imgprincipal']['tmp_name'], '../img/' . $imgPrincipal);
            }
            if (isset($_FILES['img1']) && $_FILES['img1']['error'] == 0) {
                $img1 = $_FILES['img1']['name'];
                move_uploaded_file($_FILES['img1']['tmp_name'], '../img/' . $img1);
            }
            if (isset($_FILES['img2']) && $_FILES['img2']['error'] == 0) {
                $img2 = $_FILES['img2']['name'];
                move_uploaded_file($_FILES['img2']['tmp_name'], '../img/' . $img2);
            }

            //Atualiza o brinquedo
            $brinquedo['nome'] = $nome;
            $brinquedo['descricao'] = $descricao;
            $brinquedo['comojogar'] = $comojogar;
            $brinquedo['img'] = [$imgPrincipal, $img1, $img2];

            $brinquedos[$id] = $brinquedo;

            //Salva o array de brinquedos atualizado
            file_put_contents('../brinquedos.json', json_encode($brinquedos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); //Codificação em UTF-8 e sem "escapar caracteres especiais" para não prejudicar o json

            header('Location: ../index/index.php');
            exit;
        } else {
            echo "Brinquedo não encontrado!";
        }
    } else {
        echo "ID do brinquedo não recebido!";
    }
}
?>
