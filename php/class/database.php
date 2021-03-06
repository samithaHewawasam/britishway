<?php

abstract class database extends PDO
{


    private $sql;
    private $sqlSync;
    private $response = array('commit' => false, 'error' => null, 'error_alert' => null, 'rollback' => false, 'data' => array());
    private $result = array('data' => array(), 'error' => NULL);
    private $dues = array();
    private $paid_amount = 0;
    private $paying = 0;

    public function __construct()
    {

        include "config.php";
        $this->response['branch_name'] = BRANCH_NAME;
        parent::__construct('mysql:host=localhost;dbname='.DATABASE, USERNAME, PASSWORD, array(
            PDO::ATTR_PERSISTENT => true
        ));
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function wrapper(array $arguments)
   {
       try {
           parent::beginTransaction();
           foreach ($arguments as $key => &$value) {

               $this->sql = parent::prepare(trim($value['query']));
               foreach ($value['data'] as $key => &$val) {
                   $this->sql->bindValue($key + 1, $val);
               }

               $this->sql->execute();
               $value['last_insert_id'] = parent::lastInsertId();

               $this->sqlSync = parent::prepare("INSERT INTO `sync_log`( `query`, `data`) VALUES (?,?)");
               $this->sqlSync->execute(array(
                   $value['query'],
                   serialize($value['data'])
               ));

           }

           $this->response['commit'] = parent::commit();
           $this->response['last_insert_id'] = $arguments[0]['last_insert_id'];
       }
       catch (PDOException $e) {
          if($e->errorInfo[1] == 1062){
            $this->response['error_alert'] = "Duplicate recode found";
          }
          $this->response['error'] = $e->getMessage();
          $this->response['rollback'] = parent::rollBack();
       }

       return $this->response;
   }

   public function wrapperForRegistrations(&$data)
  {
      try {
          parent::beginTransaction();

          $data->reg_no = $this->selectQuery(array(
              "query" => "SELECT IF(count(*) = 0, CONCAT(?, mc.course_code, '-',LPAD(1, 6, '0')) , CONCAT(?, mc.course_code, '-',LPAD(RIGHT(MAX(mr.reg_no),6) + 1, 6, '0')) ) reg_no
      FROM `master_registrations` mr
      INNER JOIN `master_courses` mc ON mc.id = mr.course_id WHERE mc.id = ?",
              "data" => array(
                  BRANCH_CODE,
                  BRANCH_CODE,
                  $data->course_id
              )
          ))['data'][0]->reg_no;

              $this->sql = parent::prepare("INSERT INTO `master_registrations`(`reg_no`, `course_id`, `reg_date`, `student_id`, `batch_id`, `fee_id`, `fee`, `net`, `reg_fee`, `discount`, `discount_comment`, `operator_id`, `status`)
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
              $this->sql->execute(array(
                $data->reg_no,
                $data->course_id,
                $data->reg_date,
                $data->student_master_id,
                $data->batch_id,
                $data->fee_id,
                $data->fee,
                $data->net,
                $data->reg_fee,
                $data->discount,
                $data->discount_comment,
                USER_ID,
                1
              ));

              $data->last_insert_id = parent::lastInsertId();

              $this->sqlSync = parent::prepare("INSERT INTO `sync_log`( `query`, `data`) VALUES (?,?)");
              $this->sqlSync->execute(array(
                  "INSERT INTO `master_registrations`(`reg_no`, `course_id`, `reg_date`, `student_id`, `batch_id`, `fee_id`, `fee`, `net`, `reg_fee`, `discount`, `discount_comment`, `operator_id`, `status`)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
                  serialize(array(
                    $data->reg_no,
                    $data->course_id,
                    $data->reg_date,
                    $data->student_master_id,
                    $data->batch_id,
                    $data->fee_id,
                    $data->fee,
                    $data->net,
                    $data->reg_fee,
                    $data->discount,
                    $data->discount_comment,
                    USER_ID,
                    1
                  ))
              ));

              if(property_exists($data,  'fee_installments')){

                foreach($data->fee_installments as $installments){

                  $this->sql = parent::prepare("INSERT INTO `master_student_installments`(`master_reg_id`, `amount`, `ins_id`, `due_date`) VALUES (?,?,?,?)");
                  $this->sql->execute(array(
                    $data->last_insert_id,
                    $installments->amount,
                    $installments->ins_id,
                    $installments->due_date
                  ));

                  $this->sqlSync = parent::prepare("INSERT INTO `sync_log`( `query`, `data`) VALUES (?,?)");
                  $this->sqlSync->execute(array(
                      "INSERT INTO `master_student_installments`(`master_reg_id`, `amount`, `ins_id`, `due_date`) VALUES (?,?,?,?)",
                      serialize(array(
                        $data->last_insert_id,
                        $installments->amount,
                        $installments->ins_id,
                        $installments->due_date
                      ))
                  ));

                }

              }

          $this->response['commit'] = parent::commit();
          $this->response['last_insert_id'] = $data->last_insert_id;

      }
      catch (PDOException $e) {
         if($e->errorInfo[1] == 1062){
           $this->response['error_alert'] = "Duplicate recode found";
         }
         $this->response['error'] = $e->getMessage();
         $this->response['rollback'] = parent::rollBack();
      }

      return $this->response;
  }

  public function wrapperForPayments(&$data)
 {
     try {
         parent::beginTransaction();

         if(empty($data->master_reg_id)){

           $data->reg_no_array = $this->selectQuery(array(
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

         $data->total = 0;

         foreach($data->pay_type_array as $key => $pay_type){

           $data->total += $pay_type['amount'];

             $data->receipt = $this->selectQuery(array(
                 "query" => "SELECT IF(count(*) = 0, CONCAT(?,YEAR(?),MONTH(?),'-',LPAD(1, 5, '0')),
                 CONCAT(?,YEAR(?),MONTH(?),'-',LPAD(RIGHT(MAX(mp.`receipt`),5)+ 1, 5, '0'))) new_receipt
                 FROM `master_payments` mp
                 WHERE MONTH(`pay_date`) = MONTH(?) AND YEAR(`pay_date`) =  YEAR(?)
                 ORDER BY mp.`receipt` DESC LIMIT 1",
                 "data" => array(
                     BRANCH_CODE,
                     $data->pay_date,
                     $data->pay_date,
                     BRANCH_CODE,
                     $data->pay_date,
                     $data->pay_date,
                     $data->pay_date,
                     $data->pay_date
                 )
             ))["data"][0]->new_receipt;

           if($key == 'Cash' && !empty($pay_type['amount'])){
             $data->amount = $pay_type['amount'];
             $data->pay_type = 1;
             $data->bank_name = NULL;
             $data->reference = NULL;

             $this->sql = parent::prepare("INSERT INTO `master_payments`(`master_reg_id`, `receipt`, `amount`, `pay_date`, `pay_type`, `bank_name`, `reference`, `operator_id`)
             VALUES (?,?,?,?,?,?,?,?)");
             $this->sql->execute(array(
               $data->master_reg_id,
               $data->receipt,
               $data->amount,
               $data->pay_date,
               $data->pay_type,
               $data->bank_name,
               $data->reference,
               USER_ID
             ));

             array_push($this->response['data'], $this->selectQuery(array(
                 "query" => "SELECT mp.*, mu.user_display_name, mr.reg_no FROM `master_payments` mp INNER JOIN `master_users` mu ON mp.operator_id = mu.id INNER JOIN master_registrations mr ON mr.id = mp.master_reg_id WHERE `receipt` = ?",
                 "data" => array(
                   $data->receipt
                 )
             ))['data'][0]);

           }else if($key == 'Cheque' && !empty($pay_type['amount'])){
             $data->amount = $pay_type['amount'];
             $data->pay_type = 2;
             $data->bank_name = $pay_type['bank_name'];
             $data->reference = $pay_type['reference'];

             $this->sql = parent::prepare("INSERT INTO `master_payments`(`master_reg_id`, `receipt`, `amount`, `pay_date`, `pay_type`, `bank_name`, `reference`, `operator_id`)
             VALUES (?,?,?,?,?,?,?,?)");
             $this->sql->execute(array(
               $data->master_reg_id,
               $data->receipt,
               $data->amount,
               $data->pay_date,
               $data->pay_type,
               $data->bank_name,
               $data->reference,
               USER_ID
             ));

             array_push($this->response['data'], $this->selectQuery(array(
                 "query" => "SELECT mp.*, mu.user_display_name FROM `master_payments` mp INNER JOIN `master_users` mu ON mp.operator_id = mu.id WHERE `receipt` = ?",
                 "data" => array(
                   $data->receipt
                 )
             ))['data'][0]);

           }else if($key == 'Credit' && !empty($pay_type['amount'])){
             $data->amount = $pay_type['amount'];
             $data->pay_type = 3;
             $data->bank_name = $pay_type['bank_name'];
             $data->reference = $pay_type['reference'];

             $this->sql = parent::prepare("INSERT INTO `master_payments`(`master_reg_id`, `receipt`, `amount`, `pay_date`, `pay_type`, `bank_name`, `reference`, `operator_id`)
             VALUES (?,?,?,?,?,?,?,?)");
             $this->sql->execute(array(
               $data->master_reg_id,
               $data->receipt,
               $data->amount,
               $data->pay_date,
               $data->pay_type,
               $data->bank_name,
               $data->reference,
               USER_ID
             ));

             array_push($this->response['data'], $this->selectQuery(array(
                 "query" => "SELECT mp.*, mu.user_display_name FROM `master_payments` mp INNER JOIN `master_users` mu ON mp.operator_id = mu.id WHERE `receipt` = ?",
                 "data" => array(
                   $data->receipt
                 )
             ))['data'][0]);

           }else if($key == 'Bank' && !empty($pay_type['amount'])){
             $data->amount = $pay_type['amount'];
             $data->pay_type = 4;
             $data->bank_name = $pay_type['bank_name'];
             $data->reference = $pay_type['reference'];

             $this->sql = parent::prepare("INSERT INTO `master_payments`(`master_reg_id`, `receipt`, `amount`, `pay_date`, `pay_type`, `bank_name`, `reference`, `operator_id`)
             VALUES (?,?,?,?,?,?,?,?)");
             $this->sql->execute(array(
               $data->master_reg_id,
               $data->receipt,
               $data->amount,
               $data->pay_date,
               $data->pay_type,
               $data->bank_name,
               $data->reference,
               USER_ID
             ));

             array_push($this->response['data'], $this->selectQuery(array(
                 "query" => "SELECT mp.*, mu.user_display_name FROM `master_payments` mp INNER JOIN `master_users` mu ON mp.operator_id = mu.id WHERE `receipt` = ?",
                 "data" => array(
                   $data->receipt
                 )
             ))['data'][0]);

           }

         }

         $this->sql = parent::prepare("UPDATE `master_registrations` SET `total_paid`= `total_paid` + ? WHERE `id` = ?");
         $this->sql->execute(array(
           $data->amount,
           $data->master_reg_id
         ));

           $this->dues = $this->selectQuery(array(
               "query" => "SELECT *, (`amount` - `paid_amount`) owed FROM `master_student_installments` WHERE (`amount` - `paid_amount`) != 0 AND master_reg_id = ? ORDER BY ins_id",
               "data" => array(
                 $data->master_reg_id
               )
           ));


           $this->paid_amount = $data->total;

           foreach ($this->dues['data'] as $dues) {
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

                 $this->sql = parent::prepare("UPDATE `master_student_installments` SET `paid_amount` = ? , `paid_date` = ? WHERE `master_reg_id` = ? AND `ins_id` = ?");
                 $this->sql->execute(array(
                   $this->paying,
                   $data->pay_date,
                   $data->master_reg_id,
                   $dues->ins_id
                 ));

               }
           }

         $this->response['commit'] = parent::commit();


     }
     catch (PDOException $e) {
        if($e->errorInfo[1] == 1062){
          $this->response['error_alert'] = "Duplicate recode found";
        }
        if($e->errorInfo[1] == 1452){
          $this->response['error_alert'] = "The Registration Number not found";
        }
        $this->response['error'] = $e->getMessage();
        $this->response['rollback'] = parent::rollBack();
     }

     return $this->response;
 }

    public function selectQuery(array $param)
    {

        try {

            $this->sql = parent::prepare($param['query']);
            $this->sql->execute($param['data']);
            $this->result['data'] = $this->sql->fetchALL(PDO::FETCH_OBJ);

        }
        catch (PDOException $e) {

            $this->result['error'] = $e->getMessage();

        }

        return $this->result;


    }

    public function select(array $param)
    {

        try {

            $this->result['data'] = parent::query($param['query']);

        }
        catch (PDOException $e) {

            $this->result['error'] = $e->getMessage();

        }

        return $this->result;


    }

    public function executeQuery(array $params)
    {

        try {

            parent::beginTransaction();

            foreach ($params as $value) {
                $this->sql = parent::prepare($value['query']);
                $this->sql->execute($value['data']);

            }
            $this->response['commit'] = parent::commit();

        }
        catch (PDOException $e) {

            $this->response['rollback'] = parent::rollBack();
            $this->response['error']    = $e->getMessage();

        }

        return $this->response;


    }

    public function log($user_id, $function){

      return $this->wrapper(array(
      array(
          'query' => "INSERT INTO `master_log`(`operator`, `function`, `date`) VALUES (?, ?, ?)",
          'data'  => array($user_id, $function, Date('Y-m-d'))
      )
     ));

    }

}

?>
