<?php

class menu
{


    private $menus = array();

    public function getMenus($type)
    {

        if ($type == 1)
            $this->menus = array(
                'home' => 'Dashboard',
                'admin' => 'Admin',
                array(
										'menu' => 'Data Add',
                    'addstudents' => "Add Answer Sheets",
                    'addati' => 'Add ATI',
                    'addcourse' => 'Add Course',
                    'addsubject' => 'Add Subject'
                ),
                array(
										'menu' => 'Reports',
                    'report1' => 'Full Report Summary',
                    'report2' => 'Course Wise Summary',
                    'report3' => 'ATI Wise In Detail',
                    'report4' => 'ATI Wise Summary',
                    'report5' => 'Panel Wise Summary'
                ),
								array(
										'menu' => 'Assign',
										'assign1' => 'Assign Course to ATI'
								)
            );

        else if ($type == 0)
            $this->menus = array(
                'home' => 'Dashboard',
                'addstudents' => "Add Answer Sheets"
            );

        return $this->menus;

    }


}


?>
