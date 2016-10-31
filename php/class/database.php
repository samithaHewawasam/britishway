<?php

abstract class database extends PDO
{


    private $sql;
    private $sqlSync;
    private $response = array('commit' => false, 'error' => null, 'error_alert' => null, 'rollback' => false);
    private $result = array('data' => array(), 'error' => NULL);

    public function __construct()
    {

        include "config.php";
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
              "query" => "SELECT IF(count(*) = 0, CONCAT(?, mc.course_code, '-',LPAD(1, 6, '0')) , CONCAT(?, mc.course_code, '-',LPAD(count(*) + 1, 6, '0')) ) reg_no
      FROM `master_registrations` mr
      INNER JOIN `master_courses` mc ON mc.id = mr.course_id WHERE mc.id = ?
      ORDER BY mr.reg_no DESC LIMIT 1",
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
                $data->operator_id,
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
                    $data->operator_id,
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
