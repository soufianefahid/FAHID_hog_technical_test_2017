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
      <span class="mdl-layout-title">Sign up</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" href="">Login</a>
      </nav>
    </div>
  </header>

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
            <input class="mdl-textfield__input" type="password" id="confirm_password">
            <label class="mdl-textfield__label" for="confirm_password">Confirmer le mot de passe</label>
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
        <div>
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent btn-connect">
            Créer
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {

    $("#create-btn").on("click", function() {
      var $login = $("#login");
      var $password = $("#password");
      var $confirm_password = $("#confirm_password");
      var $email = $("#email");
      var $nom = $("#nom");
      var $prenom = $("#prenom");

      var login = $login.val();
      var password = $password.val();
      var confirm_password = $confirm_password.val();
      var email = $email.val();
      var nom = $nom.val();
      var prenom = $prenom.val();

      var withErrors = false;

      if( !login ) {
        withErrors = true;
        $login.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !password ) {
        withErrors = true;
        $password.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !confirm_password || confirm_password !== password ) {
        withErrors = true;
        $confirm_password.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !email ) {
        withErrors = true;
        $email.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !nom ) {
        withErrors = true;
        $nom.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( !prenom ) {
        withErrors = true;
        $prenom.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( withErrors ) return false;

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