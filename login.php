<?php

  session_start();
  $_SESSION['error'] = [];

  
  if((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true))
      header("Location:autos.php?name=".urlencode($_SESSION['username']), true, 302);

  $salt = "XyZzy12*_";
  $stored_hash = "218140990315bb39d948a523d61549b4"; //php123
  $md5 = hash("md5", $salt.$stored_hash);  

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['username']))
      $_SESSION['error'][] = "Username is empty";
    if(empty($_POST['password']))
      $_SESSION['error'][] = "Password is empty";
    if(!empty($_POST['username']) && (!(filter_var($_POST['username'], FILTER_VALIDATE_EMAIL))))
      $_SESSION['error'][] = "Email must have an at-sign (@)";
    if(!empty($_POST['password']) && (!(hash("md5",$salt.md5($_POST['password'])) == $md5)))
      $_SESSION['error'][] = "Password is incorrect";
    if(empty($_SESSION['error'])){
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['username'] = $_POST['username'];
      header("Location:autos.php?name=".urlencode($_POST['username']), true, 302);
    }
  } 

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="bootstrap.min.css" rel="stylesheet" />
    <title>Autos Database</title>
  </head>
  <body>
    </br></br></br></br>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div style="width:250px;">
            <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <input type="text" class="form-control" placeholder="Email" autofocus name="username" style="margin-bottom: 2cm;">
              <input type="password" class="form-control" placeholder="Password" name="password">
              <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign In" />
              <?php if(!empty(($_SESSION['error']))): ?>
                <div class="alert alert-danger">
                  <?php foreach ($_SESSION['error'] as $error): ?>
                    <span><?php echo $error; ?></span><br>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <span>Welcome to Autos Database Web App</span>
        </div>
      </div>
    </div>
  </body>
</html>
