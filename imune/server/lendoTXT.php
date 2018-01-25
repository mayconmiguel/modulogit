<?php


$arquivo = fopen("../uploads/arquivos/arquivo.txt","r");
$linha = "";
while(!feof($arquivo)){
    $linha .= substr(fgets($arquivo),0,11)."-";
}

fclose($arquivo);
echo substr($linha,0,strlen($linha)-1);
?>