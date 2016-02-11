<?php
/*
MySQL PHP Search Exercises by Adam Khoury @ developphp.com
MySQL Database Version Used In the Lessons: 5.1.58
PHP Version Used in the Lessons: 5.2.17
For Code Logic and Code Explanations Watch the Videos
*/
// This script is for auto creating and populating two tables
// needed for the exercises in this series
// ------------------------------------------------
// Force script errors and warnings to show during production only
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to your MySQL database here
include_once("database.php");
// Create the table 1 for storing pages
$sqlCommand = "CREATE TABLE IF NOT EXISTS pages (
               id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
               page_title VARCHAR(255),
               page_body TEXT,
	       page_views INT NOT NULL default '0',
               FULLTEXT (page_title,page_body)
               ) ENGINE=MyISAM";
$query = $database->query($sqlCommand) or die(mysql_error());
echo "<h3>Success creating Pages table</h3>";
// Create the table 2 for storing Blog entries
$sqlCommand = "CREATE TABLE IF NOT EXISTS blog (
               id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
               blog_title VARCHAR(255),
               blog_body TEXT,
	       blog_views INT NOT NULL default '0',
               FULLTEXT (blog_title,blog_body)
               ) ENGINE=MyISAM";
$query = $database->query($sqlCommand) or die(mysql_error());
echo "<h3>Success creating Blog table</h3>";
// Insert dummy data into the pages table
$sqlCommand = "INSERT INTO pages (page_title,page_body) VALUES
              ('PHP Random Number','Learn to generate a random number using PHP blah blah blah'),
              ('Javascript Clock','Build a Javascript digital clock in this tutorial blah blah blah'),
              ('Flash Gallery','Use Actionscript to build a Flash Photo gallery blah blah blah'),
              ('XML RSS FEED','Learn to assemble XML RSS Feeds for your website blah blah blah'),
              ('CSS Shadows','Learn text and container shadow techniques using CSS blah blah blah'),
              ('HTML5 Canvas Tag','Learn how to animate the HTML5 Canvas tag using blah blah blah'),
	      ('PHP Calculator','Learn to build a working calculator using PHP and blah blah blah'),
              ('Flash Website','Learn to create a full flash website template blah blah blah')";
$query = $database->query($sqlCommand) or die(mysql_error());
echo "<h3>Success populating the pages table with data</h3>";
// Insert dummy data into the blog table
$sqlCommand = "INSERT INTO blog (blog_title,blog_body) VALUES
              ('Trip to Disney World','Disney world would have been fun if I were 10 blah blah blah'),
              ('Refrigeration School','I graduated school finally after blah blah blah'),
              ('Big Giant Doodoo','In the bathroom today I made the biggest doodoo blah blah blah'),
              ('New Pet Bird','Today I got a new bird that repeats everything blah blah blah'),
              ('Pet Bird Died','My cat ate my bird today so as punishment I blah blah blah')";
$query = $database->query($sqlCommand) or die(mysql_error());
echo "<h3>Success populating the blog table with data</h3>";
?>
