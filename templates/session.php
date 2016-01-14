<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		require "connect.php";
		
		$user = $_POST['username'];
		$pass = $_POST['pass'];
		$user = trim($user);		
		$pass = trim($pass);

		$pass = md5($pass);
		
		if (empty($user)) {
			$_SESSION['error'] = "No ha enviado un nombre de usuario!";
		}
		else {
			if (empty($pass)) {
				$_SESSION['error'] = "No ha enviado una contraseña!";
			}
			else {				
				$result = mysqli_query($link, "SELECT idUser, username FROM user WHERE username = '{$user}' AND password = '{$pass}'");	
								
				if($row = mysqli_fetch_array($result)) {
					$_SESSION['idUser'] = $row['idUser'];
					$_SESSION['username'] = $row["username"];
					
					header("Location: index.html");
				}
				else {
					$_SESSION['error'] = "Usuario o contraseña incorrecta!";
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
    	<div class="col-md-3"></div>
    	<div class="col-md-6">
        	<form class="form-horizontal" action="session.php" method="post">
       	 		<div class="form-group">
                	<div class="col-md-offset-1 col-md-10">
                        <h3>Iniciar sesión</h3>
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
                        <input type="text" class="form-control" name="username" id="username" placeholder="Ingrese su nombre de usuario" autofocus required>
                        <br>
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="Ingrese su contraseña" required>
                    </div>
                 </div>                        

                <div class="form-group" align="right">
              		<div class="col-md-offset-1 col-md-10">
    					<button type="submit" class="btn btn-sm btn-success">Iniciar sesión</button>
                  	</div>
            	</div>
            </form>
        </div>                    
    </div>
</body>
</html>