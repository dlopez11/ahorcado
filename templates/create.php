<?php
	
	session_start();
	require "connect.php";

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$user = $_POST['username'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];

		$user = trim($user);

		$sin_espacios = count_chars($user, 1);
        if(!empty($sin_espacios[32])) {
			$_SESSION['error'] = "El campo <em>nombre usuario</em> no debe contener espacios en blanco!";
        }
		else if(empty($user)) {
            $_SESSION['error'] = "El campo <em>nombre usuario</em> esta vacio!";
        }
		else if(empty($pass)) {
            $_SESSION['error'] = "El campo <em>contraseña</em> esta vacio!";
        }
		else if(empty($pass)) {
            $_SESSION['error'] = "El campo <em>repita contraseña</em> esta vacio!";
        }
		else if($pass != $pass2) {
            $_SESSION['error'] = "Las contraseñas no coinciden!";
        }
        else if(strlen($user) < 7){
			$_SESSION['error'] = "El nombre de usuario no debe ser menor a 7 ni mayor a 10 caracteres";			
		}
		else if(strlen($pass) < 7){
			$_SESSION['error'] = "La contraseña no debe ser menor a 7 ni mayor a 10 caracteres";	
		}
		else{
			$sql = mysqli_query($link, "SELECT username FROM user WHERE username = '{$user}'");

			if(mysqli_num_rows($sql) > 0) {
                $_SESSION['error'] = "El nombre de usuario elegido ya ha sido registrado anteriormente!";
            }
            else{
            	$password = md5($pass);
            	$reg = mysqli_query($link, "INSERT INTO user (username, password) VALUES ('{$user}', '{$password}')");

            	if($reg) {
                    $_SESSION['good'] = "Usuario creado!";
					//header("Location: user.php");
                }else {
                    $_SESSION['error'] = "ha ocurrido un error y no se registraron los datos!";
                }
            }
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="../static/images/favicon-16x16.png" >
	<title>Ahorcado</title>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../static/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../static/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../static/css/normalize.css">
	<link rel="stylesheet" href="../static/css/style.css">
	<script src="../static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div align="center">
		<nav class="MainMenu">
			<ul class="MainMenu-list">
				<li class="MainMenu-item">
					<a class="MainMenu-link" href="index.html">Inicio</a>
				</li>
				<li class="MainMenu-item">
					<a class="MainMenu-link" href="create.php">Agregar Usuario</a>
				</li>
				<li class="MainMenu-item">
					<a class="MainMenu-link" href="close.php">Salir</a>
				</li>			
			</ul>	
		</nav>
    	<div class="col-md-3"></div>
    	<div class="col-md-6">    	
        	<form class="form-horizontal" action="create.php" method="post">
       	 		<div class="form-group">
                	<div class="col-md-offset-1 col-md-10">                		
                        <h3>Crear Usuario</h3>
                        <table class="table center">
							<thead></thead>
							<tbody>
								<tr>
									<td colspan="2" style="text-align: center;">
										<?php if(isset($_SESSION['error']) ) { ?>
											<div class="error">
												<?php 
													echo $_SESSION['error']; 
													unset($_SESSION['error']); 
												?>
											</div>
										<?php } ?>
										<?php if(isset($_SESSION['good']) ) { ?>
											<div class="good">
												<?php 
													echo $_SESSION['good']; 
													unset($_SESSION['good']); 
												?>
											</div>
										<?php } ?>
									</td>
								</tr>
							</tbody>
						</table>
                        <br />
                        <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" autofocus required>
                        <br>
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña" required>
                         <br>
                        <input type="password" class="form-control" name="pass2" id="pass2" placeholder="Repita la contraseña" required>
                    </div>
                 </div>                        

                <div class="form-group" align="right">
              		<div class="col-md-offset-1 col-md-10">
    					<button type="submit" class="btn btn-sm btn-success">Crear</button>
                  	</div>
            	</div>
            </form>
        </div>                    
    </div>
</body>
</html>