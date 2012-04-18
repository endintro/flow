<style>
	form{margin-top:200px;}
</style>


	<form action="<?php echo Yii::app()->baseUrl .'/user/login' ?>" method="post" class="well form-inline">
        <input type="text" name="name" placeholder="Login Name" class="input-medium">
        <input type="password" name="password" placeholder="Password" class="input-medium">

        <button class="btn" type="submit">Sign in</button>
     </form>