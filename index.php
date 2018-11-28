<?php
session_start ();
function loginForm() {
    echo '
   <div id="loginform">
   <style>img {display:none;}html,body{height:100%; overflow: hidden;}</style>
   <form action="index.php" method="post">
       <p>Please enter your name to continue:</p>
	   <br><br>
       <label for="name">Name:</label>
       <input style="border: 1px solid #474747;" type="text" autofocus="" name="name" id="name" />
       <input type="submit" name="enter" id="enter" value="Enter" />
   </form>
   </div>
   ';
}

if (isset ($_POST ['enter'])) {
	if (strlen($_POST ['name']) > 15) {
		echo "<span class='error'>Please enter a name under 15 characters</span>";
	}
	elseif (strlen($_POST ['name']) < 1) {
		echo "<span class='error'>Please enter a name</span>";
	}
	elseif (ctype_space($_POST ['name'])) {
		echo "<span class='error'>Please enter a name</span>";
	}
    elseif ($_POST ['name'] == "GH057") {
        $_SESSION ["name"] = stripslashes (htmlspecialchars($_POST ["name"]));
        $fp = fopen ( "log.html", "a" );
        fclose ($fp);
    }
    else {
        $_SESSION ["name"] = stripslashes (htmlspecialchars($_POST ["name"]));
        $fp = fopen ( "log.html", "a" );
        //fwrite ($fp, "<alert><div class='msgln'><i><span>(".date("g:i A").")</span> User " . $_SESSION ['name'] . " has joined the chat session.</i><br></div></alert>");
        fclose ($fp);
    }
}

if (isset ($_GET ["logout"])) {
    if ($_SESSION ['name'] == "GH057") {
        session_destroy ();
        header ("Location: index.php");
    }
    else {
        $fp = fopen ("log.html", "a");
        //fwrite ($fp, "<alert><div class='msgln'><i><span>(".date("g:i A").")</span> User " . $_SESSION ['name'] . " has left the chat session.</i><br></div></alert>");
        fclose ($fp);
        session_destroy ();
        header ("Location: index.php"); //refresh the page and destroy the session
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<link id="css" rel="stylesheet" type="text/css" href="dark.css">
<title>Chat</title>
<link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<body>
    <?php
    if (! isset ($_SESSION ['name'])) {
        loginForm ();
    } else {
        ?>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">Hello, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
            <div style="clear: both"></div>
        </div>
        <div id="chatbox"><?php
        if (file_exists ("log.html") && filesize ("log.html") > 0) {
            $handle = fopen ("log.html", "r");
            $contents = fread ($handle, filesize ("log.html"));
            fclose ($handle);
           
            echo $contents;
        }
        ?></div>
        <?php
        if ($_POST ["name"] != "GH057") {
            echo '
            <form name="message" action="">
                <input name="usermsg" autofocus="" spellcheck="true" type="text" id="usermsg" size="63"/> <input name="submitmsg" type="submit" id="submitmsg" value="Send"/>
            </form>
            ';
        }
        else {
            echo ">>> CANNOT SEND MESSAGES WHILE IN SPECTATOR MODE <<<";
        }
        ?>
    </div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>

<script>
    window.onbeforeunload = function(evt) {
    return true;
}
window.onbeforeunload = function(evt) {
    var message = "Are you sure you want to log out?";
    if (typeof evt == "undefined") {
        evt = window.event.srcElement;
    }
    if (evt) {
        evt.returnValue = message;
    }
}
</script>

<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});
 
//jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = true;
        if(exit==true){window.location = 'index.php?logout=true';}
    });
});

//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});

function loadLog(){ //convert from jQuery to JavaScript
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){
            $("#chatbox").html(html); //Insert chat log into the #chatbox div
           
            //Auto-scroll
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); //Autoscroll to bottom of div
            }
        },
    });
}
 
setInterval (loadLog, 2000);
</script>
<?php
    }
    ?>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
</script>
</body>
</html>
