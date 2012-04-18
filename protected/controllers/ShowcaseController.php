<?php
class ShowcaseController extends CController
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
	
	
	public function actionIndex(){
		$list = array("private","silence","pairc","classroom");
		$request = Yii::app()->getRequest();
		if($request->getParam("p")){
			$project = $request->getParam("p");
			if(in_array( $project, $list)) $this->render($project);
			else $this->render("index",array("list"=>$list));
			
		}else{
			$this->render("index",array("list"=>$list));
		}
	}
}