<?php
class TestController extends CController
{
	private $_model;
	
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		echo 'TestController';
	}
	
	public function actionTest()
	{
		$this->render('test');
	}
	
}