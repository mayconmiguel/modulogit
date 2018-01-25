<?php

$upload_dir = "../uploads/arquivos/";
@mkdir($upload_dir);
if ($_FILES["file-0"]["error"] > 0) {
    echo false;
}
else
{
    $arquivo_tmp = $_FILES['file-0']['tmp_name'];
    $nome1 = "arquivo.txt";

    // Pega a extensao
    $extensao = strrchr($nome1, '.');

    // Converte a extensao para mimusculo
    $extensao = strtolower($extensao);
    $novoNome = md5(microtime()) . $extensao;

    move_uploaded_file($arquivo_tmp, $upload_dir .'/'. $nome1);
    echo true;
};


?>



