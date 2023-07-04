<?php
  include 'connection.php';

  session_start();

  //check if logged in
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

    //display user info
    echo "You are in the User Page.<br><br>";
    echo "Welcome, $row[2] $row[3]!<br><br>
          Username: $row[0]<br>
          Time Account was Created: $row[4]<br>
          Time of Last Login: $row[5]<br>
          Authorization: $row[6]<br><br>";

    if($row[6]==='user'){
?>
      <html>
        <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php">Main Page</a><br>
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
         <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php">Main Page</a><br>
         <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/admin.php">Admin Page</a><br>
         <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php" method="post">
           <input type="hidden" name ="logout" value="yes">
           <input type="submit" value="Logout">
         </form>
       </html>
<?php
     }
  }
  else {
    echo "You need to be logged in as a user/administrator to view this page.";
?>
    <html>
    <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/signin.php">
      <input type="submit" value="Login" />
    </form>
<?php
  }
?>
