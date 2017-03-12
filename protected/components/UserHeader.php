<?php
/* add variables or conditions if need */
	class UserHeader extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$id = Yii::app()->user->id;
			$user = User::model()->find(array('condition' => 'account_id = :aid', 'params'=>array(':aid'=>$id)));

			$account_type = "";
			if ($user->account->account_type == "I") {
				$account_type = "INVESTOR";
			} else {
				$account_type = "BORROWER";
			}

			$this->render("user_header",array(
				'user' => $user,
				'account_type' => $account_type
			));
		}
	}
?>