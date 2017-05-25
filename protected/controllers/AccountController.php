<?php

class AccountController extends Controller
{
	public $layout = '/layouts/user_main';

	public function actionDashboard()
	{
		$account = Account::model()->findByPk(Yii::app()->user->id);
		$account_type = $account->account_type;

		$inbox_count = Message::model()->isSent()->isNotDeleted()->count(array('condition'=>'to_account_id = :account_id', 'params'=>array(':account_id'=>$account->id)));

		if ($account_type == "I") {
			$packages_count = Package::model()->adminPackages()->count();
			$investment_count = Loan::model()->count(array('condition' => 'account_id = :aid', 'params'=>array(':aid'=>$account->id)));
			$open_count = OpenRequest::model()->isOpen()->isApproved()->count();

			$this->render('investor_dashboard', array(
				'inbox_count' => $inbox_count,
				'packages_count' => $packages_count,
				'investment_count' => $investment_count,
				'open_count' => $open_count,
			));
		} else {
			$investments_count = Loan::model()->isApproved()->count(array('condition'=>'t.id NOT IN (SELECT loan_id FROM loan_request WHERE status IN ("A", "P"))'));
			$loan_count = LoanRequest::model()->count(array('condition' => 'borrower_id = :aid', 'params'=>array(':aid'=>$account->id)));
			$open_count = OpenRequest::model()->count(array('condition'=>'borrower_id = :bid', 'params'=>array(':bid'=>$account->id)));

			$this->render('borrower_dashboard', array(
				'inbox_count' => $inbox_count,
				'investments_count' => $investments_count,
				'loan_count' => $loan_count,
				'open_count' => $open_count
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