<?php
$search_output = "";
if(isset($_POST['searchquery']) && $_POST['searchquery'] != ""){
	// run code if condition meets here
}
?>
<html>
<head>
</head>
<body>
<h2>Search the Exercise Tables</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  Search: <input name="searchquery" type="text" size="70" maxlength="88">
  <input name="myBtn" type="submit">
  <br><br>
  Search In:
  <select name="filter1">
    <option value="Whole Site">Whole Site</option>
    <option value="Pages">Pages</option>
    <option value="Blog">Blog</option>
  </select>
</form>
<div>
<?php echo $search_output; ?>
</div>
</body>
</html>
