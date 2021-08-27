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

/**
 * Find Date in a String
 *
 * @author   Etienne Tremel
 * *
 * *
 * @modifiedBy This Guy --> fixed a 'non-numeric' bug/issue on line 154 and changed the return value;
 * *
 * *
 * @license  http://creativecommons.org/licenses/by/3.0/ CC by 3.0
 * @link     http://www.etiennetremel.net
 * @version  0.2.0
 *
 * @param string  find_date( ' some text 01/01/2012 some text' ) or find_date( ' some text October 5th 86 some text' )
 * @return mixed  false if no date found else array: array( 'day' => 01, 'month' => 01, 'year' => 2012 )
 */
function find_date( $string ) {
  $shortenize = function( $string ) {
    return substr( $string, 0, 3 );
  };

  // Define month name:
  $month_names = array(
    "january",
    "february",
    "march",
    "april",
    "may",
    "june",
    "july",
    "august",
    "september",
    "october",
    "november",
    "december"
  );
  $short_month_names = array_map( $shortenize, $month_names );

  // Define day name
  $day_names = array(
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday",
    "sunday"
  );
  $short_day_names = array_map( $shortenize, $day_names );

  // Define ordinal number
  $ordinal_number = ['st', 'nd', 'rd', 'th'];

  $day = "";
  $month = "";
  $year = "";

  // Match dates: 01/01/2012 or 30-12-11 or 1 2 1985
  preg_match( '/([0-9]?[0-9])[\.\-\/ ]+([0-1]?[0-9])[\.\-\/ ]+([0-9]{2,4})/', $string, $matches );
  if ( $matches ) {
    if ( $matches[1] )
      $day = $matches[1];
    if ( $matches[2] )
      $month = $matches[2];
    if ( $matches[3] )
      $year = $matches[3];
  }

  // Match dates: Sunday 1st March 2015; Sunday, 1 March 2015; Sun 1 Mar 2015; Sun-1-March-2015
  preg_match('/(?:(?:' . implode( '|', $day_names ) . '|' . implode( '|', $short_day_names ) . ')[ ,\-_\/]*)?([0-9]?[0-9])[ ,\-_\/]*(?:' . implode( '|', $ordinal_number ) . ')?[ ,\-_\/]*(' . implode( '|', $month_names ) . '|' . implode( '|', $short_month_names ) . ')[ ,\-_\/]+([0-9]{4})/i', $string, $matches );
  if ( $matches ) {
    if ( empty( $day ) && $matches[1] )
      $day = $matches[1];

    if ( empty( $month ) && $matches[2] ) {
      $month = array_search( strtolower( $matches[2] ),  $short_month_names );

      if ( ! $month )
        $month = array_search( strtolower( $matches[2] ),  $month_names );

      $month = $month + 1;
    }

    if ( empty( $year ) && $matches[3] )
      $year = $matches[3];
  }

  // Match dates: March 1st 2015; March 1 2015; March-1st-2015
  preg_match('/(' . implode( '|', $month_names ) . '|' . implode( '|', $short_month_names ) . ')[ ,\-_\/]*([0-9]?[0-9])[ ,\-_\/]*(?:' . implode( '|', $ordinal_number ) . ')?[ ,\-_\/]+([0-9]{4})/i', $string, $matches );
  if ( $matches ) {
    if ( empty( $month ) && $matches[1] ) {
      $month = array_search( strtolower( $matches[1] ),  $short_month_names );

      if ( ! $month )
        $month = array_search( strtolower( $matches[1] ),  $month_names );

      $month = $month + 1;
    }

    if ( empty( $day ) && $matches[2] )
      $day = $matches[2];

    if ( empty( $year ) && $matches[3] )
      $year = $matches[3];
  }

  // Match month name:
  if ( empty( $month ) ) {
    preg_match( '/(' . implode( '|', $month_names ) . ')/i', $string, $matches_month_word );
    if ( $matches_month_word && $matches_month_word[1] )
      $month = array_search( strtolower( $matches_month_word[1] ),  $month_names );

    // Match short month names
    if ( empty( $month ) ) {
      preg_match( '/(' . implode( '|', $short_month_names ) . ')/i', $string, $matches_month_word );
      if ( $matches_month_word && $matches_month_word[1] )
        $month = array_search( strtolower( $matches_month_word[1] ),  $short_month_names );
    }
    if(is_numeric($month))
    {
      $month = $month + 1;
    }else {
      $month = '';
    }
    
  }

  // Match 5th 1st day:
  if ( empty( $day ) ) {
    preg_match( '/([0-9]?[0-9])(' . implode( '|', $ordinal_number ) . ')/', $string, $matches_day );
    if ( $matches_day && $matches_day[1] )
      $day = $matches_day[1];
  }

  // Match Year if not already setted:
  if ( empty( $year ) ) {
    preg_match( '/[0-9]{4}/', $string, $matches_year );
    if ( $matches_year && $matches_year[0] )
      $year = $matches_year[0];
  }
  if ( ! empty ( $day ) && ! empty ( $month ) && empty( $year ) ) {
    preg_match( '/[0-9]{2}/', $string, $matches_year );
    if ( $matches_year && $matches_year[0] )
      $year = $matches_year[0];
  }

  // Day leading 0
  if ( 1 == strlen( $day ) )
    $day = '0' . $day;

  // Month leading 0
  if ( 1 == strlen( $month ) )
    $month = '0' . $month;

  // Check year:
  if ( 2 == strlen( $year ) && $year > 20 )
    $year = '19' . $year;
  else if ( 2 == strlen( $year ) && $year < 20 )
    $year = '20' . $year;
/*
  $date = array(
    'year'  => $year,
    'month' => $month,
    'day'   => $day
  );
  */
  $date = $year ."-". $month ."-". $day;

  // Return false if nothing found:
  if ( empty( $year ) || empty( $month ) || empty( $day ) )
    return false;
  else
    return $date;
}

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

    $isDate = find_date($row["comments"]);
    if($isDate !== false)
    {
      $shipDate = $isDate;
    }else {
      $shipDate = '';//$row["shipdate_expected"];
    }


    if( $x_candy !== false){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($candy,$z);
    }else if($x_call !== false){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($calls,$z);
    }else if($x_referred !== false){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($referred,$z);
    }else if($x_signature !== false){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($signature,$z);
    }else{
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
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