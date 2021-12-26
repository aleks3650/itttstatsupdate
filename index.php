<?php
	/* sprawdzenie czy uzytkownik jest zalogowany  */
  session_start();

  if(isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']==true))
  {
    header('Location: main.php');
    exit();
  }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<!--ustawienie znakow-->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title> System kontroli pomieszczenia</title>
	<!--implementacja css-->
	<link href="stylee.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!--chowany obrazek z przejsciem do panelu administratora-->
<div id="fotografia">
<a href="admin.php"><img src="szare.png" border=0px width=100px height=100px style="float: right" onmouseover="this.src = 'admin.png'" onmouseout="this.src = 'szare.png'"></a>
</div>
<div id=container>

  <div id="logo">
    Room Control System
  </div>
  <div id=login>
  <!--formularz logowania-->
		<form action="login.php" method="post">
        <input type="text" placeholder="Login" name="login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'">
        <input type="password" placeholder="Password" name="password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'">

        <input type="submit" value="Log In">
		
    </form><br />
    <?php
      if(isset($_SESSION['error'])) echo $_SESSION['error'];
    ?>
  </div>
  
    </br></br>
			<div id=coppy>
	Coppyright by Michał Padło and Aleksander Porębski
	</div></br>
 </div>

</body>

</html>