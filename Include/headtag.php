
<?php

$cssPath='../css';
$imgPath='../js';

?>
<!doctype html>
<html lang="en">
  <head>
  <title>  <?php if (isset($name)) {echo $name;}else{echo "KfsDocs";}  ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- logo  -->
  <link rel="icon" type="image/png" href="<?php echo $imgPath.'/favicon.png'?>" />
 	<link rel="stylesheet" href="<?php echo $cssPath.'/all.min.css'?>">
	<link rel="stylesheet" href="<?php echo $cssPath.'/bootstrap.min.css'?>">
  <link rel="stylesheet" href="<?php echo $cssPath.'/dropzone.css'?>">
	<link rel="stylesheet" href="<?php echo $cssPath.'/style.css'?>">
  </head>












