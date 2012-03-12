<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"  />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"  />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js" type="text/javascript"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<?php echo $content; ?>

</div><!-- page -->

<div id="footer">
	<a href="<?php  echo Yii::app()->request->getBaseUrl(true) ?>"><i class="icon-home icon-white"></i></a>
	<a href="<?php  echo Yii::app()->request->getBaseUrl(true) ?>"><i class="icon-search icon-white"></i></a>
</div>
<script>
$(document).ready(function(){
	$("#footer a i").hover(function(){
			$(this).css("opacity","0.3");
		},function(){
			$(this).css("opacity","1");
	});
	
});
</script>

</body>
</html>