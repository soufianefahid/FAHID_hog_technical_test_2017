<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/hog_technical_test_2017';
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

  <script type="text/javascript">
    window.location.href = "<?php echo $root; ?>/app/conversations/list.php";
  </script>

</body> 
</html> 