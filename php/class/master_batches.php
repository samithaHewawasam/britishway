<?php

class master_batches extends database
{

    private $batches_index = array();

    public function index()
    {

        $this->batches_index['courses'] = parent::selectQuery(array(
            "query" => "SELECT mc.id,mc.course_code, mc.course_name FROM `master_courses` mc
 INNER JOIN `course_allocation` ca  ON mc.id = ca.course_id
 INNER JOIN `master_branches` mb ON mb.id = ca.branch_id WHERE mb.branch_code = ?
 AND mc.status IS TRUE AND mb.status IS TRUE",
            "data" => array(
                BRANCH_CODE
            )
        ));

        return $this->batches_index;

    }

    public function findBatchesByCourseId($id){

      $this->batches_index['batches'] = parent::selectQuery(array(
          "query" => "SELECT * FROM `master_batches` WHERE `batch_course_id` = ? AND `batch_status` IS TRUE",
          "data" => array(
              $id
          )
      ));

      $this->batches_index['new_batch'] = parent::selectQuery(array(
          "query" => "SELECT IF(count(*) = 0,
          CONCAT('".BRANCH_CODE."', mc.`course_code`, '/',YEAR(CURDATE()), '-', LPAD(1,3,'0')),
          CONCAT('".BRANCH_CODE."', mc.`course_code`, '/',YEAR(CURDATE()), '-', LPAD(count(*) + 1,3,'0'))) batch_code
          FROM `master_batches` mb
          INNER JOIN `master_courses` mc ON mc.`id` = mb.`batch_course_id`
          WHERE mb.`batch_course_id` = ".$id." AND mb.`batch_status` IS TRUE ORDER BY mb.`id` DESC LIMIT 1",
          "data" => array()
      ));


      return $this->batches_index;

    }

    public function add($batch_course_id = NULL, $batch_code = NULL, $batch_commence = NULL, $batch_end = NULL, $batch_intake = NULL)
    {

        return parent::wrapper(array(
          array(
            'query' => "INSERT INTO `master_batches`(`batch_course_id`, `batch_code`, `batch_commence`, `batch_end`, `batch_intake`, `batch_status`)
             VALUES (?,?,?,?,?,?)",
            'data' => array(
              $batch_course_id,
              $batch_code,
              $batch_commence,
              $batch_end,
              $batch_intake,
              1
            )
        )));

    }

}

?>
