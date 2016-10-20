<?php

abstract class database extends PDO
{


    private $response = array('commit' => false, 'error' => null, 'rollback' => false);
    private $result = array('data' => array(), 'error' => NULL);

    public function __construct()
    {

        parent::__construct('mysql:host=localhost;dbname=exam', 'root', '891600909v', array(
            PDO::ATTR_PERSISTENT => true
        ));

    }

    public function selectQuery(array $param)
    {

        try {

            $this->sql = parent::prepare(trim($param['query']));
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
