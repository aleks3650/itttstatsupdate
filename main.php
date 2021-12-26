<?php
	session_start();

	if(!isset($_SESSION['loggedIn']))
	{
		header('Location: index.php');
		exit();
	}


?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title> System kontroli pomieszczenia</title>
	<!--implementaja css-->
	<link href="stylee.css" rel="stylesheet" type="text/css" />
</head>


<body>
<!--div container to biala część centralna w ktorej znajduje sie strona-->
	<div id=container>
	
	<div id=logo>
	Main page
	</div>
<div id=logo3>
<!--pokazuje za pomoca funkcji php aktualny czas-->
	<?php
	echo date('d.m.Y');
	?>
	</div>
	<div id=logo2> 
	<!--przy pomocy javascript pokazuje aktualny czas-->
	<div id="czas"></div>
<script type="text/javascript">
function getTime() 
{
    return (new Date()).toLocaleTimeString();
}
document.getElementById('czas').innerHTML = getTime();
 
setInterval(function() {
 
    document.getElementById('czas').innerHTML = getTime();
     
}, 1000);
</script>
	</div>
	<!--Main page-->
	<div id=logo>
	<a class="weatherwidget-io" href="https://forecast7.com/en/50d2918d67/gliwice/" data-label_1="GLIWICE" data-label_2="WEATHER" data-theme="original" >GLIWICE WEATHER</a>
	<script>
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
	</script>
	</div>
	<!--sensors-->
	<BUTTON onClick="parent.location.href='sensors.php'">
	Sensors
	</BUTTON><br />
	<!--database-->
	<BUTTON onClick="parent.location.href='database.php'">
	Database
	</BUTTON><br />
	<!--stats-->
	<BUTTON onClick="parent.location.href='stats.php'">
	Stats
	</BUTTON><br />
	<!--log out-->
	<BUTTON onClick="parent.location.href='logout.php'">
	Log out
	</BUTTON></br>
	</br>
	<div id=coppy>
	Coppyright by Michał Padło and Aleksander Porębski
	</div>
	</div>
	</div>
	
	</body>

</html>