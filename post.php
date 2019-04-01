<?php
session_start();

if(isset($_SESSION['name'])){
    if ($_POST ['text'] == "") {
        #prevents user from sending a blank message
    }

        $text = $_POST['text'];
        $fp = fopen("log.html", 'a');
        fwrite($fp, "<div class='msgln'><span>(".date("g:i A").") <b><user>".$_SESSION['name']."</user></b>: ".stripslashes (htmlspecialchars($text))."<br></span></div>");
        fclose($fp);
    }
}
?>
