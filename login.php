<?php require_once("session.php");?>
<?php require_once("database.php");?>
<?php require_once("functions.php"); ?>
<?php 

if ($session->is_logged_in()) {
     redirect_to("index.php");
  }

     include_once("form_functions.php");
 
     // VALIDAR FORMULARIO 
     if (isset($_POST['submit'])) { // formulario foi enviado
       $errors = array();

      // validar os dados do formulario

       $required_fields = array('usuario', 'senha');
       $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

       $fields_with_lengths = array('usuario' => 30, 'senha' => 30);
       $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
    
       $usuario =trim(mysql_prep($_POST['usuario']));
       $senha =trim(mysql_prep($_POST['senha']));
       $hashed_password = sha1($senha);
      
       if ( empty($errors)){
       // check database to see if username and the hashed password exist there.
       $query = "SELECT ID , usuario ";
       $query .= "FROM usuarios ";
       $query .= "WHERE usuario = '{$usuario}'";
       $query .= "AND hashed_password = '{$hashed_password}'";
       $query .= "LIMIT 1";
       $result_set = mysql_query($query);
       confirm_query($result_set);
       if (mysql_num_rows($result_set) ==1) {
           
        // username/password authenticated
        // and only 1 match
         $found_user = mysql_fetch_array($result_set);
         $_SESSION['user_id'] = $found_user['ID'];
         $_SESSION['usuario'] = $found_user['usuario'];
          redirect_to ("dashboard.php");
    
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
	<title>Admin - Login ao SISTEMA</title>
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
  
</head>
<body>

	
		
		<div class="page-full-width cf">
	
			<div id="login-intro" class="fl">
			
				<h1>Sistema de Construção de Horários</h1>
				<h5>Entrar os teus credenciais de administrador abaixo</h5>
			
			</div> <!-- login-intro -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 39px height. -->
			<a href="#" id="company-branding" class="fr"><img src="" alt="" /></a>
			
		</div> <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
	
		<form action="login2.php" method="POST" id="login-form">
		
			<fieldset>

				<p>
					<label for="login-username">Usuário</label>
					<input type="text" id="login-username" name="usuario" value="<?php echo htmlentities($usuario); ?>" class="round full-width-input" autofocus />
				</p>

				<p>
					<label for="login-password">Palavra-passe</label>
					<input type="password" id="login-password" name="senha" value="<?php echo htmlentities($senha); ?>" class="round full-width-input" />
				</p>
				
				<p><a href="#">Esqueceste-te da tua palavara-passe?</a>.</p>
				
				<input type="submit" name="submit" value= "Iniciar sessão" class="button round blue image-right ic-right-arrow"   />

			</fieldset>

			<br/><div class="information-box round">Clica apenas no botão "INICIAR SESSÃO" para continuar.</div>

		</form>
		
	</div> <!-- end content -->
	
	
	
	<!-- FOOTER -->
	<div id="footer">

		<p>&copy; Copyright 2013 <a href="#">Joaquim Kalala</a>. Todos os direitos reservados.</p>
		<p><strong>Sistema de Construção de Horários</strong> desenhado por <a href="http://www.adipurdila.com">Joaquim Kalala</a></p>
	
	</div> <!-- end footer -->

</body>
</html>
