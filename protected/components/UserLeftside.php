<?php
/* add variables or conditions if need */
	class UserLeftside extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{
			$account = Account::model()->findByPk(Yii::app()->user->id);

			if ($account->account_type == "I") {
				$this->render('investor_leftside', array(

				));
			} else {
				$this->render('borrower_leftside', array(

				));
			}
		}
	}
?>