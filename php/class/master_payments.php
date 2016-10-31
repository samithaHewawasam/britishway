<?php

class master_payments extends database
{

    private $payments_index = array();

    public function index()
    {

        $this->payments_index['new_receipt'] = parent::selectQuery(array(
            "query" => "SELECT IF(count(*) = 0, CONCAT(?,YEAR(CURDATE()),MONTH(CURDATE()),'-',LPAD(1, 5, '0')),
            CONCAT(?,YEAR(CURDATE()),MONTH(CURDATE()),'-',LPAD(count(*) + 1, 5, '0'))) new_receipt
            FROM `master_payments` mp
            WHERE MONTH(`pay_date`) = MONTH(CURDATE()) AND YEAR(`pay_date`) =  YEAR(CURDATE())
            ORDER BY mp.`receipt` DESC LIMIT 1",
            "data" => array(
                BRANCH_CODE,
                BRANCH_CODE
            )
        ));

        return $this->payments_index;

    }

    public function findReceipt($pay_date)
    {

        $this->payments_index['new_receipt'] = parent::selectQuery(array(
            "query" => "SELECT IF(count(*) = 0, CONCAT(?,YEAR(?),MONTH(?),'-',LPAD(1, 5, '0')),
            CONCAT(?,YEAR(?),MONTH(?),'-',LPAD(count(*) + 1, 5, '0'))) new_receipt
            FROM `master_payments` mp
            WHERE MONTH(`pay_date`) = MONTH(?) AND YEAR(`pay_date`) =  YEAR(?)
            ORDER BY mp.`receipt` DESC LIMIT 1",
            "data" => array(
                BRANCH_CODE,
                $pay_date,
                $pay_date,
                BRANCH_CODE,
                $pay_date,
                $pay_date,
                $pay_date,
                $pay_date
            )
        ));

        return $this->payments_index;

    }

    public function findRegNoById($id){
      $this->payments_index['reg_no'] = parent::selectQuery(array(
          "query" => "SELECT  `id`, `reg_no` FROM `master_registrations` WHERE `id` = ?",
          "data" => array(
              $id
          )
      ));

      return $this->payments_index;

    }

}

?>
