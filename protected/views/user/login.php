<?php $this->pageTitle = '登录';?>
<style>
body{background:#eff0e8;}
#window {bottom: 450px; width:152px; height:160px; position:fixed;}
#notice {bottom:40px; width:65px; height:131px; position:fixed; z-index:2;}
#notice img{position:relative; left:800px;}
#footer {background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/floor.png") repeat-x; bottom: 0; height:63px; position:fixed; width:100%; z-index:1;}

form#login{bottom: 480px; position:fixed; margin-left:380px;}
.form-actions{background:none;}
a#register{margin-left:20px;}
</style>



<div id="window"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/window.jpg" /></div>
<div id="notice"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/notice.png" /></div>
<div id="footer"></div>


<form action="<?php echo Yii::app()->baseUrl .'/user/login' ?>" method="post" class="well form-inline" id="login">
        <input type="text" name="name" placeholder="Login Name" class="input-medium">
        <input type="password" name="password" placeholder="Password" class="input-medium">
		<input type="hidden" name="redirect" value="<?php echo $redirect?>">
        <button class="btn" type="submit">Sign in</button>
        <a id="register" href="<?php echo Yii::app()->baseUrl .'/user/register?redirect='.$redirect ?>">Register</a>
     </form>

<script>
	$(document).ready(function(){		
		//move footer outside container
		var footer = $("#footer").clone();
		$("#footer").remove();
		footer.appendTo("body");	
	});
</script>