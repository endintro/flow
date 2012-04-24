<style>
#container {
	height:600px;
	width:600px;
	margin:20px auto -2px;
	border:0px solid #fff;
	position:relative;
}
.reg {
	border-style:solid;
	height:0px;
	width:0px;
	border-color:#FFF;
	border-style:solid;
	border-width:300px;
	-moz-border-radius:300px;
	-webkit--border-radius:300px;
	border-radius: 600px;
	background-color:#FFF;
	z-index:-1;
	position:absolute;
	overflow: hidden;
	left:0;
	top:0;
}
#bar {
	height:700px;
	width:165px;
	margin:0 auto;
	position:relative;
	background:url('<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/lolipop/Lollipop-large.jpg');
}
</style>


<div id="container"></div>
<div id="bar"></div>
<div class="clear"></div>


<script>
$(document).ready(function(){
	intervalID = setInterval(draw, 10);
});

var intervalID = 0;
var width = 300;
var rgb = 255;
var colors = new Array("#91AD70","#F4A7B9","#F17C67","#F75C2F","#FFB11B","#FBE251","#BEC23F","#91B493","#5DAC81","#268785","#8A6BBE","#66327C","#E03C8A");

function draw(){
	if(width === 46){
		clearInterval(intervalID);
		//intervalID = setInterval(move, 10);
	}
	
	var html = 	'<div class="reg">'+
            	'</div>';

    $('#container').append(html);

    var obj = $('#container div:last');

	width = width - 2;
	var vleft = 300 - width;
	var vtop = 300 - width;
	var randColor = colors[Math.ceil(Math.random()*100)%14];

	obj.css("border-color",randColor);
	obj.css("border-width",width+'px');
	obj.css("left",vleft+'px');
	obj.css("top",vtop+'px');
}
</script>