<?php
    session_start();

    if((!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) || empty($_GET['name']))
        die("Name parameter missing");

    $username = $_SESSION['username'];

    $jack_n_poi_arr = ['Rock','Paper','Scissors'];
    $jack_n_poi_matrix = [
        0 => ["Tie","You Loose", "You Win"],
        1 => ["You Win", "Tie", "You Loose"],
        2 => ["You Loose", "You Win", "Tie"]
    ];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['play'])){
            $human = $_POST['play'];
            $computer = rand(0,2);
            
            
            if($human == 3){
                $result = '';
                for($i=0;$i<3;$i++){
                    for($j=0;$j<3;$j++)
                        $result .= "Human=". $jack_n_poi_arr[$j]." Computer=".$jack_n_poi_arr[$i] ." Result=". $jack_n_poi_matrix[$j][$i] . "<br>";
                }
            }else{
                $result = $jack_n_poi_matrix[$human][$computer];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rock Paper Scissors Game</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>

<div class="container">
  <div class="row">
    <div class="col-sm" style="margin-top:50px;">
        <h1>Rock Paper Scissors</h1>
        <p>Hello <?= $_GET['name']; ?></p>
        <form class="form-inline" method="POST" action=<?= htmlspecialchars($_SERVER["PHP_SELF"]) . "?name=" .urlencode($username) ?>>

            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="play" name="play">
                <option value="" selected disabled>Choose</option>
                <option value=0>Rock</option>
                <option value=1>Paper</option>
                <option value=2>Scissors</option>
                <option value=3>Test</option>
            </select>

            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <input type="submit" name="submit" class="btn btn-primary" value="Play"/>
            </div>

            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>
            </div>

        </form>

        <hr>

<?php if(isset($_POST['play']) && (!isset($_POST['test']))) : ?>        
    <figure style="background:#f7f7f9;padding:10px;border-radius:5px;">
<pre style="margin-bottom:0">
<?php if($human == 3): ?>
<?php print_r($result); ?>
<?php else: ?>
Human=<?= $jack_n_poi_arr[$human]; ?> Computer=<?= $jack_n_poi_arr[$computer]; ?> Result=<?= $result; ?>
<?php endif; ?>
</pre>
    </figure>
<?php endif; ?>


    </div>
  </div>
</div>

  </body>
</html>
