<?php
class AjaxController extends CController
{
	public function actionNamecheck()
	{
		$name_exists = User::model()->findByAttributes(array('name'=>$_GET['name']));
		if ( $name_exists ) { echo 'false'; } else { echo 'true'; }
		exit;
	}
}