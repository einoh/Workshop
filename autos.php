<?php
session_start();

$dbopts = parse_url(getenv('DATABASE_URL'));
define( "DB_DSN", 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"] );
define( "DB_HOST", $dbopts["host"] );
define( "DB_USERNAME", $dbopts["user"] );
define( "DB_PASSWORD", $dbopts["pass"]);

if((!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) || empty($_GET['name']))
    die("Name parameter missing");

$username = $_SESSION['username'];
$_SESSION['error'] = [];

class ConnectDB{
    protected $conn;
    public function __construct()
    {
        try{
            $this->conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("CREATE TABLE IF NOT EXISTS autos (
                auto_id SERIAL,
                make VARCHAR(128) NULL,
                year INT NULL,
                mileage INT NULL,
                PRIMARY KEY (auto_id));");
        }catch (PDOException $e){
            die("DB ERROR: ". $e->getMessage());
        }
    }
}

class Auto extends ConnectDB{
    public function addAuto($post)
    {
        $query = $this->conn->prepare("INSERT INTO autos (make,year,mileage) VALUES (:mk, :yr, :mi)");
        $query->execute([
            ':mk' => htmlentities($post["make"]),
            ':yr' => htmlentities($post["year"]),
            ':mi' => htmlentities($post["mileage"])
        ]);
        return $query->rowCount();
    }

    public function getAllAutos()
    {
      return $this->conn->query("SELECT * FROM autos")->fetchAll();
    }
}

$auto = new Auto;
$all_autos = $auto->getAllAutos();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if(empty($_POST['make']))
    $_SESSION['error'][] = "Make is required";

  if(empty($_POST['mileage']))
  $_SESSION['error'][] = "Mileage is required";

  if(empty($_POST['year']))
  $_SESSION['error'][] = "Year is required";

  if(!empty($_POST['mileage']) && !is_numeric($_POST['mileage']))
    $_SESSION['error'][] = "Mileage must be numeric";

  if(!empty($_POST['year']) && !is_numeric($_POST['year']))
    $_SESSION['error'][] = "Year must be numeric";

  if(empty($_SESSION['error']))
    $success_save = $auto->addAuto($_POST);
  
  $all_autos = $auto->getAllAutos();

}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"/>
    <title>Bagasbas, Angelo Dan F. - Automobiles and Databases | AutoDB</title>
  </head>
  <body>

<div class="container auto-container">
  <div class="row">
    <div class="col">
      <h1>Tracking Autos for <?= $username ?></h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?name=" .urlencode($username)?>" method="POST">

<?php if(!empty(($_SESSION['error']))): ?>
<div class="alert alert-danger">
  <?php foreach ($_SESSION['error'] as $error): ?>
    <span><?php echo $error; ?></span><br>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if(isset($success_save) && ($success_save == 1)) {?>
<div class="alert alert-success" role="alert">
  Record Inserted.
</div>
<?php } ?>

  <div class="form-row">
    <div class="form-group col-md-5">
      <label for="make">Make</label>
      <input type="text" class="form-control" placeholder="Make" name="make">
    </div>
    <div class="form-group col-md-3">
      <label for="inputPassword4">Year</label>
      <input type="text" class="form-control" placeholder="Year" name="year">
    </div>
    <div class="form-group col-md-3">
      <label for="mileage">Mileage</label>
      <input type="text" class="form-control" placeholder="Mileage" name="mileage">
    </div>
    <div class="form-group col-md-1">
      <label for="submit">&nbsp;</label>
      <button type="submit" class="btn btn-primary btn-block">Add</button>
    </div>
  </div>



</form>


<h1>Automobiles</h1>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Make</th>
      <th scope="col">Year</th>
      <th scope="col">Mileage</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($all_autos as $all_auto) { ?>
    <tr>
      <th scope="row"><?= $all_auto["auto_id"] ?></th>
      <td><?= $all_auto["make"] ?></td>
      <td><?= $all_auto["year"] ?></td>
      <td><?= $all_auto["mileage"] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>



    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>
    </div>
  </div>
</div>

    

 </body>
</html>
