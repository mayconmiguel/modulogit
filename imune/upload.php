<?php
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4

    $targetFile =  $targetPath.date('Ymdhis').$_FILES['file']['name'];  //

    move_uploaded_file($tempFile,$targetFile); //6
    echo date('Ymdhis').$_FILES['file']['name'];
}
?>
