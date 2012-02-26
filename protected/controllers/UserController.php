<?php
class UserController extends CController
{	
	public function actionIndex()
	{

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
				if($model->save()){
					self::save_user_cookie($name);
					$this->redirect(array('index'));
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
					self::save_user_cookie($name);
					$this->redirect(array('index'));
				}
			}
		}
		$this->render('login');
	}
	
	protected function save_user_cookie($name){
		$cookie = new CHttpCookie('username',$name);
		$cookie->expire = time()+60*60*24;
		Yii::app()->request->cookies['username']=$cookie;
	}
}