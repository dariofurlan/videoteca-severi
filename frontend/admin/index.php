<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>		<title>Login</title>
        <style>
            body {
                font-family: "Lato", sans-serif;
            }



            .main-head{
                height: 150px;
                background: #FFF;

            }

            .sidenav {
                height: 100%;
                background-color: #343a40;
                overflow-x: hidden;
                padding-top: 20px;
            }


            .main {
                padding: 0px 10px;
            }

            @media screen and (max-height: 450px) {
                .sidenav {padding-top: 15px;}
            }

            @media screen and (max-width: 450px) {
                .login-form{
                    margin-top: 10%;
                }

                .register-form{
                    margin-top: 10%;
                }
            }

            @media screen and (min-width: 768px){
                .main{
                    margin-left: 40%; 
                }

                .sidenav{
                    width: 40%;
                    position: fixed;
                    z-index: 1;
                    top: 0;
                    left: 0;
                }

                .login-form{
                    margin-top: 80%;
                }

                .register-form{
                    margin-top: 20%;
                }
            }


            .login-main-text{
                margin-top: 20%;
                padding: 60px;
                color: #fff;
            }

            .login-main-text h2{
                font-weight: 300;
            }

            .btn-black{
                background-color: #343a40 !important;
                color: #fff;
            }
        </style>
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
                            <input type="text" class="form-control" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-black">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: loginok.php");
}

if (isset($_POST["invio"])) {
    require 'conn.php';
    if (!isset($_POST["username"]) || empty($_POST["username"])) {
        echo "Inserisci username";
        exit();
    } else {
        $username = $_POST["username"];
        $username = stripslashes($username);
        $username = mysqli_real_escape_string($conn, $username);
    }
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        echo "Inserisci Password";
        exit();
    } else {
        $password = $_POST["password"];
        $password = stripslashes($password);
        $password = mysqli_real_escape_string($conn, $password);
        $passmd5 = md5($password);
    }
    $sql = "SELECT * FROM $tab_name WHERE username='$username' AND password='$passmd5'";
    $result = $conn->query($sql);
    if (!$result) {
        echo "Errore della query: " . $conn->error . ".";
    } else {
        $conta = $result->num_rows;
        if ($conta == 1) {
            session_start();
            $_SESSION["username"] = $username;
            header("Location: loginok.php");
        } else {
            echo "Identificazione non riuscita";
        }
    }
}
?>
