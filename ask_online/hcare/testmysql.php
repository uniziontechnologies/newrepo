xample (MySQLi Object-oriented)
<?php
$servername = "localhost";
$username = "unizionh_hcare";
$password = "drAIubin9fwy";
$dbname = "unizionh_blessing_hcare_chungathara";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else{
	echo "okkkkkkkkkkkkkkkkkkkkkkkkkkk";
}

$conn->close();
?>