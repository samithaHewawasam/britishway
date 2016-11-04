<?php

class master_registrations extends database
{

    private $registrations_index = array();

    public function index($id)
    {

        $this->registrations_index['courses'] = parent::selectQuery(array(
            "query" => "SELECT mc.id,mc.course_code, mc.course_name FROM `master_courses` mc
 INNER JOIN `course_allocation` ca  ON mc.id = ca.course_id
 INNER JOIN `master_branches` mb ON mb.id = ca.branch_id WHERE mb.branch_code = ?
 AND mc.status IS TRUE AND mb.status IS TRUE",
            "data" => array(
                BRANCH_CODE
            )
        ));

        $this->registrations_index['student_id'] = parent::selectQuery(array(
            "query" => "SELECT `student_id` FROM `master_students` WHERE `id` = ?",
            "data" => array(
                $id
            )
        ));

        return $this->registrations_index;

    }

    public function getLastRegNoAndBatches($course_id)
    {

        $this->registrations_index['registrations'] = parent::selectQuery(array(
            "query" => "SELECT IF(count(*) = 0, CONCAT(?, mc.course_code, '-',LPAD(1, 6, '0')) , CONCAT(?, mc.course_code, '-',LPAD(count(*) + 1, 6, '0')) ) reg_no
    FROM `master_registrations` mr
    INNER JOIN `master_courses` mc ON mc.id = mr.course_id WHERE mc.id = ?
    ORDER BY mr.reg_no DESC LIMIT 1",
            "data" => array(
                BRANCH_CODE,
                BRANCH_CODE,
                $course_id
            )
        ));

        $this->registrations_index['batches'] = parent::selectQuery(array(
            "query" => "SELECT `id`,`batch_code` FROM `master_batches` WHERE `batch_course_id` = ? AND `batch_status` IS TRUE",
            "data" => array(
                $course_id
            )
        ));

        $this->registrations_index['fee_structures'] = parent::selectQuery(array(
            "query" => "SELECT mfs.id, mfs.fee_structure_code,course_fee_full,course_fee_ins,registration_fee,exam_fee
            FROM `master_fee_structures` mfs INNER JOIN `master_courses` mc ON mfs.`course_id` = mc.id WHERE mc.id = ?
            AND mfs.status IS TRUE",
            "data" => array(
                $course_id
            )
        ));

        return $this->registrations_index;


    }

    public function findByFeeStructureId($id,  $fullOrIns){


      if($fullOrIns == 1){

        $this->registrations_index['fee_structure'] = parent::selectQuery(array(
            "query" => "SELECT `course_fee_full` gross,`registration_fee`,`exam_fee` FROM `master_fee_structures` mfs WHERE mfs.`id` = ?  AND mfs.status IS TRUE",
            "data" => array(
                $id
            )
        ));

      }else if($fullOrIns == 0){

        $this->registrations_index['fee_structure'] = parent::selectQuery(array(
            "query" => "SELECT IFNULL(`course_fee_ins`, `course_fee_full`) gross,`registration_fee`,`exam_fee` FROM `master_fee_structures` mfs WHERE mfs.`id` = ?  AND mfs.status IS TRUE",
            "data" => array(
                $id
            )
        ));

        $this->registrations_index['fee_installments'] = parent::selectQuery(array(
            "query" => "SELECT *,IF(mfi.ins_id = 1, CURDATE(), IF( mfs.ins_days = 20, ADDDATE(CURDATE(), INTERVAL 20 DAY), ADDDATE(CURDATE(), INTERVAL mfi.ins_id -1 MONTH)) ) due_date FROM `master_fee_installments` mfi  INNER JOIN `master_fee_structures` mfs ON mfs.`id` = mfi.`master_fee_id` WHERE mfi.`master_fee_id` = ?",
            "data" => array(
                $id
            )
        ));

      }

      return $this->registrations_index;

    }

    public function add($data)
    {

        return parent::wrapperForRegistrations($data);

    }


}

?>
