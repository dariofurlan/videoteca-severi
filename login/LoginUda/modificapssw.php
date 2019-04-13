<?php
	session_start();
	if(!isset($_SESSION["username"])){
		header("Location: login.html");}
	
?>

<html>
<body>
	<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post"><br>
		Vecchia Password<input type="password" name="old_pass"/><br>
		Nuova Password<input type="password" name="new_pass"/><br>
		Conferma Password<input type="password" name="confirmnew_pass"/><br>
		<input type="submit" name="invio" value="Cambia password">
	</form>
	<a href="index.php">Torna al Login</a></br>
	<a href="logout.php">Logout</a></br>
	
	<?php
		if(isset($_POST["invio"]) && !empty($_POST["invio"])){
			if(!isset($_POST["old_pass"]) || empty($_POST["old_pass"])){
				echo"inserisci la Vecchia Password</br>";
				exit();}
		
			if(!isset($_POST["new_pass"]) || empty($_POST["new_pass"])){
				echo"inserisci la nuova password</br>";
				exit();}
		
			if(!isset($_POST["confirmnew_pass"]) || empty($_POST["confirmnew_pass"])){
				echo"inserisci la conferma della nuova password</br>";
				exit();}
			require "conn.php";
			$username=$_SESSION["username"];
			$old_pass=$_POST["old_pass"];
			$old_pass=stripslashes($old_pass);
			$old_pass== mysqli_real_escape_string($conn, $old_pass);
			$old_passmd5=md5($old_pass);
			
			
			$new_pass=$_POST["new_pass"];
			$new_pass=stripslashes($new_pass);
			$new_pass = mysqli_real_escape_string($conn, $new_pass);
			$passmd5=md5($new_pass);

			
			$confirmnew_pass=$_POST["confirmnew_pass"];
			$confirmnew_pass=stripslashes($confirmnew_pass);
			$confirmnew_pass = mysqli_real_escape_string($conn, $confirmnew_pass);
			$conf_passmd5=md5($confirmnew_pass);
			
			if($new_pass!=$confirmnew_pass)
				echo "Le password sono diverse!";
			else{
				$sql = "UPDATE ADMIN
						SET Password = '$conf_passmd5'
						WHERE Username = '$username' AND Password = '$old_passmd5'";				
				if (!$conn->query($sql)) {
					echo "Errore della query: " . $conn->error . ".";
				} else {
					echo "Password Cambiata";
				}
			}
		}
	
	?>
</body>
	
	
	
	
	
	
	</html>
		
