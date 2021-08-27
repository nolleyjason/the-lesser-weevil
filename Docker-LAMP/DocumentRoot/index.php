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

class orderGroup {
  public $groupName;
  public $groupOrders = array();

  public function __construct($groupName, $groupOrders){
    $this->groupName = $groupName;
    $this->groupOrders = $groupOrders;

  }
};

$report = array();
$candy = array();
$calls = array();
$referred = array();
$signature = array();
$misc = array();

function sortResults($res)
{
  global $report;
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

  array_push($report,new orderGroup("Candy",$candy));
  array_push($report,new orderGroup("Calls",$calls));
  array_push($report,new orderGroup("Referrals",$referred));
  array_push($report,new orderGroup("Signatures",$signature));
  array_push($report,new orderGroup("Misc",$misc));

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

foreach ($report as $r) {
  $orderList = json_decode(json_encode($r->{'groupOrders'},true));
  $numOrders = count($orderList);
  echo "<table><tr>".$r->{"groupName"}." - ". $numOrders ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
  if ($numOrders > 0) {
    
    foreach ($orderList as $o) {
      $order = json_decode(json_encode($o),true);
      echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<tr><td>0 results</td></tr></table>";
  }
}

$conn->close();

  
?>
</body>
</html>