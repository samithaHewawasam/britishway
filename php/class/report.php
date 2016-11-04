<?php

class report extends database
{

    private $report_index = array();

    public function index()
    {

        $this->report_index['courses'] = parent::selectQuery(array(
          "query" => "SELECT mc.id,mc.course_code, mc.course_name FROM `master_courses` mc
INNER JOIN `course_allocation` ca  ON mc.id = ca.course_id
INNER JOIN `master_branches` mb ON mb.id = ca.branch_id WHERE mb.branch_code = ?
AND mc.status IS TRUE AND mb.status IS TRUE",
          "data" => array(
              BRANCH_CODE
          )
        ));

        $this->report_index['batches'] = parent::selectQuery(array(
          "query" => "SELECT `id`,`batch_code` FROM `master_batches` WHERE `batch_status` IS TRUE",
          "data" => array()
        ));

        return $this->report_index;

    }

    public function findBatchByCourseId($course_id){

      $this->report_index['batches'] = parent::selectQuery(array(
          "query" => "SELECT `id`,`batch_code` FROM `master_batches` WHERE `batch_course_id` = ? AND `batch_status` IS TRUE",
          "data" => array(
              $course_id
          )
      ));

    }

}

?>
