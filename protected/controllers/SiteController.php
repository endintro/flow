<?php
class SiteController extends CController
{
	private $_model;
	private $is_login = false;
	private $user;
	
	public function filters()
	{
		return array(
			'authFilter',
		);
	}
 
	public function FilterAuthFilter($filterChain) {
		$cookie = Yii::app()->request->getCookies();
		if(isset($cookie['auth'])){
			$user_exists = User::model()->findByAttributes(array('auth'=>$cookie['auth']->value));	
			if($user_exists){
				$this->is_login = true;
				$this->user = $user_exists;
			}
		}
		$filterChain->run();
	}
	
	
	public function actionIndex()
	{
		if($this->is_login){
			$flows = Flow::model()->findAllByAttributes(array('user_id'=>$this->user->id,'is_actived'=>1));
			$this->render('true_index',array('user'=>$this->user,'flows'=>$flows));
		}else
			$this->render('index');
	}
}