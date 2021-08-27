<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<?php


class order {
  public $orderid;
  public $comment;
  public $expected_date;
  public function __construct($orderid, $comments, $shipdate_expected){
    $this->orderid = $orderid;
    $this->comments = $comments;
    $this->shipdate_expected = $shipdate_expected;

  }
};
$candy = array();
$calls = array();
$referred = array();
$signature = array();
$misc = array();

function sortResults($res)
{
  global $candy;
  global $calls;
  global $referred;
  global $signature;
  global $misc;

  while($row = $res->fetch_assoc()) {
    $x_candy = strpos($row["comments"],'candy');
    $x_call = strpos($row["comments"],'call me');
    $x_referred = strpos($row["comments"],'referred');
    $x_signature = strpos($row["comments"],'signature');

    if( $x_candy !== false){
      $z = new order($row["orderid"],$row["comments"],$row["shipdate_expected"]);
      
      array_push($candy,$z);
    }else if($x_call !== false){
      $z = new order($row["orderid"],$row["comments"],$row["shipdate_expected"]);
      
      array_push($calls,$z);
    }else if($x_referred !== false){
      $z = new order($row["orderid"],$row["comments"],$row["shipdate_expected"]);
      
      array_push($referred,$z);
    }else if($x_signature !== false){
      $z = new order($row["orderid"],$row["comments"],$row["shipdate_expected"]);
      
      array_push($signature,$z);
    }else{
      $z = new order($row["orderid"],$row["comments"],$row["shipdate_expected"]);
      
      array_push($misc,$z);
    }
  }
}


$servername = "docker-lamp_db_1";
$username = "web_user";
$password = "theL3ss3rWeevil"; 
$dbname = "sweetwater_test";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sweetwater_test";
$result = $conn->query($sql);
sortResults($result);

echo "<table><tr>Candy - ". count($candy) ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
if (count($candy) > 0) {
  $len = count($candy);
  foreach ($candy as $c) {
    $order = json_decode(json_encode($c),true);
    echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "<tr><td>0 results</td></tr></table>";
}

echo "<table><tr>Calls - ". count($calls) ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
if (count($calls) > 0) {
  $len = count($calls);
  foreach ($calls as $c) {
    $order = json_decode(json_encode($c),true);
    echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>"; 
  }
  echo "</table>";
} else {
  echo "<tr><td>0 results</td></tr></table>";
}

echo "<table><tr>Referred - ". count($referred) ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
if (count($referred) > 0) {
  $len = count($referred);
  foreach ($referred as $c) {
    $order = json_decode(json_encode($c),true);
    echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>";
    
  }
  echo "</table>";
} else {
  echo "<tr><td>0 results</td></tr></table>";
}

echo "<table><tr>Signature - ". count($signature) ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
if (count($signature) > 0) {
  $len = count($signature);
  foreach ($signature as $c) {
    $order = json_decode(json_encode($c),true);
    echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>"; 
  }
  echo "</table>";
} else {
  echo "<tr><td>0 results</td></tr></table>";
}

echo "<table><tr>Misc - ". count($misc) ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
if (count($misc) > 0) {
  $len = count($misc);
  foreach ($misc as $c) {
    $order = json_decode(json_encode($c),true);
    echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>";  
  }
  echo "</table>";
} else {
  echo "<tr><td>0 results</td></tr></table>";
}
$conn->close();

  
?>
</body>
</html>