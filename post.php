<?php
session_start();

if(isset($_SESSION['name'])){
    if ($_POST ['text'] == "") {
        #prevents user from sending a blank message
    }
    else {
		function BBcode($parse) {
			$find = array(
				'~\[b\](.*?)\[/b\]~s',
				'~\[i\](.*?)\[/i\]~s',
				'~\[u\](.*?)\[/u\]~s',
				'~\[color=(.*?)\](.*?)\[/color\]~s',
				'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s'
			);
			$replace = array(
				'<b>$1</b>',
				'<i>$1</i>',
				'<span style="text-decoration:underline;">$1</span>',
				'<span style="color:$1;">$2</span>',
				'<a href="$1" target="blank">$1</a>'
			);
			return preg_replace($find, $replace, $parse);
		}

        $text = $_POST['text'];
		$message = BBcode($text);
        $fp = fopen("log.html", 'a');
        fwrite($fp, "<div class='msgln'><span>(".date("g:i A").") <b><user>".$_SESSION['name']."</user></b>: ".stripslashes (($message))."<br></span></div>");
        fclose($fp);
    }
}
?>
