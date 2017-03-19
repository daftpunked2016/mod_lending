<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property string $id
 * @property string $account_type
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $date_created
 * @property string $date_updated
 * @property string $status
 */
class Account extends CActiveRecord
{
	public $new_password; 
	public $confirm_password; 
	public $current_password;
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_DISABLED = "D";
	CONST STATUS_REJECTED = "R";
	CONST BORROWER = "B";
	CONST INVESTOR = "I";
	CONST ADMIN = "A";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, account_type', 'required'),
			array('username', 'unique'),
			array('username', 'email'),
			array('username', 'validateNewUsername', 'on' => 'createNewAccount'),
			array('username', 'validateNewUsername', 'on' => 'updateAccount'),
			array('username', 'validateAdminNewUsername', 'on' => 'updateAdminAccount'),

			array('password, confirm_password', 'required', 'on' => 'createNewAccount'),
			array('current_password, new_password, confirm_password', 'required', 'on' => 'changePwd, changeAdminPwd'),
			array('current_password', 'findPasswords', 'on' => 'changePwd'),
			array('current_password', 'findAdminPasswords', 'on' => 'changeAdminPwd'),
			array('confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>'New password doesn\'t match!', 'on'=>'changePwd, changeAdminPwd'),
			array('confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>'Passwords doesn\'t match!', 'on'=>'createNewAccount'),
			
			array('password', 'length', 'min'=>8, 'max'=>16, 'on'=>'createNewAccount'),
			array('new_password, confirm_password', 'length', 'min'=>8, 'max'=>16, 'on'=>'changePwd, changeAdminPwd'),
			array('username', 'length', 'max'=>40),

			// array('account_type, username, password, salt, date_created', 'required'),
			array('account_type, status', 'length', 'max'=>1),
			// array('username, password', 'length', 'max'=>64),
			array('salt', 'length', 'max'=>11),
			array('date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_type, username, password, salt, date_created, date_updated, status', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
	{
		return array(
			'isPending' => array(
				'condition' => 't.status = "'.self::STATUS_PENDING.'"',
			),

			'isApproved' => array(
				'condition' => 't.status = "'.self::STATUS_APPROVED.'"',
			),
			
			'isDisabled' => array(
				'condition' => 't.status = "'.self::STATUS_DISABLED.'"',
			),

			'isRejected' => array(
				'condition' => 't.status = "'.self::STATUS_REJECTED.'"',
			),

			'isBorrower' => array(
				'condition' => 't.account_type = "'.self::BORROWER.'"',
			),
			
			'isInvestor' => array(
				'condition' => 't.account_type = "'.self::INVESTOR.'"',
			),

			'isAdmin' => array(
				'condition' => 't.account_type = "'.self::ADMIN.'"',
			),

			'isUser' => array(
				'condition' => 't.account_type != "'.self::ADMIN.'"',
			),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::HAS_ONE, 'User', 'account_id'),
		);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				$this->salt = $this->generateSalt();
				$this->status = "P"; #Pending Account -- For approval of admin account
				$this->password = $this->hashPassword($this->password,$this->salt);
			} else {
				$this->date_updated = date('Y-m-d H:i');
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_type' => 'Account Type',
			'username' => 'Email',
			'password' => 'Password',
			'new_password' => 'New Password',
			'confirm_password' => 'Confirm Password',
			'salt' => 'Salt',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('account_type',$this->account_type,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
	
	/**
	 * Generate salt for safer encryption
	 */
	public function generateSalt()
	{
		// Simple timestamp. Needs to be worked on to make site more secure
		return time();
	}
	
	/*
	 * Create hashed password
	 */
	public function hashPassword($password,$salt)
	{
		//Used to encrypt the password
		//You can either use sha1, sha2 or sha256
		//md5 not that secure anymore
		return sha1($password.$salt);
	}

	public function validateNewUsername($attribute, $params)
	{
		$id = Yii::app()->user->id;		

		if ($this->username != "") {

			if (!$this->hasErrors()) {

				if(!filter_var($this->username,FILTER_VALIDATE_EMAIL)) {
					$this->addError('username','Please use a valid email address.');
				} else {
					$account=Account::model()->find(array(
						'condition'=>'username=:username',
						'params'=>array(
							':username'=>$this->username
						)
					));

					$account2 = Account::model()->findByPk($id);
					
					if($account !== null) {
						if($account->username !== $account2->username) {
							$this->addError($attribute,'Email address is already in use.');
						}
					}
				}
			}
		}
	}

	public function validateAdminNewUsername($attribute, $params)
	{
		$id = Yii::app()->getModule('admin')->user->id;		

		if ($this->username != "") {

			if (!$this->hasErrors()) {

				if(!filter_var($this->username,FILTER_VALIDATE_EMAIL)) {
					$this->addError('username','Please use a valid email address.');
				} else {
					$account=Account::model()->find(array(
						'condition'=>'username=:username',
						'params'=>array(
							':username'=>$this->username
						)
					));

					$account2 = Account::model()->findByPk($id);
					
					if($account !== null) {
						if($account->username !== $account2->username) {
							$this->addError($attribute,'Email address is already in use.');
						}
					}
				}
			}
		}
	}

	public function findPasswords($attribute, $params)
    {
        $account= Account::model()->findByPk(Yii::app()->user->id);

        if (!$this->validatePassword($this->current_password)) {
        	$this->addError($attribute, 'Old password is Incorrect.');
        }
    }

    public function findAdminPasswords($attribute, $params)
    {
        $account= Account::model()->findByPk(Yii::app()->getModule('admin')->user->id);

        if (!$this->validatePassword($this->current_password)) {
        	$this->addError($attribute, 'Old password is Incorrect.');
        }
    }
}
