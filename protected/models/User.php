<?php

class User extends CActiveRecord
{
	
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