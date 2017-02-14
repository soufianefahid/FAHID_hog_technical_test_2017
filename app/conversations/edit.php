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
      <span class="mdl-layout-title">Modifier une conversation</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" id="show-conversation" href="">Voir la conversation</a>
      </nav>
    </div>
  </header>

  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <form action="#">
        <div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input readonly class="mdl-textfield__input" type="text" id="subject">
            <label class="mdl-textfield__label" for="subject">Sujet</label>
          </div>
        </div>
        <h4>Listes des participants</h4>
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
              <input type="checkbox" id=":id" data-user=":user" data-participation=":participation" class="mdl-switch__input"/>
            </label>
          </span>
        </li>
      </div>
    </div>
  </main>
</div>

<script type="text/javascript">
  $(function() {

    var params = getQueryString();
    var conversationID = params.id;
    var conversation = null;
    var allUsers = [];

    if( !conversationID ) {
      console.log("conversationID not set");
      window.location.href = "list.php";
    }

    $("#show-conversation").click( function(e) {
      e.preventDefault();
      window.location.href = "show.php?id="+getQueryString().id;
    } );

    // Get conversation
    $.ajax({
      url: 'http://localhost:8080/hog_technical_test_2017_api/conversations/show',
      data: {
        id : conversationID,
        token : accessToken
      },
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);
        
        conversation = data;
        bindConversation();
      },
      error: function(jqXHR, status, errorThrown ) {
        console.log("Error : ", status, "Reason : ", errorThrown);
      },
      method: 'GET'
    });

    // Get all users
    $.ajax({
      url: 'http://localhost:8080/hog_technical_test_2017_api/users/list',
      data: { token : accessToken },
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);
        
        allUsers = data;
        bindConversation();
      },
      error: function(jqXHR, status, errorThrown ) {
        console.log("Error : ", status, "Reason : ", errorThrown);
      },
      method: 'GET'
    });

    $("#save-conversation").on("click", function(e) {
      e.preventDefault();

    });

    // Prepare conversation
    var bindConversation = function() {
      if( !conversation || !allUsers || allUsers.length == 0 ) return;

      console.log("bindConversation");

      $("#subject").val(conversation.subject);
      $("#subject")[0].dispatchEvent(new Event('input'));

      var participants = [];
      conversation.participations.forEach( function(elmt, i, array) {
        participants.push( elmt.user.id );
      } );

      var $emptyUser = $("#empty-user");
      var $list = $("ul.users-list-control");
      $list.html("");

      allUsers.forEach( function(elmt, i, array) {
        var newLine = $emptyUser.clone();

        newLine.attr("id", "");
        newLine.find(".full_name").text(elmt.name);
        newLine.find("label").attr("for", elmt.id);
        newLine.find("input").attr("id", elmt.id);
        newLine.find("input").attr("data-user", elmt.id);

        var j = participants.indexOf(elmt.id);
        if( j >= 0 ) {
          setTimeout( function(){ newLine.find('.mdl-js-switch')[0].MaterialSwitch.on(); }, 100 );
          newLine.find("input").attr("data-participation", conversation.participations[j].id);
        } else {
          setTimeout( function(){ newLine.find('.mdl-js-switch')[0].MaterialSwitch.off(); }, 100 );
        }

        newLine.find("input").change( function() {
          var $this = $(this);
          var participation = null;
          var participant = null;

          if( !$this.is(":checked") ) {

            participation = $this.attr("data-participation");
            $.ajax({
              url: 'http://localhost:8080/hog_technical_test_2017_api/participations/delete',
              data: {
                id : participation,
                token : accessToken
              },
              success: function(data, status, jqXHR ) {
                console.log(status);
                console.log(data);
                
                $this.attr("data-participation", "");
              },
              error: function(jqXHR, status, errorThrown ) {
                console.log("Error : ", status, "Reason : ", errorThrown);
              },
              method: 'GET'
            });

          } else {

            participant = $this.attr("data-user");
            $.ajax({
              url: 'http://localhost:8080/hog_technical_test_2017_api/participations/create',
              data: {
                participant : participant,
                conversation : conversation.id,
                token : accessToken
              },
              success: function(data, status, jqXHR ) {
                console.log(status);
                console.log(data);
                
                $this.attr("data-participation", data.id);
              },
              error: function(jqXHR, status, errorThrown ) {
                console.log("Error : ", status, "Reason : ", errorThrown);
              },
              method: 'GET'
            });

          }
        } );
      
        newLine.appendTo($list);

      } );
    };

  });
</script>

</body> 
</html> 