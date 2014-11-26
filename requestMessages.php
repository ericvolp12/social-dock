<?php
$servername = "127.0.0.1";
$username = "server";
$password = "password";
$dbname = "socialdock";
// Create connection
global $servername, $username, $password, $dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM posts;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["time"]. "</td>";
        echo "<td>";
        getUserData($row["email"], "firstname");
        echo "</td>";
        //Processes strigns to fix stuff
        $messageText = str_replace("<", "&lt;", $row["content"]);
        $messageText = str_replace(">", "&gt;", $messageText);
        if(strpos($messageText, "http")!==false){
          echo '<td><img src="'.$messageText.'"></td>';
           echo '<td><button onclick="deleteMessage( \''. substr($row["time"], 0, $row["time"].length -1) .'\')" class="close">&times;</button></td></tr>';
        }else{
        echo "<td>" .$messageText . "</td>";
        echo '<td><button onclick="deleteMessage( \''. substr($row["time"], 0, $row["time"].length -1) .'\')" class="close">&times;</button></td></tr>';
        }
    }
} else {
    echo "0 results postData:" . $hashedEmail;
}
$conn->close();


function getUserData($hash, $cat){
  global $servername, $username, $password, $dbname;
  $conn1 = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
} 

$sql1 = "SELECT * FROM email WHERE hash='".$hash."';";

$result1 = $conn1->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        echo $row1[$cat];
    }
} else {
    echo "0 results";
}
$conn1->close();
}
?>