<?php

class database extends PDO
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
           foreach ($arguments as $key => $val) {
               $this->sql = parent::prepare(trim($val['query']));
               $this->sqlSync = parent::prepare("INSERT INTO `sync_log`( `query`, `data`) VALUES (?,?)");
               $this->sqlSync->execute(array(
                   $val['query'],
                   serialize($val['data'])
               ));

               foreach ($val['data'] as $key => &$val) {
                   $this->sql->bindValue($key + 1, $val);
               }

               $this->sql->execute();
           }
           $this->response['commit'] = parent::commit();
       }
       catch (PDOException $e) {
          $this->result['error'] = $e->getMessage();
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



}

?>
