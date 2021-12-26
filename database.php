<?php
	session_start();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title> System kontroli pomieszczenia</title>
	<link href="stylee.css" rel="stylesheet" type="text/css" />
			<style>
				table{
					border-collapse: collapse;
					width: 100%;
					color: lightblue;
					font-family: monospace;
					font-size:15px;
					text-align: center;
				}
				th{
					background-color: #801a5a;
				}
				td {
					border: solid #801a5a 1px;
					
  border-radius: 10px;
					color: black;
				}
		</style>
</head>


<body>
	<div id=container>

		<div id=logo>
			Database
		</div>
<div id=logo3>
	<?php
	echo date('d.m.Y');
	?>
	</div>
	<div id=logo2> 
	
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
		<div id=content>
		<!--Type hour you would like to find
		</br>
		<input type="text" placeholder="Hour" name="code" onfocus="this.placeholder=''" onblur="this.placeholder='Hour'"></br></br> 
		<input type="text" placeholder="Hour" name="code" onfocus="this.placeholder=''" onblur="this.placeholder='Hour'"></br></br>-->
		<BUTTON onClick="parent.location.href='main.php'">
				Main page
			</BUTTON><br><br>
		<h>Type date you would like to find</h>
		</br>
		<form action="" method="GET">
		<input type="text" placeholder="dd-mm-yyyy hh:mm:ss" name='dstart' value="<?php if(isset($_GET['dstart'])){echo $_GET['dstart'];}/*sprawdzenie i wpisywanie daty*/ ?>" onfocus="this.placeholder=''" onblur="this.placeholder='dd-mm-yyyy hh:mm:ss'">
		<!--input type="text" placeholder="Date stop" name="datestop" onfocus="this.placeholder=''" onblur="this.placeholder='Date stop'"-->
		</br>
		<input type="submit" value="Search">
		</form></br></br>
		<center>
		<table>
			<tr>
				<th>ID</th>
				<th>gas</th>
				<th>smoke</th>
				<th>temperature</th>
				<th>humidity</th>
				<th>doors</th>
				<th>date</th>
			</tr>
			<?php
			$conn = new mysqli("localhost", "root", "", "it4") or die("error");

			if(isset($_GET['dstart'])){
				$dstart=$_GET['dstart'];

				$wynik = $conn->query("SELECT * FROM sensors WHERE date LIKE '$dstart%' LIMIT 100");
				if($wynik -> num_rows>0){
					while($row=$wynik->fetch_assoc()){
						echo '<tr><th>'.$row['ID'].'</th><td>'.$row['gas'].'</td><td>'.$row['smoke'].'</td><td>'.$row['temperature'].'</td><td>'.$row['humidity'].'</td><td>'.$row['doors'].'</td><td>'.$row['date'].'</td></tr>';
					}
				}
				else
				{
					echo 'No results';
				}
				
			
				$conn->close();
			}
			else
			{
				echo 'TYPE CORRECT DATA<br>';
			}
			/*
			
			if($wynik->num_rows > 0){
				
				echo "<table>";
				echo "<tr>";
				echo "<th>date</th>";
				echo "<th>humidity</th>";
				echo "<th>temperature</th>";
				echo "<th>doors</th>";
				echo "<th>gas</th>";
				echo "<th>smoke</th>";
				echo "</tr>";
				
				while( $wiersz = $wynik->fetch_assoc() ){
					echo "<tr>";
					
					echo "<td>" . $wiersz["date"]    . "</td>";
					echo "<td>" . $wiersz["humidity"] . "</td>";
					echo "<td>" . $wiersz["temperature"] . "</td>";
					echo "<td>" . $wiersz["doors"]    . "</td>";
					echo "<td>" . $wiersz["gas"]    . "</td>";
					echo "<td>" . $wiersz["smoke"]    . "</td>";
					echo "</tr>";
				}
				
				echo "</table>";
				
			}
			*/
		?>
		</table>

		<br>
		
			
			</center>
		</div>
		
			<div id=coppy>
	Coppyright by Michał Padło and Aleksander Porębski
	</div></br>
	</div>
</body>

</html>