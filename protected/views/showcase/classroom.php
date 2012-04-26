<style>
body{background:#899c96;}
#wall{top: 0px; position:fixed; width:100%; background:url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/classroom/wall.jpg") repeat-x;}
#hero{position:relative; margin:0 auto; width:598px;}
</style>


<div id="outer">
	<div id="wall">
		<div id="hero"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/classroom/hero.png" /></div>
	</div>
</div>


<script>
	$(document).ready(function(){		
		//move outside container
		var outer = $("#outer").clone();
		$("#outer").remove();
		outer.appendTo("body");	
		
	});
</script>