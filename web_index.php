<?php 
	
	$con = mysql_connect("172.30.41.210","dingxs","");
	if (!$con){
	        die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("news_stat", $con);
	mysql_query("SET CHARACTER SET UTF8");

	$related_info_table = 'related_info_'.date("Ym");
	$data_table = 'data_'.date("Ym");

	$tags = getTag();
	foreach($tags as $tag){

		$postamount = 0;
		$viewamount = 0;
		$replyamount = 0;
		$reproduceamount = 0;
		$postrate = 0;
		$viewrate = 0;
		$replyrate = 0;
		$reproducerate = 0;

		$data_ids = get_related_info($tag,$related_info_table);
		foreach($data_ids as $data_id){
			$sql = "select * from {$data_table} where id='{$data_id}'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result,MYSQL_ASSOC);
			if($row["release_date"] > date("Y-m-d H:i:s",strtotime("-7 day"))){
				$postamount = $postamount + 1;
				$viewamount = $viewamount + $row["click_count"];
				$replyamount = $replyamount + $row["comment_count"];
				$reproduceamount = $reproduceamount + $row["repeat_count"];
			}
		}

		$create_time = date("Y-m-d");	
		$weekday = array(1,2,3,4,5,6,7);
		if( !in_array(date("d"),$weekday)){
			$yesterday_time = date("Y-m-d",strtotime('-1 d',strtotime($create_time)));
			$sql1 = "select * from web_index where tag='{$tag}' and create_time = '{$yesterday_time}'";
			$result1 = mysql_query($sql1);
			if($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)){
				$postrate = abs($row1["postamount"] -  $postamount);
				$viewrate = abs($row1["viewamount"] -  $viewamount);
				$replyrate = abs($row1["replyamount"] -  $replyamount);
				$reproducerate = abs($row1["reproduceamount"] -  $reproduceamount);
			}
		}
		
		$news = new news($postamount,$viewamount,$replyamount,$reproduceamount,$postrate,$viewrate,$replyrate,$reproducerate);

		$sql2 = "insert into web_index (tag, web_index, postamount, viewamount, replyamount, reproduceamount, postrate, viewrate, replyrate, reproducerate, create_time) values ('{$tag}','{$news->webindex}','{$postamount}','{$viewamount}','{$replyamount}','{$reproduceamount}','{$postrate}','{$viewrate}','{$replyrate}','{$reproducerate}','{$create_time}')";
		$result2 = mysql_query($sql2);

		echo $tag."\n";
	}

	function get_related_info($tag,$related_info_table){
		$data_ids = array();
		$sql = "select * from {$related_info_table} where tag='{$tag}' ";

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			$data_ids[] = $row["data_id"];
		}
		return $data_ids;
	}

	function getTag(){
		$tags = array();
		$sql = "select * from category";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			$tags[] = $row["first_category"].$row["category"];
		}
		$sql = "select * from category group by first_category";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			$tags[] = $row["first_category"];
		}
		return $tags;
	}

	





//新闻通道
class news{
	private $postamount_IndexRange 		= array(500,100,50,10);
	private $postrate_IndexRange 		= array(500,100,50,10);
	private $viewamount_IndexRange		= array(1000000,100000,10000,1000);
	private $viewrate_IndexRange		= array(100000,10000,1000,100);
	private $replyamount_IndexRange 	= array(100000,10000,1000,100);
	private $replyrate_IndexRange   	= array(10000,1000,100,10);
	private $reproduceamount_IndexRange = array(1000,500,100,10);
	private $reproducrate_IndexRange 	= array(500,100,50,10);
	
	public $postamount;				//发帖数
	public $postrate;				//发帖数变化率
	public $viewamount;				//点击数
	public $viewrate;				//点击数变化率
	public $replyamount;			//回帖数
	public $replyrate;				//回帖数变化率
	public $reproduceamount;		//转发数
	public $reproducrate;			//转发数变化率
	public $webindex;				//新闻通道舆情信息活性
	
	public function __construct($postamount,$postrate,$viewamount,$viewrate,$replyamount,$replyrate,$reproduceamount,$reproducrate) {
        $this->postamount 		= self::range($postamount,"postamount");
        $this->postrate 		= self::range($postrate,"postrate");
        $this->viewamount 		= self::range($viewamount,"viewamount");
        $this->viewrate			= self::range($viewrate,"viewrate");
        $this->replyamount 		= self::range($replyamount,"replyamount");
        $this->replyrate 		= self::range($replyrate,"replyrate");
        $this->reproduceamount 	= self::range($reproduceamount,"reproduceamount");
        $this->reproducrate 	= self::range($reproducrate,"reproducrate");
        $this->webindex			= self::webIndex();
    }
	
	public function range($num,$name){
		$str = $name.'_IndexRange';
		if(is_numeric($num) && isset($this->{$str})){
			if($num > $this->{$str}[0])
				return 1;
			else if($num > $this->{$str}[1])
				return 2;
			else if($num > $this->{$str}[2])
				return 3;
			else if($num > $this->{$str}[3])
				return 4;
			else
				return 5;
		}else{
			return 0;
		}
	}
	
	public function webIndex(){
		$sum 	= 0;
		$count 	= 0;
		if($this->postamount !=0){
			$sum 	= $sum + $this->postamount;
			$count 	= $count + 1;
		}
		if($this->postrate !=0){
			$sum 	= $sum + $this->postrate;
			$count 	= $count + 1;
		}
		if($this->viewamount !=0){
			$sum 	= $sum + $this->viewamount;
			$count 	= $count + 1;
		}
		if($this->viewrate !=0){
			$sum 	= $sum + $this->viewrate;
			$count 	= $count + 1;
		}
		if($this->replyamount !=0){
			$sum 	= $sum + $this->replyamount;
			$count 	= $count + 1;
		}
		if($this->replyrate !=0){
			$sum 	= $sum + $this->replyrate;
			$count 	= $count + 1;
		}
		if($this->reproduceamount !=0){
			$sum 	= $sum + $this->reproduceamount;
			$count 	= $count + 1;
		}
		if($this->reproducrate !=0){
			$sum 	= $sum + $this->reproducrate;
			$count 	= $count + 1;
		}
		return $sum/$count;
	}
}


//时间延续性
class continuity{
	private $continuity_IndexRange 		= array(360,90,30,10);
	
	public $continuity;			//舆情信息时间延续程度
	
	public function __construct($continuity) {
        $this->continuity 		= self::range($continuity,"continuity");
    }
	
	public function range($num,$name){
		$str = $name.'_IndexRange';
		if(is_numeric($num) && isset($this->{$str})){
			if($num > $this->{$str}[0])
				return 1;
			else if($num > $this->{$str}[1])
				return 2;
			else if($num > $this->{$str}[2])
				return 3;
			else if($num > $this->{$str}[3])
				return 4;
			else
				return 5;
		}else{
			return 0;
		}
	}
}

?>