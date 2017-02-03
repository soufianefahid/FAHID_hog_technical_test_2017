<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../include/html_header.php';?>
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
        <a class="mdl-navigation__link" href="create.php">Créer un utilisateurs</a>
      </nav>
    </div>
  </header>
  
  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--non-numeric">Login</th>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prénom</th>
            <th class="mdl-data-table__cell--non-numeric">Email</th>
            <th class="mdl-data-table__cell--non-numeric">Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

      <div style="display: none;">
        <div id="empty-line">
          <table><tbody>
          <tr id=":id">
            <td class="mdl-data-table__cell--non-numeric login">:login</td>
            <td class="mdl-data-table__cell--non-numeric nom">:nom</td>
            <td class="mdl-data-table__cell--non-numeric prenom">:prenom</td>
            <td class="mdl-data-table__cell--non-numeric email">:email</td>
            <td class="mdl-data-table__cell--non-numeric">
              <button data-id=":id" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent remove">Supprimer</button>
            </td>
          </tr>
          </tbody></table>
        </div>
      </div>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {
    $.ajax({
      url: 'http://localhost:8080/hog_technical_test_2017_api/users/list',
      data: {},
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);
        
        var users = data;

        var emptyLine = $("#empty-line tr");
        var $tbody = $("tbody");
        users.forEach( function(elmt, i, array) {
          var $newElmt = emptyLine.clone();

          $newElmt.attr("id", "user-"+elmt.id);
          $newElmt.find(".login").html(elmt.login);
          $newElmt.find(".nom").html(elmt.nom);
          $newElmt.find(".prenom").html(elmt.prenom);
          $newElmt.find(".email").html(elmt.email);
          $newElmt.find(".remove").attr("data-id", elmt.id);

          $newElmt.find(".remove").on("click", function(e) {
            var $elmt = $(this).closest("tr");
            var id = $elmt.attr("id").split("-")[1];
            $elmt.remove();
            $.ajax({
              url: 'http://localhost:8080/hog_technical_test_2017_api/users/delete',
              data: {
                id : id
              },
              success: function(data, status, jqXHR ) {
                console.log(status);
                console.log(data);
              },
              error: function(jqXHR, status, errorThrown ) {
                console.log("Error : ", status, "Reason : ", errorThrown);
              },
              method: 'GET'
            });
          })

          $newElmt.appendTo($tbody);
        } );
      },
      error: function(jqXHR, status, errorThrown ) {
        console.log("Error : ", status, "Reason : ", errorThrown);
      },
      method: 'GET'
    });
  });
</script>

</body> 
</html> 