<style>
ul{list-style:none; margin:50px 0 0 0;}
ul li a{font-size:18px; line-height:28px;}
</style>

<ul>
<?php
foreach ($list as $li){
	echo '<li><a href="'.Yii::app()->request->baseUrl.'/showcase/?p='.$li.'">'.$li.'</a></li>';
}
?>
</ul>