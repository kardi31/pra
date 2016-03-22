<?php
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = '/media/temp';   //2
$filename = $_POST['filename'];      
      
    $targetPath = '../../'. $storeFolder . $ds;  //4
    
    $file = $targetPath.$filename;
    unlink($file);
  
?>