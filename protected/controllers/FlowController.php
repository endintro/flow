<?php
class FlowController extends CController
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
			$request = Yii::app()->getRequest();
			if($request->getParam("f")){
				$flow_id = $request->getParam("f");
				$flow = Flow::model()->findByPk($flow_id);
				if($flow && ($flow->user_id == $this->user->id)){
					if($request->isPostRequest) self::saveWater($request,$flow_id);
					$waters = Water::model()->findAllByAttributes(array('flow_id'=>$flow_id,'is_display'=>1));
					$this->render("index",array("flow"=>$flow,"waters"=>$waters));
				}else 
					$this->redirect(Yii::app()->request->getBaseUrl(true));	
			}
		}else
			$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	public function actionCreate()
	{
		if($this->is_login){
			$request = Yii::app()->getRequest();
			if($request->isPostRequest){
				$name = $request->getPost("name");
				$description = $request->getPost("description");
				if($name && $description){
					$model=new Flow;
					$model->user_id = $this->user->id;
					$model->name = $name;
					$model->description = $description;
					$model->is_actived = 1;
					$model->create_time = date("Y-m-d H:i:s");
					if($model->save()){
						$this->redirect(Yii::app()->request->getBaseUrl(true).'/flow/?f='.$model->id);
					}
				}
			}
		}else
			$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	protected function saveWater($request,$flow_id){
		$water = $request->getPost("water");
		$model=new Water;
		$model->user_id = $this->user->id;
		$model->flow_id = $flow_id;
		$model->water 	= trim($water);
		$model->create_time = date("Y-m-d H:i:s");
		if($model->save()){
			$this->redirect(Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id);
		}
	}
	
	public function actionDeleteWater()
	{
		if($this->is_login){
			$request = Yii::app()->getRequest();
			$flow_id = $_GET["f"];
			if($request->isPostRequest){
				$water_id = $request->getPost("water_id");
				if(is_numeric($water_id)){
					$water = Water::model()->findByPk($water_id);
					if($water){
						$water->is_display = 0;
						$water->save();
					}
				}
			}
			$this->redirect(Yii::app()->request->getBaseUrl(true).'/flow/?f='.$flow_id);
		}else
			$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
}