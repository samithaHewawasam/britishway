<?php

class master_registrations extends database
{

    private $registrations_index = array();

    public function index($course_code)
    {

        $registrations_index['courses'] = parent::selectQuery(array(
            "query" => "SELECT mc.id,mc.course_code, mc.course_name FROM `master_courses` mc
 INNER JOIN `course_allocation` ca  ON mc.id = ca.course_id
 INNER JOIN `master_branches` mb ON mb.id = ca.branch_id WHERE mb.branch_code = ?
 AND mc.status IS TRUE AND mb.status IS TRUE",
            "data" => array(
                BRANCH_CODE
            )
        ));

        return $registrations_index;

    }

    public function getLastRegNoAndBatches($course_id)
    {

        $registrations_index['registrations'] = parent::selectQuery(array(
            "query" => "SELECT CONCAT(?, mc.course_code, '-',LPAD(RIGHT(mr.reg_no, 6) + 1, 6, '0')) reg_no
    FROM `master_registrations` mr INNER JOIN `master_branches` mb ON mr.branch_id = mb.id
    INNER JOIN `master_courses` mc ON mc.id = mr.course_id WHERE mc.id = ?
    ORDER BY mr.reg_no DESC LIMIT 1",
            "data" => array(
                BRANCH_CODE,
                $course_id
            )
        ));

        $registrations_index['batches'] = parent::selectQuery(array(
            "query" => "SELECT `batch_code` FROM `master_batches` WHERE `batch_course_id` = ? AND `batch_status` IS TRUE",
            "data" => array(
                $course_id
            )
        ));

        return $registrations_index;


    }


}

?>
