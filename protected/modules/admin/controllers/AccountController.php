<?php

class AccountController extends Controller
{
	public $layout = '/layouts/main';

	// $t = type
	// s = status
	public function actionIndex($type, $status)
	{
		if ($type == "I") {
			$account_type = "Investor";
		} else {
			$account_type = "Borrower";
		}

		#Search Filters
		$searchTerms = "";
		$search_array = "";

		if (!empty($_GET['search'])) {
			$search_array = $_GET['search'];

			if (empty($search_array['business_type']) && empty($search_array['name']) && empty($search_array['system_id'])) {
				Yii::app()->user->setFlash('error', 'Search Filters empty. Please try again.');
				$this->redirect(array('account/index', 'type'=>$type, 'status'=>$status));
			}

			if (!empty($search_array['business_type'])) {
				$searchTerms .= " AND u.business_type_id = ".$search_array['business_type'];
			}

			if (!empty($search_array['name'])) {
				$searchTerms .= " AND CONCAT(u.first_name,' ',u.last_name) LIKE '%".$search_array['name']."%'";
			}

			// KEEP THIS TO THE LAST OPTION
			if (!empty($search_array['system_id'])) {
				$searchTerms = " AND u.id_name = '{$search_array['system_id']}'";
			}
		}

		$condition = array('join'=>'INNER JOIN user u ON t.id = u.account_id', 'condition'=>'t.account_type = :s'.$searchTerms, 'params'=>array(':s'=>$type));

		switch ($status) {
			case 'P':
				$page_header = "Pending ".$account_type;
				$accounts = Account::model()->isPending()->findAll($condition);
				break;
			case 'A':
				$page_header = "Approved ".$account_type;
				$accounts = Account::model()->isApproved()->findAll($condition);
				break;
			case 'D':
				$page_header = "Disabled ".$account_type;
				$accounts = Account::model()->isDisabled()->findAll($condition);
				break;
			case 'R':
				$page_header = "Rejected ".$account_type;
				$accounts = Account::model()->isRejected()->findAll($condition);
				break;
		}

		$accountsDP = new CArrayDataProvider($accounts, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$business_category = BusinessCategory::model()->isActive()->findAll();

		$this->render('index', array(
			'type' => $type,
			'status' => $status,
			'accountsDP' => $accountsDP,
			'page_header' => $page_header,
			'business_category' => $business_category,
			'search_array' => $search_array,
		));
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error) {

			if(Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}

	public function actionApprove($id)
	{
		$account = Account::model()->findByPk($id);
		$current_status = $account->status;

		if (!empty($account)) {
			$account->status = "A";

			$valid = $account->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($account->save()) {
						$transaction->commit();
						// METHOD SEND EMAIL UPON ACTIVATE
						Yii::app()->user->setFlash('success', 'Approve Account Complete!');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'Approve Account Failed. Please Contact System Developer.');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Approve Account Failed. Please Contact System Developer.');
					$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Approve Account Validation Failed. Please Contact System Developer.');
				$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
			}
		}
	}

	public function actionDisable($id)
	{
		$account = Account::model()->findByPk($id);
		$current_status = $account->status;

		if (!empty($account)) {
			$account->status = "D";

			$valid = $account->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($account->save()) {
						$transaction->commit();
						// METHOD SEND EMAIL UPON ACTIVATE
						Yii::app()->user->setFlash('success', 'Disable Account Complete!');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'Disable Account Failed. Please Contact System Developer.');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Disable Account Failed. Please Contact System Developer.');
					$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Disable Account Validation Failed. Please Contact System Developer.');
				$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
			}
		}
	}

	public function actionReject($id)
	{
		$account = Account::model()->findByPk($id);
		$current_status = $account->status;

		if (!empty($account)) {
			$account->status = "R";

			$valid = $account->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($account->save()) {
						$transaction->commit();
						// METHOD SEND EMAIL UPON ACTIVATE
						Yii::app()->user->setFlash('success', 'Reject Account Complete!');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'Reject Account Failed. Please Contact System Developer.');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Reject Account Failed. Please Contact System Developer.');
					$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Reject Account Validation Failed. Please Contact System Developer.');
				$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$current_status));
			}
		}
	}

	public function actionEdit($id)
	{
		$account = Account::model()->findByPk($id);
		$user = $account->user;

		if (isset($_POST['Account']) && isset($_POST['User'])) {
			$account->attributes = $_POST['Account'];
			$user->attributes = $_POST['User'];

			$valid = $account->validate();
			$valid = $user->validate() && $valid;

			if ($valid) {
				try {
					$transaction = Yii::app()->db->beginTransaction();

					if ($account->save()) {
						if ($user->save()) {
							$transaction->commit();
							Yii::app()->user->setFlash('success', 'Edit Account Complete!');
							$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$account->status));
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Edit Account Failed. Please Contact System Developer.');
					$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$account->status));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Edit Account Validation Failed. Please Contact System Developer.');
				$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$account->status));
			}
		}

		$this->render('edit', array(
			'account' => $account,
			'user' => $account->user
		));
	}

	public function actionDelete($id)
	{
		$account = Account::model()->findByPk($id);

		if (!empty($account)) {
			$transaction = Yii::app()->db->beginTransaction();

			try {
				if ($account->user->delete()) {
					if ($account->delete()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Delete Account Complete!');
						$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$account->status));
					}
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'Delete Account Failed. Please contact System Developer.');
				$this->redirect(array('account/index', 'type'=>$account->account_type, 'status'=>$account->status));
			}
		}
	}

	public function actionView($id)
	{
		$account = Account::model()->findByPk($id);

		$supporting_documents = FileUploads::model()->findAll(array('condition'=>'account_id = :aid', 'params'=>array(':aid'=>$account->id)));

		foreach ($supporting_documents as $key => $value) {
			$supporting_documents[$key]->file_path = $this->create_path($account->id, $value->filename);
		}

		$this->renderPartial('view', array(
			'account' => $account,
			'user' => $account->user,
			'supporting_documents' => $supporting_documents
		));
	}

	public function actionSettings()
	{
		$account = Account::model()->findByPk(Yii::app()->getModule('admin')->user->id);

		if (isset($_POST['Account']) && isset($_POST['User'])) {
			$account->attributes = $_POST['Account'];
			$account->user->attributes = $_POST['User'];

			$valid = $account->validate();
			$valid = $account->user->validate() && $valid;

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($account->save()) {
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
				Yii::app()->user->setFlash('error', 'Validation failed. Please try again.');
			}
		}

		$this->render('settings', array(
			'account' => $account,
			'user' => $account->user
		));
	}

	#Function accepts 2 parameters
	public function create_path($account_id, $filename)
	{
		return Yii::app()->baseUrl.'/uploads/regfiles/'.$account_id.'/'.$filename;
	}
}