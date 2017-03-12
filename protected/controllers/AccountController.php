<?php

class AccountController extends Controller
{
	public $layout = '/layouts/user_main';

	public function actionDashboard()
	{
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$account_type = $account->account_type;

		if ($account_type == "I") {
			$this->render('investor_dashboard', array(

			));
		} else {
			$this->render('borrower_dashboard', array(

			));
		}
	}
}