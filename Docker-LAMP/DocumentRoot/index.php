<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
.orderGroup {
  margin-top:20px;
  margin-bottom:20px;
}
</style>
</head>
<?php

include 'functions/find-date-in-string.php';
include 'functions/sortResults.php';
include 'functions/Data.php';


include 'models/orders.php';



$result = getOrders();
sortResults($result);

foreach ($report as $r) {
  $orderList = json_decode(json_encode($r->{'groupOrders'},true));
  $numOrders = count($orderList);
  echo "<hr><div class='orderGroup'><table><tr>".$r->{"groupName"}." - ". $numOrders ." Records</tr><tr><th>orderid</th><th>comments</th><th>shipdate_expected</th></tr>";
  if ($numOrders > 0) {
    
    foreach ($orderList as $o) {
      $order = json_decode(json_encode($o),true);
      echo "<tr><td>".$order["orderid"]."</td><td>".$order["comments"]."</td><td>".$order["shipdate_expected"]."</td></tr>";
    }
    echo "</table></div>";
  } else {
    echo "<tr><td></td></tr></table></div>";
  }
}

$conn->close();

  
?>
</body>
</html>