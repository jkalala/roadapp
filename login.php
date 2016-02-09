


<?php require_once("database.php");?>
<?php require_once("functions.php"); ?>
<?php require_once("form_functions.php"); ?>

<?php 



 
     // VALIDAR FORMULARIO 
     if (isset($_POST['submit'])) { // formulario foi enviado
       $errors = array();

      // validar os dados do formulario

       $required_fields = array('nome', 'senha');
       $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

       $fields_with_lengths = array('nome' => 30, 'senha' => 30);
       $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
    
       $usuario =trim(mysql_prep($_POST['nome']));
       $senha =trim(mysql_prep($_POST['senha']));
       $hashed_password = sha1($senha);
      
       if ( empty($errors)){
       // check database to see if username and the hashed password exist there.
       $query = "SELECT ID , usuario ";
       $query .= "FROM usuarios ";
       $query .= "WHERE usuario = '{$usuario}'";
       $query .= "AND hashed_password = '{$hashed_password}'";
       $query .= "LIMIT 1";
       $result_set = $database->query($query);
        confirm_query($result_set);
       if ($database->num_rows($result_set) ==1) {
           
        // username/password authenticated
        // and only 1 match
         $found_user = $database->fetch_array($result_set);
         $_SESSION['user_id'] = $found_user['ID'];
         $_SESSION['usuario'] = $found_user['usuario'];
          redirect_to ("index.html");
    
       } else {

        // username/password combo was not found in the database
          $message ="Usuario/senha incorecto.<br/>
               Please make sur your caps lock key is off and try again.";
       }
   } else {
 
     if (count($errors) == 1) {
        $message ="Aconteceu 1 erro no formulario.";
     } else {
        $message = "Houve " . count($errors) ."erros no formulario. ";
        }
    }


   } else { // Form has not been submitted
       
       if (isset($_GET['logout']) && $_GET['logout'] ==1 ) {
       $message ="You are now loggout";
        }

       $usuario = "";
       $senha = "";
       }
?>


<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sistema de Contraordernacao</title>
	
	
</head>
<body>

	

 
</head>
<body>
	
		<form action="login.php" method="POST" >

		
		
				<p>
					<label for="login-username">Usuario</label>
					<input type="text"  name="nome" value="<?php echo htmlentities($usuario); ?>"  autofocus />
				</p>

				<p>
					<label for="login-password">Palavra-passe</label>
					<input type="password"  name="senha" value="<?php echo htmlentities($senha); ?>"  />
				</p>
				
				<p><a href="#">Esqueceste-te da tua palavara-passe?</a>.</p>
				
				<input type="submit" name="submit" value= "Iniciar sessão"   />

	

		
		</form>
		
		
<div id="wrapper">

	<form name="login-form" class="login-form" action="" method="post">
	
		<div class="header">
		<h1>Login Form</h1>
		<span>Fill out the form below to login to my super awesome imaginary control panel.</span>
		</div>
	
		<div class="content">
		<input name="username" type="text" class="input username" placeholder="Username" />
		<div class="user-icon"></div>
		<input name="password" type="password" class="input password" placeholder="Password" />
		<div class="pass-icon"></div>		
		</div>

		<div class="footer">
		<input type="submit" name="submit" value="Login" class="button" />
		<input type="submit" name="submit" value="Register" class="register" />
		</div>
	
	</form>

</div>
<div class="gradient"></div>

		


</body>
</html>
