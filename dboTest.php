<?php

      $servername = "127.0.0.1";
      $username = "server";
      $password = "password";
      $dbname = "socialdock";
      
$db = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8', ''.$username.'', ''.$password.'');

$stmt = $db->query('SELECT * FROM posts');
 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['content'];
}
function sendMessage($message){
  $affected_rows = $db->exec("INSERT INTO posts ('content') VALUES ('".$message."');");
  
}
if(isset($_POST['body'])){
  sendMessage($_POST['body']);
}
?>
<html>
  <head>
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/betastyle.css">
  <script>
    function sendMessage(){
      var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("message").value = "";
    
    }
}
xmlhttp.open("POST","dboTest.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("body=" + document.getElementById("message").value + "&user="+ user);
xmlhttp.send();
  
    }
  </script>
  </head>
  <body>
    <div class="input-group">
      
      <input type="text" name="body" class="form-control" placeholder="Message" id="message" onkeydown="if (event.keyCode == 13) document.getElementById('sendButton').click()">
      <span class="input-group-btn">
      <button class="btn btn-default" type="button" value="Send Message" onclick="sendMessage()" id="sendButton">Send Message</button>
      </span>
      </div>
  </body>
</html>