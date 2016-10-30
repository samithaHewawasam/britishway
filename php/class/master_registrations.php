<?php

class master_registrations extends database
{

    private $registrations_index = array();

    public function index($id)
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

        $registrations_index['student_id'] = parent::selectQuery(array(
            "query" => "SELECT `student_id` FROM `master_students` WHERE `id` = ?",
            "data" => array(
                $id
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

        $registrations_index['fee_structures'] = parent::selectQuery(array(
            "query" => "SELECT mfs.id, mfs.fee_structure_code,course_fee_full,course_fee_ins,registration_fee,exam_fee
            FROM `master_fee_structures` mfs INNER JOIN `master_courses` mc ON mfs.`course_id` = mc.id WHERE mc.id = ?
            AND mfs.status IS TRUE",
            "data" => array(
                $course_id
            )
        ));

        return $registrations_index;


    }

    public function findByFeeStructureId($id,  $fullOrIns){


      if($fullOrIns == 1){

        $registrations_index['fee_structure'] = parent::selectQuery(array(
            "query" => "SELECT `course_fee_full` gross,`registration_fee`,`exam_fee` FROM `master_fee_structures` mfs WHERE mfs.`id` = ?  AND mfs.status IS TRUE",
            "data" => array(
                $id
            )
        ));

      }else if($fullOrIns == 0){

        $registrations_index['fee_structure'] = parent::selectQuery(array(
            "query" => "SELECT `course_fee_ins` gross,`registration_fee`,`exam_fee` FROM `master_fee_structures` mfs WHERE mfs.`id` = ?  AND mfs.status IS TRUE",
            "data" => array(
                $id
            )
        ));

        $registrations_index['fee_installments'] = parent::selectQuery(array(
            "query" => "SELECT * FROM `master_fee_installments` mfi WHERE mfi.`master_fee_id` = ?",
            "data" => array(
                $id
            )
        ));

      }

      return $registrations_index;

    }


}

?>
