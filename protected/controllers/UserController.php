<?php
class UserController extends CController
{	
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
		$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	public function actionRegister()
	{
		$request = Yii::app()->getRequest();
		if($request->isPostRequest){
			$email = $request->getPost("email");
			$name = $request->getPost("name");
			$password = $request->getPost("password");
			if($email && $name && $password){
				$model=new User;
				$model->email = $email;
				$model->name = $name;
				$model->password = $password;
				$model->auth = md5($name);
				if($model->save()){
					self::save_user_cookie($model->auth);
					$this->redirect(Yii::app()->request->getBaseUrl(true));
				}
			}
		}
		$this->render('register');
	}
	
	public function actionLogin()
	{
		$request = Yii::app()->getRequest();
		if($request->isPostRequest){
			$name = $request->getPost("name");
			$password = md5($request->getPost("password"));
			if($name && $password){
				$user_exists = User::model()->findByAttributes(array('name'=>$name,'password'=>$password));		
				if($user_exists){
					self::save_user_cookie(md5($name));
				}
			}
		}
		$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	public function actionLogout()
	{
		self::delete_user_cookie("auth");
		$this->redirect(Yii::app()->request->getBaseUrl(true));
	}
	
	protected function save_user_cookie($name){
		$cookie = new CHttpCookie('auth',$name);
		$cookie->expire = time()+60*60*24;
		Yii::app()->request->cookies['auth']=$cookie;
	}
	
	protected function delete_user_cookie($name){
		$cookie = Yii::app()->request->getCookies();
		unset($cookie[$name]);
	}
}