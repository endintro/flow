<?php
class SiteController extends CController
{
	private $_model;
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$user1 = User::model()->findByPk('15');
		$this->render('index',array(
			'user1'=>$user1,
		));
	}
}