<!DOCTYPE HTML>
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "1";
?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title> System kontroli pomieszczenia</title>
	<link href="stylee.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
	<style>
				table{
					border-collapse: collapse;
					width: 500px;
					color: lightblue;
					font-family: monospace;
					font-size:15px;
					text-align: center;
					
				}
				th{
					background-color: #801a5a;
					border: solid #801a5a 1px;
				}
				td {
					border: solid #801a5a 1px;
					color: black;
				}	

		</style>
</head>

<body>
	<div id=container>

		<div id=logo>
			Stats subpage
		</div>
<div id=logo3>
	<?php
	echo date('d.m.Y');
	?>
	</div>
	<div id=logo2> 
	
	<div id="czas"></div>
	<!--w javascript pokazana aktualna godzina-->
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
		<div id=content>
			
			<center>
			<table>
			<tr>
				<th>Temperature max</th>
				<td><?php
			//laczenie z baza danych
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY temperature DESC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["temperature"] ;
				}
			
			}
			$conn->close();
			?></td>
			<td>	<?php		$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY temperature DESC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["date"] ;
				}
			
			}
			$conn->close();
			?></td>
			</tr>
			<tr>
				<th>Temperature min</th>
				<td><?php
			//laczenie z baza danych
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY temperature ASC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["temperature"] ;
				}
			
			}
			$conn->close();
			?></td>			<td>	<?php		$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY temperature ASC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["date"] ;
				}
			
			}
			$conn->close();
			?></td>
			</tr>
			
			<tr>
				<th>Humidity max</th>
				<td><?php
			//laczenie z baza danych
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY humidity DESC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["humidity"] ;
				}
			
			}
			$conn->close();
			?></td>			<td>	<?php		$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY humidity DESC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["date"] ;
				}
			
			}
			$conn->close();
			?></td>
			</tr>
			<tr>
				<th>Humidity min</th>
				<td><?php
			//laczenie z baza danych
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY humidity ASC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["humidity"] ;
				}
			
			}
			$conn->close();
			?></td>			<td>	<?php		
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");
			
			$wynik = $conn->query("SELECT * FROM sensors ORDER BY humidity ASC LIMIT 1");
			
			if($wynik->num_rows > 0)
			{
				while($wiersz=$wynik->fetch_assoc() )
				{
					echo $wiersz["date"] ;
				}
			
			}
			$conn->close();
			?></td>
			</tr>
			</table>
			<table>
			
			<tr>
			<th>Previously opened</th>
			<td><?php		
			$baza=mysqli_connect("localhost", "root", "", "it4");

			if (mysqli_connect_errno())

			{echo "Wystąpił błąd połączenia z bazą";}

			$wynik = mysqli_query($baza,"SELECT * FROM sensors WHERE doors='OPEN' ORDER BY date desc limit 1");

			while($row = mysqli_fetch_array($wynik))

			{echo $row['date']; }

			mysqli_close($baza);
			?></td>
			</tr>
						<tr>
			<th>Average temperature</th>
			<td><?php		
			$baza=mysqli_connect("localhost", "root", "", "it4");

			if (mysqli_connect_errno())

			{echo "Wystąpił błąd połączenia z bazą";}

			$wynik = mysqli_query($baza,"SELECT avg(temperature), ROUND(AVG(temperature),2) as srednia FROM `sensors`");

			

			while($row = mysqli_fetch_array($wynik))

			{echo $row['srednia']; }

			mysqli_close($baza);
			?></td>
			</tr>
						</tr>
						<tr>
			<th>Average humidity</th>
			<td><?php		
			$baza=mysqli_connect("localhost", "root", "", "it4");

			if (mysqli_connect_errno())

			{echo "Wystąpił błąd połączenia z bazą";}

			$wynik = mysqli_query($baza,"SELECT avg(humidity), ROUND(AVG(humidity),2) as humidity FROM `sensors`");

			

			while($row = mysqli_fetch_array($wynik))

			{echo $row['humidity']; }

			mysqli_close($baza);
			?></td>
			</tr>
			</table>
			</center>
		</div>
		<BUTTON onClick="parent.location.href='main.php'">
				Main page
			</BUTTON></br></br>
		 
			<div id=coppy>
	Coppyright by Michał Padło and Aleksander Porębski
	</div></br>
	</div>
</body>

</html>