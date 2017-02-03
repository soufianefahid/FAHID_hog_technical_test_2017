<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../include/html_header.php';?>
  <link rel="stylesheet" href="users.css" />
</head>
<body>

<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Users</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" id="create-btn" href="">Enregistrer</a>
      </nav>
    </div>
  </header>
  
  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <form action="#">
        <h4>Nouveau utilisateur</h4>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="login">
            <label class="mdl-textfield__label" for="login">Login</label>
          </div>
        </div>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="password" id="password">
            <label class="mdl-textfield__label" for="password">Mot de passe</label>
          </div>
        </div>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="email">
            <label class="mdl-textfield__label" for="email">Email</label>
          </div>
        </div>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="nom">
            <label class="mdl-textfield__label" for="nom">Nom</label>
          </div>
        </div>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="prenom">
            <label class="mdl-textfield__label" for="prenom">Prénom</label>
          </div>
        </div>
      </form>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {

    $("#create-btn").on("click", function() {
      var login = $("#login").val();
      var password = $("#password").val();
      var email = $("#email").val();
      var nom = $("#nom").val();
      var prenom = $("#prenom").val();

      $.ajax({
        url: 'http://localhost:8080/hog_technical_test_2017_api/users/create',
        data: {
          login : login,
          password : password,
          email :  email,
          nom : nom,
          prenom : prenom
        },
        success: function(data, status, jqXHR ) {
          console.log(status);
          console.log(data);
          
          window.location.href = $("#users-list").attr("href");
        },
        error: function(jqXHR, status, errorThrown ) {
          console.log("Error : ", status, "Reason : ", errorThrown);
        },
        method: 'GET'
      });

      return false;
    });
  });
</script>

</body> 
</html> 