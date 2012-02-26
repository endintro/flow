<style>
.form-actions{background:none;}
legend{margin-bottom:0;}
</style>

<form action="" method="post" id="register" class="form-horizontal">
	<fieldset>
		<legend>Register</legend>
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
					To form a secure password, we recommend including a combination of letters and numbers.
				</p>
			</div>
		</div>
		<div class="control-group">
			<label for="input01" class="control-label">Email</label>
			<div class="controls">
				<input type="text" name="email" class="input-large">
			</div>
		</div>
		<div class="form-actions">
			<input class="btn btn-primary" type="submit" value="Submit" />
			<input class="btn" type="reset" value="Reset" />
		</div>
	</fieldset>
</form>

  
<script src="<?php echo Yii::app()->baseUrl . '/js/jquery.validate.min.js'?>"></script>
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