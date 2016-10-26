<?php

class user extends database
{

   private $login;
   private $menu_fetch;
   private $menus = array();
   public function login($user_name, $password)
   {

       $this->login = parent::selectQuery(array(
           'query' => "SELECT `id`,`user_display_name`,`user_role` FROM `master_users` WHERE `user_name` = ? AND `user_pass` = ? AND user_status IS TRUE",
           'data' => array(
               $user_name,
               $password
           )
       ));

       return $this->login;

   }

   public function menu(){

     if(!empty($this->login)){

      $this->log($this->login['data'][0]->id, 'login');

      $this->menu_fetch = parent::selectQuery(array(
           'query' => "SELECT mm.menu_name main_menu, mms.menu_name sub_menu, mm.menu_path main_menu_path, mms.menu_path sub_menu_path
           FROM `master_menu_config` mmc INNER JOIN `master_menu` mm ON mm.id = mmc.menu_id
           INNER JOIN `master_menu_sub` mms ON mms.id = mmc.menu_sub
           WHERE mmc.role_id = ?",
           'data' => array($this->login['data'][0]->user_role)
       ));

       foreach($this->menu_fetch['data'] as $key => $menu){
         $this->menus[$menu->main_menu][$menu->sub_menu_path] = $menu->sub_menu;
         $this->menus[$menu->main_menu]['path'] =  $menu->main_menu_path;
       }

       return $this->menus;

     }

   }

   public function log($user_id, $function){

     return parent::wrapper(array(
     array(
         'query' => "INSERT INTO `master_log`(`operator`, `function`, `date`) VALUES (?, ?, ?)",
         'data'  => array($user_id, $function, Date('Y-m-d'))
     )
    ));

   }

}


?>
