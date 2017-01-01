<?php

class report extends database
{

    private $report_index = array();
    private $where = "";
    private $params = array();
    private $income = array();
    private $registrations = array();

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
        "query" => "SELECT mp.pay_date, mr.reg_no, ms.name_initials, mc.course_name, mb.batch_code, mp.receipt, mp.amount, mp.pay_type, mu.user_display_name,
        CASE
                WHEN mp.pay_type  = 1 THEN 'Cash'
                WHEN mp.pay_type  = 2 THEN 'Cheque'
                WHEN mp.pay_type  = 3 THEN 'Credit/Debit Card'
                WHEN mp.pay_type  = 4 THEN 'Bank Deposits'
                ELSE NULL
            END AS payment_type, mp.operator_id
        FROM `master_payments` mp
        LEFT JOIN `master_registrations` mr ON mp.master_reg_id = mr.id
        LEFT JOIN master_students ms ON ms.id = mr.student_id
        LEFT JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_users` mu ON mu.id = mp.operator_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id WHERE 1".$this->where." ORDER BY mp.pay_type, mp.operator_id, mp.pay_date",
        "data" => $this->params
      ));

      foreach($this->report_index['income']['data'] as $value){

        $this->income[$value->pay_type][$value->operator_id][] = $value;

      }

      return $this->income;

    }

    public function registrations($data){

      if(!empty($data->startDate) && !empty($data->endDate)){

        $this->where = " AND mr.`reg_date` BETWEEN ? AND ?";
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

      $this->report_index['registrations'] = parent::selectQuery(array(
        "query" => "SELECT  mc.course_name,  count(*) total FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id WHERE 1".$this->where. " GROUP BY mc.id",
        "data" => $this->params
      ));

      return $this->report_index;

    }

    public function batch_wise($data){

      if(!empty($data->startDate) && !empty($data->endDate)){

        $this->where = " AND mr.`reg_date` BETWEEN ? AND ?";
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

      $this->report_index['batch_wise'] = parent::selectQuery(array(
        "query" => "SELECT  mc.course_name, mc.id, IFNULL(mb.batch_code, 'NOT ASSIGNED') batch_code, mb.id, count(*) total FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id WHERE 1".$this->where." GROUP BY mc.course_name, mb.batch_code",
        "data" => $this->params
      ));

      return $this->report_index;

    }


    public function dues($data){

      if(!empty($data->startDate) && !empty($data->endDate)){

        $this->where = " AND mr.`reg_date` BETWEEN ? AND ?";
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

      $this->report_index['dues'] = parent::selectQuery(array(
        "query" => "SELECT  mr.reg_no, ms.name_initials, ms.contact_no_1, mc.course_name, IFNULL(mb.batch_code, 'NOT ASSIGNED') batch,IFNULL(MIN(msi.due_date), mr.reg_date) due_date, DATEDIFF(CURDATE(), IFNULL(MIN(msi.due_date), mr.reg_date)) due_gap, IFNULL(SUM(`amount`-`paid_amount`), `net`-`total_paid`) upto FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_student_installments` msi ON msi.master_reg_id = mr.id
        LEFT JOIN `master_students` ms ON ms.id = mr.student_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id  WHERE 1".$this->where." GROUP BY mr.id",
        "data" => $this->params
      ));

      return $this->report_index;

    }


    public function search($reg_no){

      $this->report_index['registration'] = parent::selectQuery(array(
        "query" => "SELECT  mr.reg_date,ms.`student_id`, ms.name_initials, mc.course_name, mb.batch_code,mr.fee, mr.net,mr.`total_paid`,mr.`reg_fee`,mr.`discount`,mr.`discount_comment`,mu.user_display_name FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_students` ms ON ms.id = mr.student_id
        LEFT JOIN `master_users` mu ON mu.id = mr.operator_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id  WHERE mr.`reg_no` = ?",
        "data" => array($reg_no)
      ));

      $this->report_index['installments'] = parent::selectQuery(array(
        "query" => "SELECT  msi.`ins_id`, msi.`amount`, msi.`paid_amount`, msi.`due_date`, msi.paid_date FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_students` ms ON ms.id = mr.student_id
        LEFT JOIN `master_student_installments` msi ON msi.master_reg_id = mr.id
        LEFT JOIN `master_users` mu ON mu.id = mr.operator_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id  WHERE mr.`reg_no` = ? ORDER BY msi.ins_id ASC",
        "data" => array($reg_no)
      ));

      $this->report_index['payments'] = parent::selectQuery(array(
        "query" => "SELECT  mp.`receipt`, mp.`amount`, mp.`pay_date`, mp.`pay_type`,mp.bank_name, mp.reference, mu.user_display_name FROM `master_registrations` mr
        INNER JOIN `master_courses` mc ON mc.id = mr.course_id
        LEFT JOIN `master_students` ms ON ms.id = mr.student_id
        LEFT JOIN `master_payments` mp ON mp.master_reg_id = mr.id
        LEFT JOIN `master_users` mu ON mu.id = mp.operator_id
        LEFT JOIN `master_batches` mb ON mb.id = mr.batch_id  WHERE mr.`reg_no` = ? ORDER BY mp.pay_date ASC",
        "data" => array($reg_no)
      ));

      return $this->report_index;

    }


}

?>
