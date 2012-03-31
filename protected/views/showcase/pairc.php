<style>
body{}
#floor1{bottom: 51px; position:fixed; width:100%; background:url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/pairc/floor1.png") repeat-x; box-shadow:0 -5px 10px #333;}
#hero{position:relative; margin:0 auto; width:498px;}

#footer {background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/pairc/footer.png") repeat; bottom: 0; height:51px; position:fixed; width:100%; z-index:3;}
</style>



<div id="outer">
	<div id="floor1">
		<div id="hero"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/pairc/hero.png" /></div>
	</div>
	<div id="footer"></div>
</div>




<script>
	$(document).ready(function(){		
		//move outside container
		var outer = $("#outer").clone();
		$("#outer").remove();
		outer.appendTo("body");	
		
	});
</script>