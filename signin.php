<?php
   ini_set("display_errors", 1);
  include 'connection.php';

  if(isset($_POST['username']) && isset($_POST['password'])){
    $un_temp = $_POST['username'];
    $pw_temp = $_POST['password'];

    $query="SELECT * FROM users WHERE username='$un_temp'";
    $result=$connection->query($query);

    //update login time
    $query2="UPDATE users SET timelogin= CURRENT_TIMESTAMP, timecreated=timecreated WHERE username= '$un_temp'";
    $result2=$connection->query($query2);

    if(!$result) {
      die($connection->error);
    }

    else if($result->num_rows) {
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();

      $salt = "pg!@";
      $newpw = hash('ripemd160', "$un_temp$pw_temp$salt");

      if($un_temp == $row[0] && $newpw == $row[1]){
        session_start();
        $_SESSION['username'] = $un_temp;
        echo "You are in the Sign In page.<br>";

        if($row[6] == 'admin'){
  ?>
          <html>
            <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php">Main Page</a><br>
            <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/user.php">User Page</a><br>
            <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/admin.php">Admin Page</a><br>
            <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php" method="post">
              <input type="hidden" name ="logout" value="yes">
              <input type="submit" value="Logout">
            </form>
          </html>
  <?php
        }
        else if($row[6]== 'user'){
  ?>
          <html>
            <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php">Main Page</a><br>
            <a href="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/user.php">User Page</a><br>
            <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/mainpage.php" method="post">
              <input type="hidden" name ="logout" value="yes">
              <input type="submit" value="Logout">
            </form>
          </html>
  <?php
        }
      }
      else echo "Invalid username and/or password.";
    }
    else echo "Invalid username and/or password.";
  }

  else{
  ?>
    <!--login form-->
    <html>
      <form method="post" action ='signin.php'><pre>
        Username <input type="text" name ="username">
        Password <input type="text" name ="password">
        <input type = "submit" value ="Login";
      </pre></form>
    </html>
  <?php
  }
?>
