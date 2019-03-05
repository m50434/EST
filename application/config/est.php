<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  EST - Online
*
* Version: 1.0 
*
* Author: M. Gehrke (m50434@aol.com)
*         
* DEFAULT LOGIN: admin password
* PLEASE CHANGE THIS PASSWORD
* Created:  04.03.2019
* Requirements: PHP5 or above
*
*
*
* TEST ACCOUNTS
* 
* ID; Benutzername;Password;Kind
* 0;Harrell-123;7136;Jael,Hans
* 1;Cruz-122;7254;Kerry
* 2;Harrell-444;8607;Cheryl,Peter,Franz
* 3;Mckinney-324;5561;Althea
* 4;Camacho-578;6375;Hakeem
* 5;Coleman-555;4506;Abel
* 6;Cline-642;7982;Kane
* 7;Ayala-532;4412;Leroy
* 8;Gregory-809;9168;Adria
*
*/

  

// Parent Options
//$config['no_choice'] = "Achtung: Sie können keine Veränderungen speichern. Die Wahlzeit ist beendet.";    



/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['teachers']        = 'teachers';
$config['tables']['students']        = 'students';
$config['tables']['parent_choice']   = 'parent_choice';
$config['tables']['parent_options']  = 'parent_options';
$config['tables']['prefs']           = 'prefs';
$config['tables']['users_groups']    = 'users_groups';
$config['tables']['users']           = 'users';


/*
 | Users table column and Group table column you want to join WITH.
 |
 | Joins from users.id
 | Joins from groups.id
 */
$config['join']['users']  = 'user_id';
$config['join']['groups'] = 'group_id';


/* End of file est.php */
/* Location: ./application/config/est.php */
