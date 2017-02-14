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
      <span class="mdl-layout-title">Conversations</span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="mdl-navigation__link" href="create.php">Créer une conversation</a>
      </nav>
    </div>
  </header>
  
  <?php include '../include/menu.php';?>

  <main class="mdl-layout__content">
    <div class="page-content">
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--non-numeric">Sujet</th>
            <th class="mdl-data-table__cell--non-numeric">Date de création</th>
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
            <td class="mdl-data-table__cell--non-numeric subject">:subject</td>
            <td class="mdl-data-table__cell--non-numeric created_at">:created_at</td>
            <td class="mdl-data-table__cell--non-numeric actions">
              <button data-id=":id" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent show">Voir</button>
              <button data-id=":id" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent edit">Modifier</button>
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
      url: 'http://localhost:8080/hog_technical_test_2017_api/users/show',
      data: { token : accessToken },
      success: function(data, status, jqXHR ) {
        console.log(status);
        console.log(data);
        
        var participations = data.participations;

        var emptyLine = $("#empty-line tr");
        var $tbody = $("tbody");
        participations.forEach( function(elmt, i, array) {
          var $newElmt = emptyLine.clone();

          $newElmt.attr("id", "participation-"+elmt.conversation.id);
          $newElmt.find(".subject").html(elmt.conversation.subject);
          $newElmt.find(".created_at").html(formatTimestamp(elmt.conversation.createdAt));

          if( elmt.isOwner ) {
            $newElmt.find(".edit").attr("data-id", elmt.conversation.id);

            $newElmt.find(".edit").on("click", function(e) {
              var $elmt = $(this).closest("tr");
              var id = $elmt.attr("id").split("-")[1];
              window.location.href = "edit.php?id="+id;
            });
          } else {
            $newElmt.find(".actions .edit").remove();
          }
          
          $newElmt.find(".show").on("click", function(e) {
            var $elmt = $(this).closest("tr");
            var id = $elmt.attr("id").split("-")[1];
            window.location.href = "show.php?id="+id;
          });

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