<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/hog_technical_test_2017';
?>

<div class="mdl-layout__drawer">
<span class="mdl-layout-title">Menu</span>
<nav class="mdl-navigation">
  <a class="mdl-navigation__link" id="users-list" href="<?php echo $root; ?>/app/users/list.php">Users</a>
</nav>
</div>