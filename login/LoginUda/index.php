<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<h2>Accesso all'area riservata</h2>
		<form action ="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			E-mail: <input type="text" name="username" size="40" /></br>
			Password: <input type="password" name="password" size="20" /></br>
			<input type="submit" name="invio" value="Login" />
			<input type="reset" name="cancella" value="Annulla" />
		</form>
	</body>
</html>
<?php
session_start();
if (isset($_SESSION["username"])) {
	header("Location: loginok.php");}
	
if (isset($_POST["invio"])) {
	require 'conn.php';
	if (!isset($_POST["username"]) || empty($_POST["username"])) {
		echo "Inserisci username";
		exit();
	} else {
		$username=$_POST["username"];
		$username=stripslashes($username);
		$username = mysqli_real_escape_string($conn, $username);
	}
	if (!isset($_POST["password"]) || empty($_POST["password"])) {
		echo "Inserisci Password";
		exit();
	} else {
		$password=$_POST["password"];
		$password=stripslashes($password);
		$password = mysqli_real_escape_string($conn, $password);
		$passmd5=md5($password);
	}
	$sql="SELECT * FROM $tab_name WHERE username='$username' AND password='$passmd5'";
	$result=$conn->query($sql);
	if (!$result) {
		echo "Errore della query: " . $conn->error . ".";
	} else {
		$conta=$result->num_rows;
		if ($conta==1) {
			session_start();
			$_SESSION["username"]=$username;
			header("Location: loginok.php");
		} else {
			echo "Identificazione non riuscita";
		}
	}
}
?>
