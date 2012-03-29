<style>
body{background:#eff0e8;}
#window {bottom: 500px; width:152px; height:160px; position:fixed;}
#notice {bottom:40px; width:65px; height:131px; position:fixed; z-index:2;}
#notice img{position:relative; left:800px;}
#footer {background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/floor.png") repeat-x; bottom: 0; height:63px; position:fixed; width:100%; z-index:1;}
</style>


<div id="window"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/window.png" /></div>
<div id="notice"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/notice.png" /></div>
<div id="footer"></div>


<script>
	$(document).ready(function(){		
		//move footer outside container
		var footer = $("#footer").clone();
		$("#footer").remove();
		footer.appendTo("body");	
	});
</script>