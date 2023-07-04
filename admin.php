<?php
  ini_set("display_errors", 1);
  include 'connection.php';
  session_start();

  if(isset($_SESSION['username'])){
    $un_temp = $_SESSION['username'];

    $query="SELECT * FROM users WHERE username='$un_temp'";
    $result=$connection->query($query);

    if(!$result) {
      echo "Connection failed.";
      die($connection->error);
    }
    else if($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_NUM);
      $result->close();

    }
    if($row[6]==='admin'){
      echo "You are in the Admin Page.";
      //check if adding a new user
      if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['first']) && isset($_POST['last']) && isset($_POST['auth'])){
        $uw = $_POST['username'];
        $pw = $_POST['password'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $auth = $_POST['auth'];
        $check = false;

        //check if username is taken
        $query="SELECT * FROM users WHERE username='$uw'";
        $result=$connection->query($query);

        if(!$result) {
          echo "Add Failed.";
          die($connection->error);
        }

        else if($result->num_rows > 0) {
            echo "Username is already taken.";
            $check = true;
        }
        $result->close();
          //add new user into DB
        if(!$check){
          //salt and hash password
          $salt = "pg!@";
          $newpw = hash('ripemd160', "$uw$pw$salt");

          $query2="INSERT INTO users VALUES('$uw', '$newpw', '$first', '$last', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$auth')";
          $result2=$connection->query($query2);

          if(!$result2) {
            echo "Add Failed.";
            die($connection->error);
          }
          else echo "$first $last was added.";
        }
      }


?>
      <!--Form to add users -->
      <form action = "http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/admin.php" method="post"><pre>
        Username <input type="text" name= "username">
        Password <input type="text" name= "password">
           First <input type="text" name= "first">
            Last <input type="text" name= "last">
   Authorization <select name = "auth" size = "1">
          <option value = "user">User</option>
          <option value = "admin">Admin</option>
        </select>
        <input type = "submit" value="add">
      </pre></form>

<?php
      //display users if view button pressed
      if(isset($_POST['view'])){

        $query2 = "SELECT * FROM users";
        $result2= $connection->query($query2);

        if(!$result2){
          echo "Connection Error";
          die($connection->error);
        }

        $row2 = $result2->num_rows;
        echo "<table border = '1'><tr> <th>Username </th> <th>Password  </th> <th>First Name  </th> <th>Last Name  </th> <th>Time acct was created </th> <th>Last Login  </th> <th>Authorization  </th></tr>";

        for($j = 0; $j <$row2; ++$j){
          $result2->data_seek($j);
          $row2 = $result2->fetch_array(MYSQLI_NUM);

          echo"<tr>";
          for($k = 0; $k <7; ++$k) echo "<td>$row2[$k]</td>";
          echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
      }
      else{
?>
          <!-- View button -->
          <html>
          <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/admin.php" method= "post">
            <input type = "hidden" name = "view" value = "yes"/>
            <input type="submit" value="View" />
          </form>
      <?php
      }
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

  else {
    echo "<br>You need to be logged in as an administrator to view this page.<br>";
?>
    <html>
    <form action="http://cs5339.cs.utep.edu/mchacon3/Assignment3Fall17/signin.php">
      <input type="submit" value="Login" />
    </form>
<?php
  }
?>
