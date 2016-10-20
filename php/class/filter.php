<?php

class filter extends database
{


    public function getAtis(array $params)
    {

        return parent::selectQuery($params);

    }

    public function getCourses(array $params)
    {

        return parent::selectQuery($params);

    }

    public function getSubjects(array $params)
    {

        return parent::selectQuery($params);

    }

    public function getSatCounts(array $params)
    {

        return parent::selectQuery($params);

    }

    public function getSat(array $params)
    {

        return parent::selectQuery($params);

    }

    public function getCourseToAti(array $params)
    {

        return parent::selectQuery($params);

    }



}

?>
