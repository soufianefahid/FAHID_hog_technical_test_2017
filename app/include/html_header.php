<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/hog_technical_test_2017';
?>
<meta charset="utf-8">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-indigo.min.css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

<link rel="stylesheet" href="<?php echo $root; ?>/css/main.css" />

<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/fr.js"></script>

<title>[HoG] Technical test - 2017</title>

<script type="text/javascript">

  var accessToken = null;
  var userID = null;

  var getQueryString = function () {
	  // This function is anonymous, is executed immediately and 
	  // the return value is assigned to QueryString!
	  var query_string = {};
	  var query = window.location.search.substring(1);
	  var vars = query.split("&");
	  for (var i=0;i<vars.length;i++) {
	    var pair = vars[i].split("=");
	        // If first entry with this name
	    if (typeof query_string[pair[0]] === "undefined") {
	      query_string[pair[0]] = decodeURIComponent(pair[1]);
	        // If second entry with this name
	    } else if (typeof query_string[pair[0]] === "string") {
	      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
	      query_string[pair[0]] = arr;
	        // If third or later entry with this name
	    } else {
	      query_string[pair[0]].push(decodeURIComponent(pair[1]));
	    }
	  } 
	  return query_string;
	};

  var formatTimestamp = function(timestamp) {
    return moment(timestamp).format("HH:mm:ss DD/MM/YYYY");
  };

  var getCookies = function() {
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookies = {};

    var vars = decodedCookie.split(";");

    for (var i=0;i<vars.length;i++) {
      var pair = vars[i].split("=");
      if( pair.length != 2 ) continue;

      pair[0] = pair[0].trim();
      pair[1] = pair[1].trim();
      // If first entry with this name
      if (typeof cookies[pair[0]] === "undefined") {
        cookies[pair[0]] = decodeURIComponent(pair[1]);
          // If second entry with this name
      } else if (typeof cookies[pair[0]] === "string") {
        var arr = [ cookies[pair[0]],decodeURIComponent(pair[1]) ];
        cookies[pair[0]] = arr;
          // If third or later entry with this name
      } else {
        cookies[pair[0]].push(decodeURIComponent(pair[1]));
      }
    }

    return cookies;
  };

  var getPageName = function() {
    var path = window.location.pathname;
    var pathElmts = path.split("/");
    var lastElmt = pathElmts[pathElmts.length - 1];

    if( lastElmt.length == 0 ) {
      lastElmt = pathElmts[pathElmts.length - 2];
    }

    var pageName = lastElmt.split("?")[0];

    return pageName;
  };

  var cookies = getCookies();
  if( cookies["hog_userID"] ) {
    userID = cookies["hog_userID"];
  }
  if( cookies["hog_accessToken"] ) {
    accessToken = cookies["hog_accessToken"];
  }

  var open_routes = ["login.php", "signup.php"];
  var open_route = open_routes.indexOf( getPageName() ) > -1;

  console.log( open_route, accessToken, userID );
  console.log( "test", !open_route && ( !accessToken || !userID ) );

  if( !open_route && ( !accessToken || !userID ) ) {
    window.location.href = "<?php echo $root; ?>/app/users/login.php";
  }
</script>