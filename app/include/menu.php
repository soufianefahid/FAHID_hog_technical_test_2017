<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/hog_technical_test_2017';
?>

<div class="mdl-layout__drawer">
<span class="mdl-layout-title">Menu</span>
<nav class="mdl-navigation">
  <a class="mdl-navigation__link" id="create-conversation" href="<?php echo $root; ?>/app/conversations/create.php">Créer une conversation</a>
  <a class="mdl-navigation__link" id="list-conversations" href="<?php echo $root; ?>/app/conversations/list.php">Mes conversations</a>
  <a class="mdl-navigation__link" id="logout" href="">Se déconnecter</a>
</nav>
</div>

<script type="text/javascript">
  $( function() {
    $("#logout").click( function(e) {
      e.preventDefault();
      document.cookie = "hog_accessToken="+null+"; path=/";
      document.cookie = "hog_userID="+null+"; path=/";
      window.location.href = "../users/login.php";
    } );
  } );
</script>