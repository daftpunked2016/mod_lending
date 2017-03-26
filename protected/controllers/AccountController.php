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

	public function actionSettings()
	{
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$user = $account->user;
		$account->setScenario("updateAccount");

		#Method set scenario rules
		if (!empty($_POST['Account']['current_password']) || !empty($_POST['Account']['new_password']) || !empty($_POST['Account']['confirm_password'])) {
			$account->setScenario("changePwd");
		}

		if (isset($_POST['Account']) && isset($_POST['User'])) {
			$account->attributes = $_POST['Account'];
			$user->attributes = $_POST['User'];

			$valid = $account->validate();
			$valid = $user->validate() && $valid;

			if ($valid) {

				#Method change password
				if (!empty($_POST['Account']['new_password'])) {
					$account->salt = Account::model()->generateSalt();
					$account->password = Account::model()->hashpassword($account->new_password, $account->salt);
				}

				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($account->save(false)) {
						if ($user->save()) {
							$transaction->commit();
							Yii::app()->user->setFlash('success', 'Update Account Successful!');
							$this->redirect(array('account/settings'));
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Update Account Failed!');
					$this->redirect(array('account/settings'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Validation failed. Please check the required fields and try again.');
			}
		}

		#Method assigning
		if ($account->account_type == "B") {
			$user->business_category = $user->business_type->cat_id;
		}

		$this->render('settings', array(
			'account' => $account,
			'user' => $user
		));
	}
}