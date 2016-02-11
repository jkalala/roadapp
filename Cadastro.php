<?php require_once("database.php");?>
<?php require_once("functions.php"); ?>
<?php require_once("form_functions.php"); ?>






<!DOCTYPE HTML> 
<html>
<head>
<title>REGISTO DE INFRACOES DO CONDUTOR</title>
<style>
.error {color: #FF0000;}
</style>
<link rel="stylesheet" href="forms.css" >
</head>
<body> 

<?php
// define variables and set to empty values
$cartaErr = $biErr = $nomeErr = $nascErr = $crimeErr = $penaErr = "";
$carta =    $bi =    $nome =    $nasc =    $crime =    $pena = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["carta"])) {
     $cartaErr = "Numero da carta por favor";
   } else {
     $carta = test_input($_POST["carta"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$carta)) {
       $cartaErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["bi"])) {
     $biErr = "O numero de bilhete de indentidade exigido";
   } else {
     $bi = test_input($_POST["bi"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$bi)) {
       $biErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["nome"])) {
     $nomeErr = "Nome do condutor e exigido";
   } else {
     $nome = test_input($_POST["nome"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$nome)) {
       $nomeErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["nasc"])) {
     $nacsErr = "Data de nascimento aqui";
   } else {
     $nasc = test_input($_POST["nasc"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$nasc)) {
       $nascErr = "Only letters and white space allowed"; 
     }
   }
   
   if (empty($_POST["crime"])) {
     $crimeErr = "Infracao cometida";
   } else {
     $crime = test_input($_POST["crime"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$crime)) {
       $crimeErr = "Only letters and white space allowed"; 
     }
   }
   if (empty($_POST["pena"])) {
     $penaErr = "Pena aplicada";
   } else {
     $pena = test_input($_POST["pena"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$pena)) {
      $penaErr = "Only letters and white space allowed"; 
     }
   }
   
   
   
   
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
   } else {
     $email = test_input($_POST["email"]);
     // check if e-mail address is well-formed
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $emailErr = "Invalid email format"; 
     }
   }
     
  // if (empty($_POST["website"])) {
  //   $website = "";
   //} else {
   //  $website = test_input($_POST["website"]);
     // check if URL address syntax is valid
   //  if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
   //    $websiteErr = "Invalid URL"; 
   //  } 
  // }

 //  if (empty($_POST["comment"])) {
 //    $comment = "";
//   } else {
//     $comment = test_input($_POST["comment"]);
   }

 //  if (empty($_POST["gender"])) {
 //    $genderErr = "Gender is required";
 //  } else {
 //    $gender = test_input($_POST["gender"]);
  // }
//}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}




 
     // VALIDAR FORMULARIO 
     if (isset($_POST['submit'])) { // formulario foi enviado
       $errors = array();

      // validar os dados do formulario

       $required_fields = array('carta', 'bi', 'nome','nasc', 'crime', 'pena');
       $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

       $fields_with_lengths = array('carta' => 15, 'bi' => 15,'nome' => 50, 'nasc' => 15,'e-mail' => 50, 'crime' => 50,'pena' => 50, 'comment' => 100, 'gender' => 30);
       $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
    
       $carta =trim(mysql_prep($_POST['carta']));
       $bi =trim(mysql_prep($_POST['bi']));
	   $nome =trim(mysql_prep($_POST['nome']));
       $nasc =trim(mysql_prep($_POST['nasc']));
	   
	   //$email =trim(mysql_prep($_POST['email']));
       $crime =trim(mysql_prep($_POST['crime']));
	   
	   $pena =trim(mysql_prep($_POST['pena']));
      // $senha =trim(mysql_prep($_POST['comment']));
	  // $usuario =trim(mysql_prep($_POST['gender']));
       
       
      
       if ( empty($errors)){
            $query = " INSERT INTO condutor ( 
                              num_carta, BI, Nome_Condutor, data_nascimento, crime, pena
                          ) VALUES (
                             '{$carta}','{$bi}' ,'{$nome}','{$nasc}','{$crime}','{$pena}'
                          )";
      $result = $database->query($query);
      if ($result){
        $message = "criacao novo usuario bem sucedido.";
       } else {
        $message = "The user could not be created.";
        $message .= "<br />" . mysql_error();
     }
} else {
     if (count($errors) == 1) {
        $message ="Houve 1 erro no formulario.";
     } else {
        $message = "Houve " . count($errors) ."erros no formulario. ";
        }
    }


   } else { // Form has not been submitted

       $carta = "";
	   $bi= "";
       $nome = "";
	   $nasc = "";
	  // $e-mail= "";
       $crime= "";
	   $pena = "";
	  // $comment= "";
      // $gender= "";
	   
       }
?>







<h2 style="center">REGISTO DE INFRACOES DO CONDUTOR</h2>
<p><span class="error">* required field.</span></p>

<div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  <label> Carta de conducao:</label> <input type="text" name="carta">
   <span class="error">* <?php echo $cartaErr;?></span>
   <br><br>
  <label> Bilhete de identidade:</label> <input type="text" name="bi">
   <span class="error">* <?php echo $biErr;?></span>
   <br><br>
   <label>Nome do condutor:</label> <input type="text" name="nome">
   <span class="error">* <?php echo $nomeErr;?></span>
   <br><br>
   <label>Data de nascimento:</label> <input type="text" name="nasc">
   <span class="error">* <?php echo $nascErr;?></span>
   <br><br>
  
   <label>Infracao cometida:</label><input type="text" name="crime">
   <span class="error">* <?php echo $crimeErr;?></span>
   <br><br>
   <label>Pena a aplicar:</label> <input type="text" name="pena">
   <span class="error">* <?php echo $penaErr;?></span>
   <br><br>
   
   
   <label>Comment:</label> <textarea name="comment" rows="5" cols="40"></textarea>
   <br><br>
   <label>Gender:</label>
   <input type="radio" name="gender" value="female">Mulher
   <input type="radio" name="gender" value="male">Homem
   <span class="error">* <?php ?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>
</div>
</body>
</html>



