<?php

class delete extends database
{


    public function deleteQuery(array $params)
    {

        return parent::executeQuery($params);

    }

}

?>
