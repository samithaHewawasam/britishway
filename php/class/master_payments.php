<?php

class master_payments extends database
{

    private $payments_index = array();
    private $sql = "";

    public function index()
    {

        $this->payments_index['new_receipt'] = parent::selectQuery(array(
            "query" => "SELECT IF(count(*) = 0, CONCAT(?,YEAR(CURDATE()),MONTH(CURDATE()),'-',LPAD(1, 5, '0')),
            CONCAT(?,YEAR(CURDATE()),MONTH(CURDATE()),'-',LPAD(RIGHT(MAX(mp.`receipt`),5) + 1, 5, '0'))) new_receipt
            FROM `master_payments` mp
            WHERE MONTH(`pay_date`) = MONTH(CURDATE()) AND YEAR(`pay_date`) =  YEAR(CURDATE())",
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
            CONCAT(?,YEAR(?),MONTH(?),'-',LPAD(RIGHT(MAX(mp.`receipt`),5)+ 1, 5, '0'))) new_receipt
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
          "query" => "SELECT  mr.`id`, mr.`reg_no`, ms.`name_initials`, (mr.net - mr.total_paid) due FROM `master_registrations` mr INNER JOIN `master_students` ms ON ms.id = mr.student_id WHERE mr.`id` = ?",
          "data" => array(
              $id
          )
      ));

      return $this->payments_index;

    }

    public function findRegNoByRegNo($reg_no){
      $this->payments_index['reg_no'] = parent::selectQuery(array(
          "query" => "SELECT  mr.`id`, mr.`reg_no`, ms.`name_initials`, (mr.net - mr.total_paid) due FROM `master_registrations` mr INNER JOIN `master_students` ms ON ms.id = mr.student_id WHERE mr.`reg_no` = ?",
          "data" => array(
              $reg_no
          )
      ));

      return $this->payments_index;

    }

    public function add($data)
    {

      return parent::wrapperForPayments($data);

    }


    public function delete($receipt){

      return parent::wrapper(array(
        array(
          'query' => "DELETE FROM `master_payments` WHERE `receipt` = ?",
          'data' => array($receipt)
      )));

    }


}

?>
