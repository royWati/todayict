<?php
require_once("db.php");
global $db;
class Header{

	public static function reviews(){
		global $db;

		$get_reviews=$db->GetArray('SELECT * FROM reviews_categories where active_status=1');

		foreach ($get_reviews as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li> 
			<?php
		}
	}
	public static function news(){
		global $db;
		$get_news=$db->GetArray('SELECT * FROM news_categories where active_status=1');

		foreach ($get_news as $row) {
			?>
			<li><a ><?php echo $row['category'];?></a></li>
			<?php
		}
	}
	public static function cars(){
		global $db;
		$get_cars=$db->GetArray('SELECT * FROM cars_categories where active_status=1');

		foreach ($get_cars as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}
	public static function how_to(){
		global $db;
		$get_how_to=$db->GetArray('SELECT * FROM how_to_categories where active_status=1');

		foreach ($get_how_to as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}
	public static function smarthome(){
		global $db;
		$get_smarthome=$db->GetArray('SELECT * FROM smart_home_categories where active_status=1');

		foreach ($get_smarthome as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}
	public static function deals(){
		global $db;
		$get_deals=$db->GetArray('SELECT * FROM deals_categories where active_status=1');

		foreach ($get_deals as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}
	public static function video(){
		global $db;
		$get_video=$db->GetArray('SELECT * FROM video_categories where active_status=1');

		foreach ($get_video as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}
	public static function shop(){
		global $db;
		$get_shop=$db->GetArray('SELECT * FROM shop_categories where active_status=1');

		foreach ($get_shop as $row) {
			?>
			<li><a><?php echo $row['category']; ?></a></li>
			<?php
		}
	}

}


?>