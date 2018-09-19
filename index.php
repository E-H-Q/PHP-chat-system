<?php
session_start ();
function loginForm() {
    echo '
   <div id="loginform">
   <style>img {display:none;}html,body{height:100%; overflow: hidden;}</style>
   <form action="index.php" method="post">
       <p>Please enter your name to continue:</p>
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
        fwrite ($fp, "<alert><div class='msgln'><i><span>(".date("g:i A").")</span> User " . $_SESSION ['name'] . " has joined the chat session.</i><br></div></alert>");
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
        fwrite ($fp, "<alert><div class='msgln'><i><span>(".date("g:i A").")</span> User " . $_SESSION ['name'] . " has left the chat session.</i><br></div></alert>");
        fclose ($fp);
        session_destroy ();
        header ("Location: index.php"); //refresh the page and destroy the session
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<style>
html, body {
    height: auto;
}

html {
    display: table;
    margin: auto;
}

body {
    background-color: #000000;
    font: 12px Consolas, Courier;
    color: #FFFFFF;
    padding: 35px;
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
 
form, p, span {
    margin: 0;
    padding: 0;
}
 
input {
    font: 12px Consolas, Courier;
}
 
a {
    color: #FF0000;
    text-decoration: none;
}
 
a:hover {
    text-decoration: underline;
}
 
#wrapper,#loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    text-align: center;
    background: #202020;
    width: 50vw;
    border: 1px solid #474747;
}
 
#loginform {
    padding-top: 18px;
}
 
#loginform p {
    margin: 5px;
}

#chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #202020;
    height: 70vh;
    width: 45vw;
    border: 1px solid #474747;
    overflow: auto;
}
 
#usermsg {
    width: 40vw;
    border: 1px solid #FFFFFF;
}
 
#submit {
    width: 60px;
}
 
.error {
    color: #ff0000;
}
 
#menu {
    padding: 12.5px 25px 12.5px 25px;
}
 
.welcome {
    float: left;
}
 
.logout {
    float: right;
}
 
.msgln {
    margin: 0 0 2px 0;
}

user {
    color: #00FF00;
    font: 15px Consolas, Courier;
    font-weight: bold;
    letter-spacing: -1px;
}

alert {
    text-align: center;
}

img {
    text-align: left;
    vertical-align: top;
    margin-bottom: 10px;
    max-width: 20vw;
}

.settings {
	display: table-cell;
    vertical-align: top;
	text-align: right;
	width: 100vw;
}

.settings img {
	cursor: pointer;
}

#settings {
	display: none;
	background-color: #FFFFFF;
	position: relative;
	text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #202020;
    height: 0px;
    width: 45vw;
    border: 1px solid #474747;
    overflow: auto;
}

#settings img {
    cursor: pointer;
    float: right;
}
</style>
<title>Chat</title>
<script src="settings.js"></script>
<link rel="shortcut icon" type="image/png" href="favicon.png"/>
</head>
<div class="settings">
	<img src="settings.png" style="width: 50px;" onclick="show()">
</div>
<div id="settings">
    <img src="close.png" style="width: 25px;" onclick="document.getElementById('settings').style.display = 'none';">
</div>
<body>
    <?php
    if (! isset ( $_SESSION ['name'])) {
        loginForm ();
    } else {
        ?>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">
                Hello, <b><?php echo $_SESSION['name']; ?></b>
            </p>
            <p class="logout">
                <a id="exit" href="#">Exit Chat</a>
            </p>
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
        if ($_POST ['name'] != "GH057") {
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
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});
 
//jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to log out?");
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
