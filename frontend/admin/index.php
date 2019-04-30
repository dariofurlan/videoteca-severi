<?php session_start();?>
<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>		
        <title>Login</title>
        <link href="style/login.css" rel="stylesheet"> 
    </head>
    <body>


        <div class="sidenav">
            <div class="login-main-text">
                <h2>DVD Severi<br> Pagina di Login</h2>
                <p>Immetti le credenziali per accedere.</p>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                    <form action ="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">                  
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <input type="submit" name="invio" value="invio" class="btn btn-black">
                    </form>
 <?php                   
//Se qualcuno è loggato non visualizzerà il login
if (isset($_SESSION["username"])) {
    header("Location: loginok.php");
}

//Controllo username & password
if (isset($_POST["invio"])) {
		
    require 'conn.php';
    
    //Controllo USERNAME
    if (!isset($_POST["username"]) || empty($_POST["username"])) {
		
        die("<label style='color:red;'>Inserisci username!</label>");
        
    } else {
		
        $username = $_POST["username"];
        $username = stripslashes($username);
        $username = mysqli_real_escape_string($conn, $username);
        
    }
    
    //Controllo PASSWORD
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
		
       die("<label style='color:red;'>Inserisci la password!</label>");
       
    } else {
		
        $password = $_POST["password"];
        $password = stripslashes($password);
        $password = mysqli_real_escape_string($conn, $password);
        $passmd5 = md5($password);
    
    }
    
    $sql = "SELECT * FROM $tab_name WHERE username='$username' AND password='$passmd5'";
    $result = $conn->query($sql);
    
    if (!$result) {
		
        die("<label style='color:red;'>Errore della query: " . $conn->error . ".</label>");
        
    } else {
		
        $conta = $result->num_rows;
        
        if ($conta == 1) {
			
            session_start();
            
            $_SESSION["username"] = $username;
            
            header("Location: loginok.php");
            
        } else {
			
            echo "<label style='color:red;'>Username o Password errata!</label>";
            
        }
    }
}
?>
                </div>
            </div>
        </div>





    </body>
</html>  
