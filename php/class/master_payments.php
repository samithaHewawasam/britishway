<?php

class master_payments extends database
{

    private $payments_index = array();
    private $paid_amount = 0;
    private $paying = 0;

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

      $this->payments_index['arguments'] = array();

        array_push($this->payments_index['arguments'], array(
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
        ));

        array_push($this->payments_index['arguments'], array(
          'query' => "UPDATE `master_registrations` SET `total_paid`= `total_paid` + ? WHERE `id` = ?",
          'data' => array(
            $data->amount,
            $data->master_reg_id
          )
        ));

        $this->payments_index['dues'] = parent::selectQuery(array(
            "query" => "SELECT *, (`amount` - `paid_amount`) owed FROM `master_student_installments` WHERE (`amount` - `paid_amount`) != 0 AND master_reg_id = ? ORDER BY ins_id",
            "data" => array(
              $data->master_reg_id
            )
        ));


        $this->paid_amount = $data->amount;

        foreach ($this->payments_index['dues']['data'] as $dues) {
            // There's money left
            if ($dues->owed - $this->paid_amount < 0) {
                $this->paying = $dues->owed + $dues->paid_amount;
                $this->paid_amount -= $dues->owed;
            } else {
                // No money left
                $this->paying = $dues->paid_amount + $this->paid_amount;
                $this->paid_amount -= $this->paying;
            }
            // If there's money left
            if ($this->paying > 0) {
                array_push($this->payments_index['arguments'], array(
                    'query' => "UPDATE `master_student_installments` SET `paid_amount` = ? , `paid_date` = ? WHERE `master_reg_id` = ? AND `ins_id` = ?",
                    'data' => array(
                      $this->paying,
                      $data->pay_date,
                      $data->master_reg_id,
                      $dues->ins_id
                    )
                ));
            }
        }

        return parent::wrapper($this->payments_index['arguments']);

    }

}

?>
