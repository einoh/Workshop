<?php
  session_start();

  $_SESSION['error'] = [];

  if((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true))
      header("Location:game.php?name=".urlencode($_SESSION['username']), true, 302);

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(empty($_POST['username']))
      $_SESSION['error'][] = "Username is empty";

    if(empty($_POST['password']))
      $_SESSION['error'][] = "Password is empty";

    if(!empty($_POST['username']) && (!($_POST['username'] == 'username')))
      $_SESSION['error'][] = "Username is incorrect";

    if(!empty($_POST['password']) && (!(md5($_POST['password']) == md5('password'))))
      $_SESSION['error'][] = "Password is incorrect";

    if(empty($_SESSION['error'])){
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['username'] = $_POST['username'];
      header("Location:game.php?name=".urlencode($_POST['username']), true, 302);
    }
  } 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Chemical Developments">
    <meta name="author" content="Nicanor Nuñez IV">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body style="background-color: #cecece;">
    <!-- Username: username Password: password -->
    <div class="container">
      <div style="background-color:White; max-width: 400px; padding: 15px; margin: 0 auto; margin-top:40px; margin-bottom:20px; border-radius: 8px; box-shadow: 0 4px 6px 1px rgba(50, 50, 50, 0.14); box-sizing: border-box;">
        <center>
            <h2>Rock Paper Scissor Game</h2>
        </center>
      </div>
      <div style="background-color:White; max-width: 350px; padding: 15px; margin: 0 auto; margin-top:40px; margin-bottom:20px; border-radius: 8px; box-shadow: 0 4px 6px 1px rgba(50, 50, 50, 0.14); box-sizing: border-box;">
          <center>
            <h4>Please Log-in</h4>
          </center>
          <br>
          <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
            <?php if(!empty(($_SESSION['error']))): ?>
            <div class="alert alert-danger">
              <?php foreach ($_SESSION['error'] as $error): ?>
                <span><?php echo $error; ?></span><br>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <input type="text" class="form-control" id="username" placeholder="Username" name="username"><br>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password"><br>
            <input type="submit" class="btn btn-primary" name="submit" value="Login"/>
          </form>
          <br>
          <p>Password hint : View source and find a password hint in the HTML Code comments.</p>
      </div>
    </div>
  </body>
</html>
