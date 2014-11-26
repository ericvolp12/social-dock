<?php
session_start();
require 'sqlFunctions.php';
if($_SESSION['fromLogin'] != "true"){
   //send them back
   $_SESSION['redirected'] = "true";
   header("Location: login.html");
}
else{
    if ($_SESSION['timeout'] + 30 * 60 < time()) {
      $_SESSION['timedOut']= true;
     header("Location: login.html");
  } else {
     // session ok
  
     //Declaring Global Variables
     $_SESSION['timeout'] = time();
       $servername = "127.0.0.1";
      $username = "server";
      $password = "password";
      $dbname = "socialdock";
      


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
}
}
?>

<html>
<head>
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <script type="text/javascript"> user = <?php echo json_encode($_SESSION['user']);  ?></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>
		Community Message Board
	</title>
	
<script type="text/javascript">
board = "<?php echo $_SESSION['board']; ?>";
lastResponse = '';

function refreshMessages(){
 $.get('requestMessages.php', function(response){
   if(lastResponse != response){
     lastResponse = response;
   $('#tableBody').html(response);
   }
 });
}
function sendMessage(){
   $.post('sendMessage.php', ($('#message').serialize()+"&user="+user+"&board="+board), function(){
     $('#message').val('');
     refreshMessages();
   });
   
}
function sendImage(){
  $.post('sendMessage.php', ($('#imageUrl').serialize()+"&user="+user+"&board="+board), function(){
     $('#imageUrl').val('');
     refreshMessages();
   });
}
setInterval(function() {
   refreshMessages();
   refreshPM();
}, 5000); //5 seconds

function getUsers(){
 $.get('requestUsers.php', function(response){
   $('#userList').html(response);
 });
}
function selectUser(selectedUser, selectedHash){
  $('#userChooser').html(selectedUser);
  $('#userChooser').val(selectedHash);
}
function deleteMessage(timestamp){
   $.post('deleteMessage.php', ("time="+ timestamp +"&delete=true"), function(response){
     console.log(response);
     refreshMessages();
   });
   }
function deletePM(timestamp){
   $.post('deleteMessage.php', ("time="+ timestamp +"&delete=true&isPM=true"), function(response){
     console.log(response);
     refreshMessages();
   });
   }
function sendPM(){
  pm = $("#privateMessage").val();
  $.post('sendMessage.php', ("pm="+pm+"&target="+$("#userChooser").val()), function(response){
     $('#privateMessage').val('');
     console.log(response);
     refreshPM();
   });
}
function refreshPM(){
   $.get('requestPM.php', function(response){
   if(lastResponse != response){
     lastResponse = response;
     console.log("Response is not the same.");
   $('#pmTableBody').html(response);
   }
 });
}
	</script>
</head>
<body>
  <div class="jumbotron">
    <img src="https://i.imgur.com/kfvPsvT.png" style="max-width:50%;">
<h2 id="titleThing">Community Messageboard</h2>
<h3>Welcome, <?php getUserData($_SESSION['user'], "firstname");?>!</h3>
</div>
<div class="col-md-6 col-md-offset-3" style="text-align:center;">
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h3><b>Community Chat Board</b></h3></div>

  <!-- Table -->
  <table class="table" style="word-wrap: break-word">
    <thead>
      <tr>
        
        <td style="text-align:left;">Time</td>
        <td style="text-align:left;">User</td>
        <td style="text-align:left;">Message</td>
        <td style="text-align:right;">Delete</td>
      </tr>
      </thead>
      <tbody id="tableBody">
      <script>refreshMessages();</script>
    </tbody>
  </table>
  </div>
  <a name="mid"></a>
  <center>
  <div style="color:white;">
<div class="panel panel-default">
  <div class="panel-heading"><h4><b>Post to the Community Board</b></h4></div>
 <div class="input-group">
      
      <input type="text" name="body" class="form-control" placeholder="Message" id="message" onkeydown="if (event.keyCode == 13) document.getElementById('sendButton').click()">
      <span class="input-group-btn">
      <button class="btn btn-default" type="button" value="Send Message" onclick="sendMessage()" id="sendButton">Send Message</button>
      </span>
      </div>
      <div class="input-group">
      <input type="text" name="body" class="form-control" placeholder="Image URL" id="imageUrl" onkeydown="if (event.keyCode == 13) document.getElementById('sendImage').click()">
      <span class="input-group-btn">
      <button class="btn btn-default" type="button" value="Send Image" onclick="sendImage()" id="sendImageButton">Send Image</button>
      </span>
    </div><!-- /input-group -->

</div></center>
  <center>
  <div style="color:white;">
    <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading"><h3><b>Private Messages</b></h3></div>

  <!-- Table -->
  <table class="table" style="word-wrap: break-word">
    <thead>
      <tr>
        
        <td style="text-align:left;">Time</td>
        <td style="text-align:left;">From</td>
        <td style="text-align:left;">Message</td>
        <td style="text-align:right;">Delete</td>
      </tr>
      </thead>
      <tbody id="pmTableBody">
      <script>refreshPM();</script>
    </tbody>
  </table>
  </div>
<div class="panel panel-default">
  <div class="panel-heading"><h4><b>Send a Private Message</b><h4></div>
 <div class="input-group">
      <div class="input-group-btn">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="userChooser">User <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu" id="userList">
          <script>getUsers();</script>
        </ul>
        </div>
      <input type="text" name="body" class="form-control" placeholder="Message" id="privateMessage" onkeydown="if (event.keyCode == 13) document.getElementById('sendPM').click()">
      <span class="input-group-btn">
      <button class="btn btn-default" type="button" value="Send Message" onclick="sendPM()" id="sendPM">Send Message</button>
      </span>
    </div><!-- /input-group -->

</div></center>

  <a name="bottom"></a>
  <center>
</div>
</div>
</div>
</div>
</body>
</html>