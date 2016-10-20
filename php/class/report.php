<?php

class report extends database{

    public function report1($params){

      return parent::selectQuery($params);

    }

}
