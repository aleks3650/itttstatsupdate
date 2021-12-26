<?php
$code = $_POST['code'];
echo $code."<br />";
$a=123;
/* sprawdzeni czy podany kod administratora przez uzytkownika zgadza sie z ustawionym kodem zadeklarowanym jako $a */
if($code==$a)
{
	/* przekierowanie do odpowiednich stron*/
	header("Location: true.php");
	
}
else
{
	header("Location: false.php");
}
?>