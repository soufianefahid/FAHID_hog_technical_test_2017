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
      <span class="mdl-layout-title">Login</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" href="">Créer un compte</a>
      </nav>
    </div>
  </header>

  <main class="mdl-layout__content">
    <div class="page-content">
      <form action="#">
        <h4>Login</h4>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="login" pattern=".+">
            <label class="mdl-textfield__label" for="login">Login</label>
            <span class="mdl-textfield__error">Valeur incorrecte</span>
          </div>
        </div>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="password" id="password" pattern=".+">
            <label class="mdl-textfield__label" for="password">Mot de passe</label>
            <span class="mdl-textfield__error">Valeur incorrecte</span>
          </div>
        </div>
        <div>
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent btn-connect">
            Se connecter
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {

    $(".btn-connect").on("click", function() {
      var $login = $("#login");
      var $password = $("#password");
      var login = $login.val();
      var password = $password.val();

      console.log(login, password);

      if( !login ) {
        $login.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !password ) {
        $password.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !login || !password ) {
        return false;
      }
      
      return true;

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