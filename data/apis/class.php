<?php
require_once('db.php');
require_once('PHPMailer-master/class.phpmailer.php');
require_once('SMS/gateway.php');
class Logs{
	public static function register_log($userid, $action){
		global $db;
		$data = array();
		$data['userid'] = $userid;
		$data['action'] = $action;
		$data['actiontime'] = $db->GetOne("select now();");
		$db->AutoExecute('sims_logs',$data, 'INSERT');
	}
}

class SMS{
	public static function sendSMS($recipients, $message){
		$username = "liam_solu";
		$apikey = "84ea72ab6dda34aacdcbeca06a02706f70507563ca751c4cd0cd41e3eb499f02";
		//$from = "THIRD_MTP";
		$gateway = new AfricasTalkingGateway($username, $apikey);
		try 
		{ 
		  $results = $gateway->sendMessage($recipients, $message);	
		 // $results = $gateway->sendMessage($recipients, $message, $from);	
		  foreach($results as $result) {
			/*echo " Number: " .$result->number;
			echo " Status: " .$result->status;
			echo " MessageId: " .$result->messageId;
			echo " Cost: "   .$result->cost."\n";*/
		  }
		}
		catch ( AfricasTalkingGatewayException $e )
		{
		  echo "Encountered an error while sending: ".$e->getMessage();
		}
	}
}

class Documents{
	public static function check_extesion($file){
		
	}
	public static function getfile_extension($filename){
		return substr(strrchr($filename, '.'), 1);
	}
}

class Sector{
	public static function get_sectorname($id){
		global $db;
		return ($db->GetOne("select sector from  sims_sectors where sectorid = {$id}"));
	}
}

class User{
	public static function get_details($email){
		global $db;
		$row = $db->GetRow("select * from  sims_app_users where email = '$email'");
		$details = array();
		$details["user_details"]["id"] = $row["UserID"];
		$details["user_details"]["mobile"] = $row["mobile"];
		$details["user_details"]["sector"] = $row["sector"];
		$details["user_details"]["email"] = $row["email"];
		return $details;
	}
	public static function get_details_id($id){
		global $db;
		$row = $db->GetRow("select * from  sims_app_users where UserID = {$id}");
		$details = array();
		$details["user_details"]["names"] = $row["names"];
		$details["user_details"]["mobile"] = $row["mobile"];
		$details["user_details"]["email"] = $row["email"];
		if(!file_exists("./data/apis/uploads/members/" . $row["photo"] . ".png")){
				$details["user_details"]["photo"] = "./data/apis/uploads/members/" . $row["photo"] . ".png";//'data:image/png;base64,$row["userphoto"]';
			}else{
				$details["user_details"]["photo"] = "./data/apis/uploads/members/" . $row["photo"] . ".png";//'data:image/png;base64,$row["userphoto"]';
			}
		return $details;
	}
	
	public static function get_departmentname($id){
		global $db;
		return ($db->GetOne("select Department from  sims_app_userdepartments where DepartmentID = {$id}"));
	}
	
	public static function get_sector_members($sector){
		global $db;
		$results = $db->GetArray("select * from sims_app_users where sector = '" . $sector . "'");
		return $results;
	}
	
	public static function update_userdata_change_sector($id, $sector){
		global $db;
		$data = array();
		$data['sector'] = $sector;
		$db->AutoExecute('sims_app_users',$data, 'UPDATE', " UserID={$id}");
	}
}

class Mailer {
	public static function send_mail($to_address, $name, $title, $message){
		global $mail;
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->IsSendmail(); // telling the class to use SendMail transport
		$body =('Dear ' . $name . ', '. $message . ' Thank you.');
		$mail->SetFrom('systems@zalegoinstitute.ac.ke', 'School Information Management System');
		$mail->AddAddress($to_address);
		$mail->Subject = ($title); //Email Subject
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->Send();
	}
}
?>
