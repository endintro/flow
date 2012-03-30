<style>

body{background:#d9d9d9;}

#triangle-bottomright {
	width: 0;
	height: 0;
	border-bottom: 100px solid black; 
	border-left: 100px solid transparent;
	opacity:0.3;
	filter: alpha(opacity=30);
	position:absolute;
	bottom:23px;
	left:86px;
}
#pillar{width:86px; height:0px; background:url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/silence/pillar.png") repeat-y; position:fixed; bottom:139px ;}
#woman{bottom:18px; width:86px; height:121px; position:fixed; z-index:2;}
#footer {background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/silence/footer.png") repeat; bottom: 0; height:23px; position:fixed; width:100%; z-index:3;}
</style>



<div id="outer">
	<div id="triangle-bottomright"></div>
	<div id="pillar"></div>
	<div id="woman"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/silence/woman.png" /></div>
	<div id="footer"></div>
</div>




<script>
	$(document).ready(function(){		
		//move outside container
		var outer = $("#outer").clone();
		$("#outer").remove();
		outer.appendTo("body");	

		//draw a css Triangle cover
		resizeTriangle();
		$(window).resize(resizeTriangle);
		
	});

	function resizeTriangle(){
		var height = $(window).height();
		var width  = $(window).width();
		
		var pillarHeight = height-139;
		$("#pillar").css("height",pillarHeight+"px");

		height     = height - 23;
		width	   = width - 86;
		$("#triangle-bottomright").css("border-bottom",height+"px solid black");
		$("#triangle-bottomright").css("border-left",width+"px solid transparent");
	}
</script>