<?php

class User extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $salt
	 * @var string $email
	 * @var string $profile
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'mobile_phone' => 'MobilePhone',
			'level' => 'Level',
			'create_time' => 'CreateTime',
		);
	}
	
	protected function beforeSave() {
		if ($this->isNewRecord) {
			$this->password = md5($this->password);
			$this->create_time = date("Y-m-d H:i:s");
		}
		return true;
	}
}