<?php $this->pageTitle = '注册新用户';?>
<style>
body{background:#eff0e8;}
#window {bottom: 450px; width:152px; height:160px; position:fixed;}
#notice {bottom:40px; width:65px; height:131px; position:fixed; z-index:2;}
#notice img{position:relative; left:800px;}
#footer {background: url("<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/floor.png") repeat-x; bottom: 0; height:63px; position:fixed; width:100%; z-index:1;}

form#register{bottom: 320px; position:fixed; margin-left:200px;}
.form-actions{background:none;}

</style>



<div id="window"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/window.jpg" /></div>
<div id="notice"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/showcase/private/notice.png" /></div>
<div id="footer"></div>


<form action="" method="post" id="register" class="form-horizontal">
	<fieldset>
		<div class="control-group">
			<label for="input02" class="control-label">Login Name</label>
			<div class="controls">
				<input type="text" name="name" class="input-large">
				<p class="help-block">
					Your login name, must be unique
				</p>
			</div>
		</div>
		<div class="control-group">
			<label for="input03" class="control-label">Password</label>
			<div class="controls">
				<input type="password" name="password" class="input-large">
				<p class="help-block">
					Recommend including a combination of letters and numbers
				</p>
			</div>
		</div>
		<div class="control-group">
			<label for="input01" class="control-label">Email</label>
			<div class="controls">
				<input type="text" name="email" class="input-large">
				<input type="hidden" name="redirect" value="<?php echo $redirect?>">
			</div>
		</div>
		<div class="form-actions">
			<input class="btn" type="submit" value="Register" />
			<input class="btn" type="reset" value="Reset" />
		</div>
	</fieldset>
</form>

<script>
	$(document).ready(function(){		
		//move footer outside container
		var footer = $("#footer").clone();
		$("#footer").remove();
		footer.appendTo("body");	
	});
</script>
<script src="<?php  echo Yii::app()->baseUrl . '/js/jquery.validate.min.js'?>"></script>
<script>
	$(document).ready(function(){
			jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {   
			  var length = value.length;   
			  for(var i = 0; i < value.length; i++){   
			   if(value.charCodeAt(i) > 127){   
			    length++;   
			   }   
			  }   
			  return this.optional(element) || ( length >= param[0] && length <= param[1] );   
			}, "请确保输入的值在3-15个字节之间(一个中文字算2个字节)");
			
			jQuery.validator.addMethod("userName", function(value, element) {   
			  return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);   
			}, "用户名只能包括中文字、英文字母、数字和下划线");  

			$("#register").validate({     
				rules: {   
				   name: {   
				    required: true,   
				    userName: true,   
				    byteRangeLength: [3,15],
				    remote: "/ajax/namecheck",   
				   }, 
				   password: {   
				    required: true,  
				   },   
				   email: {   
				    required: true,  
				    email: true
				   },   
				},  

				messages: {   
				   name: {   
				    required: "请填写用户名",   
				    byteRangeLength: "用户名必须在3-15个字符之间(一个中文字算2个字符)",
				    remote:"该用户名已被使用",   
				   },   
				   password: {   
				    required: "请填写密码", 
				   },  
				   email: {   
				    required: "请填写邮箱", 
				    email: "请填写正确的邮箱地址",
				   }, 
				},

				errorPlacement: function(error, element) { 
					error.insertAfter( element );   
				}, 
				errorElement: "span",
				errorClass: "help-inline",
			});
	})
</script>