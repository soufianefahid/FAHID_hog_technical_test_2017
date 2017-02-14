<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../include/html_header.php';?>
  <link rel="stylesheet" href="conversations.css" />
</head>
<body>

<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header show-conversation">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Conversation</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="header-link mdl-navigation__link" id="edit-conversation" href="">Modifier</a>
      </nav>
    </div>
  </header>

  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <h4 id="conversation-title"></h4>
      <div class="messages-container">
        
      </div>

      <!-- Floating Multiline Textfield -->
      <form action="#">
        <div class="mdl-textfield mdl-js-textfield new-message-container">
          <textarea class="mdl-textfield__input" type="text" rows= "3" id="new-message" ></textarea>
          <label class="mdl-textfield__label" for="new-message">Message...</label>
        </div>
        <div class="send-msg">
          <!-- Colored FAB button with ripple -->
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            Envoyer
          </button>
        </div>
      </form>

      <div class="empty-message" style="display: none;">
        <div class="one-message-container">
          <div class="author-area">
            <div class="author-img">
              <!-- Contact Chip -->
              <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">A</span>
            </div>
            <div class="author-name">
              <span class="mdl-chip__text">Contact Chip</span>
            </div>
          </div>
          <div class="message-area">
            <div class="message-content">Hello World !</div>
            <div class="message-time">2017/02/07 21:12</div>
            <div class="message-likes"><span>20</span> J'aime</div>
            <div class="send-like"><i class="material-icons">thumb_up</i></div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script type="text/javascript">

  var bindMessage = function($newElmt, elmt) {
    $newElmt.attr("id", "message-"+elmt.id);

    if( elmt.author.id == userID ) {
      $newElmt.addClass("my-message");
    }

    $newElmt.find(".author-img span").text(elmt.author.name.toUpperCase()[0]);
    $newElmt.find(".author-name span").text(elmt.author.name);

    $newElmt.find(".message-content").text(elmt.content);
    $newElmt.find(".message-time").text(formatTimestamp(elmt.createdAt));
    $newElmt.find(".message-likes span").text(elmt.likedBy.length);

    var likedByCurrentUser = false;
    for( var j = 0; j < elmt.likedBy.length; j++ ) {
      var like = elmt.likedBy[j];
      if( like.id == userID ) {
        likedByCurrentUser = true;
        break;
      }
    }

    if( likedByCurrentUser ) {
      $newElmt.find(".send-like i").addClass("mdl-color-text--blue");
    } else {
      $newElmt.find(".send-like i").removeClass("mdl-color-text--blue");
    }

    $newElmt.find(".send-like").attr("data-liked", likedByCurrentUser ? "liked" : "no");

    $newElmt.find(".send-like").click( function() {

      var likeCount = $(this).closest(".message-area").find(".message-likes span").text();
      likeCount = parseInt( likeCount );

      if( $(this).attr("data-liked") == "liked" ) {
        $(this).closest(".message-area").find(".message-likes span").text(likeCount-1);
        $(this).attr("data-liked", "no");
        $newElmt.find(".send-like i").removeClass("mdl-color-text--blue");
      } else {
        $(this).closest(".message-area").find(".message-likes span").text(likeCount+1);
        $(this).attr("data-liked", "liked");
        $newElmt.find(".send-like i").addClass("mdl-color-text--blue");
      }

      $.ajax({
        url: 'http://localhost:8080/hog_technical_test_2017_api/messages/update',
        data: { token : accessToken, id : elmt.id },
        success: function(data, status, jqXHR ) {
          console.log(status);
          console.log(data);
        },
        error: function(jqXHR, status, errorThrown ) {
          console.log("Error : ", status, "Reason : ", errorThrown);
        },
        method: 'GET'
      });
    } );
  };

  $(function() {

    var params = getQueryString();
    if( !params.id ) return;

    $(".send-msg button").click( function(e) {
      e.preventDefault();

      var messageContent = $("#new-message").val().trim();
      if( messageContent.length == 0 ) return false;

      $.ajax({
        url: 'http://localhost:8080/hog_technical_test_2017_api/messages/create',
        data: { token : accessToken, conversation : params.id, content : messageContent },
        success: function(data, status, jqXHR ) {
          console.log(status);
          console.log(data);
          
          var $newElmt = $(".empty-message .one-message-container").clone();

          bindMessage($newElmt, data);

          $newElmt.appendTo(".messages-container");
        },
        error: function(jqXHR, status, errorThrown ) {
          console.log("Error : ", status, "Reason : ", errorThrown);
        },
        method: 'GET'
      });

      $("#new-message").val("");
      $("#new-message")[0].dispatchEvent(new Event('input'));

      return false
    } );

    $("#edit-conversation").click( function(e) {
      e.preventDefault();
      window.location.href = "edit.php?id="+params.id;
    } );

    $.ajax({
      url: 'http://localhost:8080/hog_technical_test_2017_api/conversations/show',
      data: { token : accessToken, id : params.id },
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);

        $("#conversation-title").text( data.subject );
        
        var messages = data.messages;

        var emptyMessage = $(".empty-message .one-message-container");
        var $messagesContainer = $(".messages-container");  

        messages.forEach( function(elmt, i, array) {
          var $newElmt = emptyMessage.clone();

          bindMessage($newElmt, elmt);

          $newElmt.appendTo($messagesContainer);
        } );

        var isOwner = false;
        var participations = data.participations;
        participations.forEach( function(elmt, i, array) {
          if( elmt.isOwner && elmt.user.id == userID ) {
            isOwner = true;
          }
        } );

        if( !isOwner ) {
          $("#edit-conversation").remove();
        }
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