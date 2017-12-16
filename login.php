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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>




<div class="container">
  <div class="row">
    <div class="col-sm">&nbsp;</div>
    <div class="col-sm ">
      
      <div class="jumbotron" style="margin-top:50px">
        <h1 class="display-6">Please login</h1>
        <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>

          <?php if(!empty(($_SESSION['error']))): ?>
          <div class="alert alert-danger">
            <?php foreach ($_SESSION['error'] as $error): ?>
              <span><?php echo $error; ?></span><br>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Username" name="username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
          </div>
          <input type="submit" class="btn btn-primary" name="submit" value="Login"/>
        </form>
      </div>


    </div>
    <div class="col-sm">&nbsp;</div>
  </div>
</div>



  </body>
</html>