
	<form action="<?php echo Yii::app()->baseUrl .'/user/login' ?>" method="post" class="well form-inline">
        <input type="text" name="name" placeholder="Login Name" class="input-medium">
        <input type="password" name="password" placeholder="Password" class="input-medium">
        <label class="checkbox">
          <input type="checkbox"> Remember?
        </label>
        <button class="btn" type="submit">Sign in</button>
        <a href="<?php  echo Yii::app()->request->getBaseUrl(true).'/user/register' ?>">Register</a>
     </form>