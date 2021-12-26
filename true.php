<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		/* jezeli w zadnym "if'ie" nie bedzie false to $wszystko_OK bedzie miala wartość true i rejestracja przebiegnie pomyślnie*/
		$wszystko_OK=true;
		
		
		$nick = $_POST['nick'];
		
		/*sprawdzenie czy nick ma od 4 do 20 znakow*/
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="The nickname must be 4 to 20 characters long!";
		}
		/*sprawdzenie czy nick nie zawiera polskich znakow*/
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="The nickname can only consist of letters and numbers (no Polish characters)";
		}
		
		
		$email = $_POST['email'];
		/*domyslna w php funkcja sprwadzająca czy dany email może istnieć*/
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Please enter a valid e-mail address!";
		}
		
		
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		/*sprawdzenie czy haslo ma od 4 do 20 znakow*/
		if ((strlen($haslo1)<4) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="The password must be 4 to 20 characters long!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="The given passwords do not match!";
		}	

		/*$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);*/
		$haslo_hash = $haslo1;
		/*zaimplementowana przez firme google captcha sprawdzajaca czy nie rejestruje sie robot*/
		$sekret = "6LcCppIdAAAAAArY72TcdcXA2Fg5z-g-JkeTksS4";
		$response = $_POST['g-recaptcha-response'];
		$remoteip = $_SERVER['REMOTE_ADDR'];
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		/* captcha */
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Confirm that you are not a bot!";
		}		
		/* zapisanie w bazie danych tych wartości*/
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		/*laczenie sie z baza danych*/
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM it_users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
					/*sprawdzenie czy nie istnieje juz taki email w bazie danych*/
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="There is already an account assigned to this email address!";
				}		

				$rezultat = $polaczenie->query("SELECT id FROM it_users WHERE user='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
					/*sprawdzenie czy nie istnieje juz taki nick w bazie danych*/
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="There is already a player with this nickname! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					
					if ($polaczenie->query("INSERT INTO it_users VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['loggedIn']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			/* przypadku w ktorym nie uda sie polaczyc do serwera*/
			echo '<span style="color:red;">server bug!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title> System kontroli pomieszczenia</title>
	<link href="stylee.css" rel="stylesheet" type="text/css" />
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
	<!--style w css dla wyswietlenia bledow-->
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<div id=container>

		<div id=logo>
			Register now
		</div></br>
	<form method="post">
	<!--utworzenie front endu, tzn miejsca do wpisania danych, przycisku "register" oraz captchy-->
		Nickname: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name="nick" /><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		<br />
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		<br />
		Your password: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>" name="haslo1" /><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		<br />
		Powtórz hasło: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>" name="haslo2" /><br /></br>
		<center>
		<div class="g-recaptcha" data-sitekey="6LcCppIdAAAAANjoCBxIp3vXxUEm7Chrq0lJp6-S"></div>
		</center>
		
		<?php
			if (isset($_SESSION['e_bot']))
			{
			echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
			}
		?>	
		
		
		<input type="submit" value="Zarejestruj się" />
		
	</form>
	
	</br></br>
			<div id=coppy>
	Coppyright by Michał Padło and Aleksander Porębski
	</div></br>
</div>
</body>
</html>