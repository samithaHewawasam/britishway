<?php

abstract class database extends PDO
{


    private $sql;
    private $sqlSync;
    private $response = array('commit' => false, 'error' => null, 'rollback' => false);
    private $result = array('data' => array(), 'error' => NULL);

    public function __construct()
    {

        include "config.php";
        parent::__construct('mysql:host=localhost;dbname='.DATABASE, USERNAME, PASSWORD, array(
            PDO::ATTR_PERSISTENT => true
        ));

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
