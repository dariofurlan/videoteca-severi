<?php
	session_start();
	session_unset();
	session_destroy();
	echo "logout effettuato <a href='index.php'>Torna al login</a>";
?>
