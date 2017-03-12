<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username = strtolower($this->username);
		$account = Account::model()->isApproved()->find('LOWER(username)="'.$username.'" AND account_type = "A"');

		if(empty($account)) {
			Yii::app()->user->setFlash('error', 'Account Invalid');	
		} else if(!$account->validatePassword($this->password)) {
			echo $account->validatePassword($this->password);
			Yii::app()->user->setFlash('error', 'Email / Password is Invalid');	
		} else {
			$this->_id = $account->id;
			$this->username = $account->username;
			$this->errorCode = self::ERROR_NONE;
		}
		
		return $this->errorCode == self::ERROR_NONE;
	}
	
	/**
	 * Override getId() method
	 */
	public function getId()
	{
		return $this->_id;
	}
}