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
      <span class="mdl-layout-title">Créer une conversation</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" id="save-conversation" href="">Enregistrer</a>
      </nav>
    </div>
  </header>

  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <form action="#">
        <h4>Nouvelle conversation</h4>
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="subject">
            <label class="mdl-textfield__label" for="subject">Sujet</label>
            <span class="mdl-textfield__error">Valeur incorrecte</span>
          </div>
        </div>
        <div>
          <ul class="users-list-control mdl-list">

          </ul>
        </div>
      </form>

      <div style="display: none;">
        <li class="mdl-list__item" id="empty-user">
          <span class="mdl-list__item-primary-content full_name">:full_name</span>
          <span class="mdl-list__item-secondary-action">
            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for=":id">
              <input type="checkbox" id=":id" class="mdl-switch__input"/>
            </label>
          </span>
        </li>
      </div>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {

    var users = [{id: 1, name: "Soufiane"}, {id: 2, name: "FAHID"}];

    var bindUsers = function() {

      var $emptyUser = $("#empty-user");
      var $list = $("ul.users-list-control")
      $list.html("");

      users.forEach( function(elmt, i, array) {
        var newLine = $emptyUser.clone();

        newLine.attr("id", "");
        newLine.find(".full_name").text(elmt.name);
        newLine.find("label").attr("for", elmt.id);
        newLine.find("input").attr("id", elmt.id);

        newLine.appendTo($list);
      } );

    };

    console.log(users);
    bindUsers();

    $.ajax({
      url: 'http://localhost:8080/hog_technical_test_2017_api/users/list',
      data: { token : accessToken },
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);
        
        users = data;
        bindUsers();
      },
      error: function(jqXHR, status, errorThrown ) {
        console.log("Error : ", status, "Reason : ", errorThrown);
      },
      method: 'GET'
    });

    $("#save-conversation").on("click", function() {
      var $subject = $("#subject");
      var $selectedUsers = $(".mdl-switch__input:checked");

      var subject = $subject.val();

      var withErrors = false;

      if( !subject ) {
        withErrors = true;
        $subject.closest(".mdl-textfield").addClass("is-invalid");
      }

      if( $selectedUsers.length == 0 ) {
        withErrors = true;
        alert("Aucun utilisateur sélectionné");
      }

      if( withErrors ) return false;

      var participants = [];
      $selectedUsers.each( function() {
        participants.push( $( this ).attr("id") );
      } );

      participants = participants.join(",");

      console.log(subject, participants, accessToken);

      $.ajax({
        url: 'http://localhost:8080/hog_technical_test_2017_api/conversations/create',
        data: {
          subject : subject,
          participants : participants,
          token : accessToken
        },
        success: function(data, status, jqXHR ) {
          console.log(status);
          console.log(data);
          
          window.location.href = "show.php?id="+data.id;
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