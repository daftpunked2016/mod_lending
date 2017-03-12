<?php
/* add variables or conditions if need */
	class AdminHeader extends CWidget
	{
		
		public function init()
		{
			
		}
		
		public function run()
		{	
			$id = Yii::app()->getModule('admin')->user->id;
			$user = User::model()->find(array('condition' => 'account_id = :aid', 'params'=>array(':aid'=>$id)));

			$this->render("header",array(
				'user' => $user,
			));
		}
	}
?>