function show() {
	document.getElementById("settings").style.display = "block";
	document.getElementById("settings").style.height = "auto";
}

function change() {
	style = document.getElementById("style");
	option = style.options[style.selectedIndex].text;
	cssfile = option + ".css";
	if (option == "Dark") {
		document.getElementById("css").setAttribute("href", cssfile)
	}
	else if (option == "Light") {
		document.getElementById("css").setAttribute("href", cssfile)
	}
}