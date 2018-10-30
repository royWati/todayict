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
}


?>