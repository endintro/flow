<?php echo 'hello '.$user->name?>
<br />
<a href="<?php  echo Yii::app()->request->getBaseUrl(true).'/user/logout' ?>">logout</a>