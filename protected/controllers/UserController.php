<?php
class UserController extends CController
{		
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
				$model->auth = self::cookieSum($name.$password.'endintro');
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
			$password = $request->getPost("password");
			if($name && $password){
				$user_exists = User::model()->findByAttributes(array('name'=>$name,'password'=>md5($password)));		
				if($user_exists){
					$auth = self::cookieSum($name.$password.'endintro');
					self::save_user_cookie($auth);
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
		$cookie->expire = time()+60*60*24*30;
		Yii::app()->request->cookies['auth']=$cookie;
	}
	
	protected function delete_user_cookie($name){
		$cookie = Yii::app()->request->getCookies();
		unset($cookie[$name]);
	}
	
	protected function cookieSum($str){
		return md5($str); 
	}
}