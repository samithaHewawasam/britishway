<?php

class report extends database
{

    private $report_index = array();
    private $where = "";
    private $params = array();
    private $income = array();

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

      return $this->report_index;

    }

    public function income($data){

      if(!empty($data->startDate) && !empty($data->endDate)){

        $this->where = " AND mp.`pay_date` BETWEEN ? AND ?";
        array_push($this->params, $data->startDate);
        array_push($this->params, $data->endDate);
      }

      if(!empty($data->course_id)){

        $this->where .= " AND mc.`id` = ?";
        array_push($this->params, $data->course_id);
      }

      if(!empty($data->batch_id)){

        $this->where .= " AND mb.`id` = ?";
        array_push($this->params, $data->batch_id);
      }

      $this->report_index['income'] = parent::selectQuery(array(
        "query" => "SELECT mp.pay_date, mr.reg_no, ms.name_full, mc.course_name, mb.batch_code, mp.receipt, mp.amount, mp.pay_type, mu.user_display_name,
        CASE
                WHEN mp.pay_type  = 1 THEN 'Cash'
                WHEN mp.pay_type  = 2 THEN 'Cheque'
                WHEN mp.pay_type  = 3 THEN 'Credit/Debit Card'
                WHEN mp.pay_type  = 4 THEN 'Bank Deposits'
                ELSE NULL
            END AS payment_type, mp.operator_id
        FROM `master_payments` mp
        INNER JOIN `master_registrations` mr ON mp.master_reg_id = mr.id
        INNER JOIN master_students ms ON ms.id = mr.student_id
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        INNER JOIN `master_users` mu ON mu.id = mp.operator_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id WHERE 1".$this->where." ORDER BY mp.pay_type, mp.operator_id, mp.pay_date",
        "data" => $this->params
      ));

      foreach($this->report_index['income']['data'] as $value){

        $this->income[$value->pay_type][$value->operator_id][] = $value;

      }

      return $this->income;

    }

}

?>
