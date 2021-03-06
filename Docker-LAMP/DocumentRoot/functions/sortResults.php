<?php

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
    /*
    $x_candy = strpos($row["comments"],'candy');
    $x_call = strpos($row["comments"],'call me');
    $x_referred = strpos($row["comments"],'referred');
    $x_signature = strpos($row["comments"],'signature');
    */

    
    $x_candy = preg_match_all('/(^|\W)candy(\W|)/mi',$row["comments"]);
    $x_call = preg_match_all('/((^|\W)call me(\W|)|(^|\W)call(\W|))/mi',$row["comments"]);
    $x_referred = preg_match_all('/((^|\W)referred(\W|)|(^|\W)referral(\W|))/mi',$row["comments"]);
    $x_signature = preg_match_all('/(^|\W)signature(\w|\W|)/mi',$row["comments"]);

    $isDate = find_date($row["comments"]);
    if($isDate !== false)
    {
      $shipDate = $isDate;
      updateExpectedDate($row["orderid"],$shipDate);
    }else {
      $shipDate = '';//$row["shipdate_expected"];
    }


    if($x_candy != 0){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($candy,$z);
    }//else 
    if($x_call != 0){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($calls,$z);
    }//else 
    if($x_referred != 0){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($referred,$z);
    }//else 
    if($x_signature != 0){
      $z = new order($row["orderid"],$row["comments"],$shipDate);
      
      array_push($signature,$z);
    }//else
    if($x_candy == 0 && $x_call == 0 && $x_referred == 0 && $x_signature == 0){
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