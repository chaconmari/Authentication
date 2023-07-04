<?php
  include 'connection.php';
  echo "You are in the Main Page.<br>";

  //clossing session
  if(isset($_POST['logout'])){
    session_start();
    $_SESSION = array();
    session_destroy();
  }

  session_start();
  if(isset($_SESSION['username'])){
    $un_temp = $_SESSION['username'];

    $query="SELECT * FROM users WHERE username='$un_temp'";
    $result=$connection->query($query);

    if(!$result) {
      die($connection->error);
    }
    else if($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();
    }
    if($row[6]==='user'){
?>
      <html>
        <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/user.php">User Page</a><br>
        <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php" method="post">
          <input type="hidden" name ="logout" value="yes">
          <input type="submit" value="Logout">
        </form>
      </html>
<?php
      }
     else if($row[6]==='admin'){
?>
       <html>
         <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/admin.php">Admin Page</a><br>
         <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/user.php">User Page</a><br>
         <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php" method="post">
           <input type="hidden" name ="logout" value="yes">
           <input type="submit" value="Logout">
         </form>
       </html>
<?php
     }
  }
  else {
?>
    <html>
    <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/signin.php">
      <input type="submit" value="Login" />
    </form>
<?php
  }
?>
