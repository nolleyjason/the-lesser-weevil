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