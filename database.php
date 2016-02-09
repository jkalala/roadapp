class MySQLDatabase{

 private $conn;
 public $last_query;
 private $magic_quotes_active;
 private $real_escape_string_exists;
 
 function __construct(){
   $this->open_connection();
   $this->magic_quotes_active = get_magic_quotes_gpc();
   $this->real_escape_string_exists = function_exists("mysql_real_escape_string");
   
   }
  
public function open_connection() {

 $this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error);
} 
echo "Connected successfully";

$db_select = mysqli_select_db($this->conn, DB_NAME);
   if(!$db_select){
    die("Database selection failed: " .mysqli_connect_error());
	}
	
	return $this->conn;
 }
 
public function close_connection(){
 if(isset($this->conn)){
    mysqli_close($this->conn);
	unset($this->conn);
	}
  }


public function query($sql){



$this->last_query = $sql;

$result = mysqli_query($this->conn,$sql);
$this->confirm_query($result);
return $result;
  
 }
public function escape_value($value) {
  
    if($this->real_escape_string_exists) {
    if($this->magic_quotes_active) { $value = stripslashes($value);}
     $value = mysql_real_escape_string($value);
	 }else{
	 if(!$this->magic_quotes_active)
	      {$value = addslashes ($value);}
	 }
	return $value;
 }

public function fetch_array($result_set){
  return mysqli_fetch_array($result_set);
  }

 public function fetch_row($result_set){
  return mysqli_fetch_row($result_set);
  }


public function num_rows($result_set){
  return mysqli_num_rows($result_set);
  }
public function insert_id(){
   return mysqli_insert_id($connection);
   }
 public function affected_rows(){
   return mysqli_affected_rows($connection);
   }
private function confirm_query($result){
  if(!$result){
    $output = "Database query failed: " . mysqli_connect_errno() . "<br /><br />";
	$output .= "Last SQL query: " .$this->last_query;
    die($output);
	}
  }
}

$database = new MySQLDatabase();

?>
