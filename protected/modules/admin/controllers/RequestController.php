<?php

class RequestController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex($status)
	{
		switch ($status) {
			case 'P':
				$status_word = "Pending";
				break;
			case 'A':
				$status_word = "Approved";
				break;
			case 'R':
				$status_word = "Rejected";
				break;
			default:
				$status_word = "Open";
				break;
		}

		$condition = array(
						'join'=>'
							INNER JOIN user u ON t.borrower_id = u.account_id 
							INNER JOIN loan l ON t.loan_id = l.id
							INNER JOIN package p ON l.package_id = p.id', 
						'condition'=>'t.status = :s', 
							'params'=>array(':s'=>$status)
					);
		$search_filters = 0;
		if (!empty($_GET['search'])) {
			if (empty($_GET['search']['name']) && empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable']) && empty($_GET['search']['date_created'])) {
				Yii::app()->user->setFlash('error', 'Please encode at least 1 search filter.');
				$this->redirect(array('request/index', 'status'=>$status));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['name'])) {
				$condition['condition'] .= " AND CONCAT(u.first_name,' ',u.last_name) LIKE '%".$_GET['search']['name']."%'";
			}

			if (!empty($_GET['search']['amount'])) {
				$condition['condition'] .= " AND p.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition['condition'] .= " AND p.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition['condition'] .= " AND p.months_payable = {$_GET['search']['months_payable']}";
			}

			if (!empty($_GET['search']['date_created'])) {
				$condition['condition'] .= " AND t.date_created LIKE '%".$_GET['search']['date_created']."%'";
			}
		}

		$request_data = LoanRequest::model()->findAll($condition);
		$requestDP = new CArrayDataProvider($request_data, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list', array(
			'status_word' => $status_word,
			'status' => $status,
			'requestDP' => $requestDP,
			'search_filters' => $search_filters
		));
	}

	public function actionOpen()
	{	
		$condition = array('join'=>'INNER JOIN package p ON t.package_id = p.id', 'condition'=>'1');
		$search_filters = 0;
		if (!empty($_GET['search'])) {
			if (empty($_GET['search']['name']) && empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable']) && empty($_GET['search']['date_created'])) {
				Yii::app()->user->setFlash('error', 'Please encode at least 1 search filter.');
				$this->redirect(array('request/open'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['name'])) {
				$condition['condition'] .= " AND CONCAT(user.first_name,' ',user.last_name) LIKE '%".$_GET['search']['name']."%'";
			}

			if (!empty($_GET['search']['amount'])) {
				$condition['condition'] .= " AND p.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition['condition'] .= " AND p.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition['condition'] .= " AND p.months_payable = {$_GET['search']['months_payable']}";
			}

			if (!empty($_GET['search']['date_created'])) {
				$condition['condition'] .= " AND t.date_created LIKE '%".$_GET['search']['date_created']."%'";
			}
		}

		$open_request = OpenRequest::model()->with('user')->findAll($condition);
		$open_requestDP = new CArrayDataProvider($open_request, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('open', array(
			'open_requestDP' => $open_requestDP,
			'search_filters' => $search_filters
		));
	}

	// public function actionApprove($id)
	// {
	// 	$request = LoanRequest::model()->findByPk($id);

	// 	if ($request) {
	// 		$old_status = $request->status;
	// 		$request->status = "A";

	// 		if ($request->save()) {
	// 			Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
	// 			$this->redirect(array('request/index', 'status'=>$old_status));
	// 		} else {
	// 			Yii::app()->user->setFlash('success', 'Approval of Loan Request failed!');
	// 			$this->redirect(array('request/index', 'status'=>$old_status));
	// 		}
	// 	} else {
	// 		Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
	// 		$this->redirect(array('request/index', 'status'=>'P'));
	// 	}
	// }

	public function actionApprove($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		#Method validate if user have cancelled his request
		if (empty($request)) {
			Yii::app()->user->setFlash('error', 'The Borrower has Removed / Cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}

		$loan = $request->loan;
		$old_status = $request->status;

		if (isset($_POST['Loan'])) {
			$loan->attributes = $_POST['Loan'];

			#Method validate if date started is empty
			if (empty($_POST['Loan']['date_started'])) {
				Yii::app()->user->setFlash('error', 'Please enter Date Started to Proceed.');
				$this->redirect(array('request/index', 'status'=>'P'));
			}

			$request->status = "A";

			$valid = $request->validate();
			$valid = $loan->validate() && $valid;

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($loan->save()) {
						if ($request->save()) {
							$transaction->commit();
							Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
							$this->redirect(array('request/index', 'status'=>$old_status));
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Approval of Loan Request failed!');
					$this->redirect(array('request/index', 'status'=>$old_status));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Validation Failed. Please double check required fields.');
			}
		}

		$this->renderPartial('approve', array(
			'loan' => $loan,
			'request' => $request
		));
	}

	public function actionReject($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request) {
			$old_status = $request->status;
			$request->status = "R";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been rejected Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Rejection of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}
	}

	public function actionDelete($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request) {
			$old_status = $request->status;
			$request->delete();

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been deleted Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Deletion of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}
	}

	public function actionApproveRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			$request->status = "A";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Approval of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}

	public function actionRejectRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			$request->status = "R";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been rejected Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Rejection of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}

	public function actionDeleteRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			#Method delete package data first
			$request->package->delete();
			$request->package->save();

			$request->delete();

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been deleted Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Deletion of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}

	public function actionSchedule($id)
	{
		$request = LoanRequest::model()->findByPk($id);
		$loan_schedule = Loan::model()->getAmortizationSchedule($request->loan);
		$checks = Checks::model()->findAll(array('condition'=>'loan_request_id = :loan_request_id', 'params'=>array(':loan_request_id'=>$request->id)));

		$this->renderPartial('schedule', array(
			'loan_schedule' => $loan_schedule,
			'loan' => $request->loan,
			'request' => $request,
			'checks' => !empty($checks) ? $checks : null
		));
	}

	public function actionAddCheck($id)
	{
		$check = new Checks;

		if (!empty($id)) {
			$check->loan_request_id = $id;
			$check->check_dated = $_POST['date'];

			$valid = $check->validate();

			if ($valid) {

				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($check->save()) {
						$transaction->commit();

						#Method return delete url
						echo Yii::app()->createUrl('admin/request/deletecheck', array('id'=>$check->id));
						exit;
					}
				} catch (Exception $e) {
					$transaction->rollback();
					echo 0;
					exit;
				}
			}
		} else {
			echo 0;
			exit;
		}
	}

	public function actionDeleteCheck($id)
	{
		if (!empty($id)) {
			$check = Checks::model()->findByPk($id);
			$loan_request_id = $check->loan_request_id;

			$check->delete();
			if ($check->save()) {

				#Method return add check url
				echo Yii::app()->createUrl('admin/request/addcheck', array('id'=>$loan_request_id));
				exit;
			}
		} else {
			echo 0;
			exit;
		}
	}
}