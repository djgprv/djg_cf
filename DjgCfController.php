<?php

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */
/**
	* The djg_cf plugin
	* @author Michał Uchnast <djgprv@gmail.com>,
	* @copyright kreacjawww.pl
	* @license http://www.gnu.org/licenses/gpl.html GPLv3 license
*/

class DjgCfController extends PluginController {
    static public $urilang = false;

    function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/djg_cf/views/sidebar'));
    }

    public function index() {
        $this->documentation();
    }

    public function documentation() {
        $this->display('djg_cf/views/documentation');
    }

    function settings() {
        $this->display('djg_cf/views/settings', array('settings' => Plugin::getAllSettings('djg_cf'),'subjects' => Plugin::getSetting('subjects','djg_cf')));
    }

	function array_remove_empty($arr){
		$narr = array();
		while(list($key, $val) = each($arr)){
			if (is_array($val)){
				$val = array_remove_empty($val);
				if (count($val)!=0){
					$narr[$key] = $val;
				}
			}
			else {
				if (trim($val) != ""){
					$narr[$key] = $val;
				}
			}
		}
		unset($arr);
		return $narr;
	}
    function save() {
		$settings = $_POST['settings'];
		$subjects = $_POST['subjects'];
		$subjects = self::array_remove_empty($subjects);
		$settings['subjects'] = implode('#',$subjects);
        $ret = Plugin::setAllSettings($settings, 'djg_cf');
        if ($ret)
            Flash::set('success', __('The settings have been updated.'));
        else
            Flash::set('error', 'An error has occurred while trying to save the settings.');
        redirect(get_url('plugin/djg_cf/settings'));
	}
	function session()
	{
		if( !isset($_GET['captcha']) or (!$_SESSION['captcha_id']) ): 
			echo 'false'; 
		else:
			echo ($_SESSION['captcha_id'] == md5($_GET['captcha'])) ? "true": "false";
		endif;
		//exit();
	}
	function djg_cf_send_email()
	{
		if( ($_REQUEST) && (!empty($_REQUEST['name'])) && (!empty($_REQUEST['email'])) && (!empty($_REQUEST['message'])) )
		{
			$email_to	= Plugin::getSetting('emailAdress', 'djg_cf');
			$name		= $_REQUEST['name'];  
			$email		= $_REQUEST['email'];
			$message	= $_REQUEST['message'];
			$subject	= Plugin::getSetting('subjectPrefix', 'djg_cf');

			$msg =   __('Massage from:') .' '. $name;
			$msg .= "\r\n";
			if( Plugin::getSetting('subject', 'djg_cf') == '1'){$msg .= __('The Subject:') .' '. $_REQUEST['subject']; $msg .= "\r\n";}
			$msg .= __('The Message:') .' '. $message;
			$msg .= "\r\n";

			$headers  = "From: $email\r\n";
			$headers .= "Reply-To: $email\r\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/plain; charset=utf-8\n";
			$headers .= "Content-Transfer-Encoding: quoted-printable\n";
			
			if(mail($email_to, $subject, $msg, $headers))
			{	
				$json['error'] = 0;
				
			}else{
				$json['error'] = 1;
				$json['msg'] = 'mail function arror';
			}
		}
		else
		{
			$json['error'] = 1;
			$json['msg'] = 'no REQUEST';
		}	
		echo json_encode($json);
		exit();	
	} // end function
}