<?php
require_once("db.php");
class App{
	public static function get_title(){
		global $db;
		return $db->GetOne("select ");
	} 
	public static function get_app_details(){
		$details = array();
		$details["app_details"]["name"] = "Mauzo Africa";
		$details["app_details"]["short_name"] = "Mauzo";
		$details["app_details"]["developer"] = "ATFORTECH DYNAMICS";
		$details["app_details"]["copyright"] = "<p class='copyright pull-right'>
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href='#'>ATFORTECH</a> DYNAMICS</p>";
		return $details;
	}


	public static function datatable_display_pagination($per_page, $page, $table, $module,$id){
		global $db;
		$group = $db->GetOne("select ceil(((select count(*) from $table WHERE client_id=$id and active_status=1) / $per_page)) as groups;");
		if ( ($group * 10) >= 10) {
			echo "<ul class='pagination margin-bottom-10' style='padding: 10px;'>"; ?>
				<?php if($page > 1 ) { ?>
					<li class='page-item' > <a href='#' class="page-link"  onclick="open_module('./modules/<?php echo $module; ?>/all.php?page=<?php echo ($page - 1); ?>');"> << Prev </a> </li>
				<?php } ?>
				
			<?php	for($pager = 1; $pager <= $group; $pager ++){
						if($pager == $page){ ?>
							<li class='active page-item'> <a href='#' class="page-link" onclick="open_module('./modules/<?php echo $module; ?>/all.php?page=<?php echo $pager; ?>');"> <?php echo $pager; ?> </a> </li>
						<?php }else{ ?>
							<li class='page-item'> <a href='#' class="page-link" onclick="open_module('./modules/<?php echo $module; ?>/all.php?page=<?php echo $pager; ?>');"> <?php echo $pager; ?> </a> </li>
						<?php }
					} ?>
				<?php if($page != $group ) { ?>
					<li class='page-item' > <a href='#' class="page-link"  onclick="open_module('./modules/<?php echo $module; ?>/all.php?page=<?php echo $group; ?>');"> Last >> </a> </li>
				<?php } ?>
				<?php 
			echo "</ul>";
		}
    }
}


class Logs{
	public static function register_log($userid, $action){
		global $db;
		$data = array();
		$data['userid'] = $userid;
		$data['action'] = $action;
		$data['actiontime'] = $db->GetOne("select now();");
		$db->AutoExecute('pb_logs',$data, 'INSERT');
	}
}



class User{
	public static function get_details($id){
		global $db;
		$row = $db->GetRow("select * from tb_users where user_id = {$id}");
		if($row){
			$details = array();
			$details["user_details"]["name"] = $row["username"];
			$details["user_details"]["id"] = $row["user_id"];
			$details["user_details"]["email"] = $row["email"];
			$details["user_details"]["phone_number"] = $row["phone_number"];
			//$details["user_details"]["department"] = $row["department"];
			
			// if(!file_exists("./data/apis/uploads/users/" . $row["photo"] . ".png")){
			// 	$details["user_details"]["photo"] = "./data/apis/uploads/users/" . $row["photo"] . ".png";//'data:image/png;base64,$row["userphoto"]';
			// }else{
			// 	$details["user_details"]["photo"] = "./data/apis/uploads/users/" . $row["photo"] . ".png";//'data:image/png;base64,$row["userphoto"]';
			// }
			//$details["user_details"]["username"] = $row["names"];
		}
		return $details;
	}
	
	public static function checknew_messages($id){
		global $db;
		return $db->getOne("select count(*) as count from pb_app_messages where recieverid = {$id} and state = 'new'");
	}
	
	public static function get_messages($id){
		global $db;
		$data = $db->GetArray("select * from pb_app_messages where recieverid = {$id}");
		if($data){
			foreach($data as $row){ ?>
				<li class="unread">
					<a href="javascript:;" class="unread" onclick="open_module('./modules/account/messages.php');">
						<div class="clearfix">
							<div class="thread-image">
								<img src="./assets/images/avatar-2.jpg" alt="">
							</div>
							<div class="thread-content">
								<span class="author">Nicole Bell</span>
								<span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula...</span>
								<span class="time"> Just Now</span>
							</div>
						</div>
					</a>
				</li>
			<?php }
		}else{?>
			<div class="thread-content">
				<span class="author">No Messages to Read</span><br/>
				<span class="preview">You have No new messages, If you believe there is a problem with your messages, <a href="#"> Click here </a> to report the problem.</span>
			</div>
		<?php }
	}
}

class SystemData{
	public static function get_userscount(){
		global $db;
		return $db->getOne("select count(*) as count from pb_app_users");
	}
	
	public static function get_documentscount(){
		global $db;
		return $db->getOne("select count(*) as count from pb_documents");
	}
}
?>