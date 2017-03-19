<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
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

		$account = Account::model()->find(array('condition'=>'username = :s AND account_type IN ("B", "I")', 'params'=>array(':s'=>$username)));

		if (empty($account)) {
			Yii::app()->user->setFlash('error', 'Invalid Account or Account not yet Registered.');
		} else if ($account->validatePassword($this->password)) {
			switch ($account->status) {
				case 'P':
					Yii::app()->user->setFlash('error', 'Pending Account. Please wait for the Approval of System Administrator before you can logged in your account.');
					break;
				case 'A':
					$this->_id = $account->id;
					$this->username = $account->username;
					$this->errorCode = self::ERROR_NONE;
					break;
				case 'D':
					Yii::app()->user->setFlash('error', 'Disabled Account. Please contact System Administrator.');
					break;
				case 'R':
					Yii::app()->user->setFlash('error', 'Rejected Account. Please contact System Administrator.');
					break;
			}
		} else {
			Yii::app()->user->setFlash('error', 'Username or Password is incorrect.');
		}
		
        return $this->errorCode == self::ERROR_NONE;
	}
	
	public function getId()
    {
        return $this->_id;
    }
}