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

    public function add($data)
    {

      if(empty($data->master_reg_id)){

        $data->reg_no_array = parent::selectQuery(array(
            "query" => "SELECT `id` FROM `master_registrations` WHERE `reg_no` = ?",
            "data" => array(
                trim($data->master_reg_no)
            )
        ))['data'];

        if(empty($data->reg_no_array)){

          echo json_encode(array('commit' => false, 'error' => null, 'error_alert' => "Reg No is not exits", 'rollback' => true));
          die();

        }else{
          $data->master_reg_id = $data->reg_no_array[0]->id;
        }

      }

      if(!empty($this->findReceipt($data->pay_date)['new_receipt']["data"])){
        $data->receipt = $this->findReceipt($data->pay_date)['new_receipt']["data"][0]->new_receipt;
      }else{
        echo json_encode(array('commit' => false, 'error' => null, 'error_alert' => "Receipt Error", 'rollback' => true));
        die();
      }


        return parent::wrapper(array(
          array(
            'query' => "INSERT INTO `master_payments`(`master_reg_id`, `receipt`, `amount`, `pay_date`, `pay_type`, `bank_name`, `reference`, `operator_id`)
            VALUES (?,?,?,?,?,?,?,?)",
            'data' => array(
              $data->master_reg_id,
              $data->receipt,
              $data->amount,
              $data->pay_date,
              $data->pay_type,
              $data->bank_name,
              $data->reference,
              1
            )
        )));

    }

}

?>
