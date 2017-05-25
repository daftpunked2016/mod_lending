<?php

class LoanController extends Controller
{
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_REJECTED = "R";

	public $layout = '/layouts/user_main';


	public function actionIndex()
	{
		$condition = array('join'=>'INNER JOIN loan l ON t.loan_id = l.id INNER JOIN package p ON l.package_id = p.id', 'condition'=>'borrower_id = :aid', 'params'=>array(':aid'=>Yii::app()->user->id));

		$search_filters = 0;
		if (!empty($_GET['search'])) {

			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/index'));
			} else {
				$search_filters = 1;
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
		}

		$loan_requests = LoanRequest::model()->findAll($condition);
		$loan_requestsDP = new CArrayDataProvider($loan_requests, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'loan_requestsDP' => $loan_requestsDP,
			'search_filters' => $search_filters,
		));
	}

	public function actionList()
	{	
		$condition = array('condition' => 't.account_id = :aid', 'params'=>array(':aid'=>Yii::app()->user->id));
		$search_filters = 0;
		if (!empty($_GET['search'])) {

			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/list'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['amount'])) {
				$condition['condition'] .= " AND package.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition['condition'] .= " AND package.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition['condition'] .= " AND package.months_payable = {$_GET['search']['months_payable']}";
			}
		}


		$loans = Loan::model()->with('package')->findAll($condition);
		$loansDP = new CArrayDataProvider($loans, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list', array(
			'loansDP' => $loansDP,
			'search_filters' => $search_filters
		));
	}

	public function actionCancel($id)
	{	
		$loan = Loan::model()->findByPk($id);

		if ($loan->status === "P") {
			#Method delete package record if investor cancel his custom investment package
			if ($loan->package->account_id === Yii::app()->user->id) {
				$loan->package->delete();
				$loan->package->save();
			}

			$loan->delete();

			if ($loan->save()) {
				Yii::app()->user->setFlash('success', 'Investment application has been cancelled.');
				$this->redirect(array('loan/list'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Investment application has been processed. Please contact system Administrator for details.');
			$this->redirect(array('loan/list'));
		}
	}

	public function actionInvestments()
	{
		#Method validate if investment request is pending
		// $this->check_pending_loan();

		$condition = "";
		$search_filters = 0;
		if (!empty($_GET['search'])) {

			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/investments'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['amount'])) {
				$condition .= " AND package.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition .= " AND package.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition .= " AND package.months_payable = {$_GET['search']['months_payable']}";
			}
		}

		$investments = Loan::model()->isApproved()->with('package')->findAll(array('condition'=>'t.id NOT IN (SELECT loan_id FROM loan_request WHERE status IN ("A", "P"))'.$condition));
		$investmentsDP = new CArrayDataProvider($investments, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('investments', array(
			'investmentsDP' => $investmentsDP,
			'search_filters' => $search_filters
		));
	}

	public function actionApply($loan_id)
	{
		$loan_request = new LoanRequest;

		if (!empty($loan_id)) {
			$loan_request->loan_id = $loan_id;
			$loan_request->borrower_id = Yii::app()->user->id;
			$loan_request->status = "P"; #Pending
			$loan_request->date_created = date('Y-m-d H:i');

			$valid = $loan_request->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					if ($loan_request->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Loan request successful. Please wait for System Admin to approve your request. Thank you!');
						$this->redirect(array('loan/index'));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Loan request failed. Please contact system developer. Sorry for the inconvenience. Thank you!');
					$this->redirect(array('loan/investments'));
				}
			}

		}
	}

	public function actionComputation($id, $viewing = false)
	{
		$loan_data = Loan::model()->findByPk($id);
		$package_data = $loan_data->package;

		$result = Loan::model()->getAmortizationSchedule($loan_data);

		#viewing variable
		$result['loan_summary']['package_name'] = strtoupper($package_data->package_name);
		$result['loan_summary']['amount'] = number_format($package_data->amount, 2);
		$result['loan_summary']['payable_in'] = $package_data->months_payable;
		
		if ($viewing) {
			$result['loan_summary']['payable_to'] = $loan_data->account->user->check_payable_to;
		}

		#Method check if user is not log in
		if (!empty(Yii::app()->user->id)) {
			$this->renderPartial('computation', array(
				'result' => $result['loan_summary'],
				'loan_data' => $loan_data,
				'viewing' => $viewing,			
			));
		} else {
			$this->renderPartial('computation_not_login', array(
				'result' => $result['loan_summary']
			));
		}
	}

	public function actionCancelLoan($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request->status === "A" || $request->status === "R") {
			Yii::app()->user->setFlash('error', 'Your Loan Request has been processed. Please contact System Administrator for more details.');
			$this->redirect(array('loan/index'));
		}

		$request->delete();

		if ($request->save()) {
			Yii::app()->user->setFlash('success', 'Loan Request cancelled Complete!');
			$this->redirect(array('loan/index'));
		}
	}

	public function actionOpen()
	{
		#Method check pending loan
		// $this->check_pending_loan();

		$condition = array('condition'=>'borrower_id = :bid', 'params'=>array(':bid'=>Yii::app()->user->id));
		$search_filters = 0;
		if (!empty($_GET['search'])) {

			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/open'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['amount'])) {
				$condition['condition'] .= " AND package.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition['condition'] .= " AND package.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition['condition'] .= " AND package.months_payable = {$_GET['search']['months_payable']}";
			}
		}

		$open_request_data = OpenRequest::model()->with('package')->findAll($condition);
		$open_requestDP = new CArrayDataProvider($open_request_data, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		#Method create custom package for open request
		$package = new Package;
		$open_request = new OpenRequest;

		if (isset($_POST['Package'])) {
			$package->attributes = $_POST['Package'];
			$package->package_name = "CUSTOMIZED";
			$package->account_id = Yii::app()->user->id;

			$valid = $package->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($package->save()) {
						$open_request->package_id = $package->id;

						if ($open_request->save()) {
							$transaction->commit();
							Yii::app()->user->setFlash('success', 'Posting of Loan Request Complete!');
							$this->redirect(array('loan/open'));
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Posting of Loan Request failed. Please contact system developer.');
					$this->redirect(array('loan/open'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Validation Failed! Please check required fields and try again.');
			}
		}

		$this->render('open_request', array(
			'open_requestDP' => $open_requestDP,
			'package' => $package,
			'search_filters' => $search_filters
		));
	}

	public function actionCancelRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if (!empty($request)) {
			if ($request->status === "P") {

				#Method delete package data
				$request->package->delete();
				$request->package->save();

				$request->delete();

				if ($request->save()) {
					Yii::app()->user->setFlash('success', 'Posting of Loan Request has been cancelled.');
					$this->redirect(array('loan/open'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Posting of Loan Request has already been processed. Please contact System Administrator for more details.');
				$this->redirect(array('loan/open'));
			}
		}
	}

	public function actionOpenList()
	{
		$condition = "1";
		$search_filters = 0;

		if (!empty($_GET['search'])) {

			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/openlist'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['amount'])) {
				$condition = "package.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition = "package.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition = "package.months_payable = {$_GET['search']['months_payable']}";
			}
		}

		$requests = OpenRequest::model()->isOpen()->isApproved()->with('package')->findAll(array('condition'=>$condition));
		$requestsDP = new CArrayDataProvider($requests, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('openlist', array(
			'requestsDP' => $requestsDP,
			'search_filters' => $search_filters
		));
	}

	public function actionInvite($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		$loan = new Loan;

		#Method assign attributes
		$loan->account_id = Yii::app()->user->id;
		$loan->package_id = $request->package_id;
		$loan->status = "I"; #INVITATION
		$loan->date_created = date('Y-m-d H:i');

		$valid = $loan->validate();

		if ($valid) {
			$transaction = Yii::app()->db->beginTransaction();

			try {
				if ($loan->save()) {
					$request->loan_id = $loan->id;

					if ($request->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Push Invite Complete!');
						$this->redirect(array('loan/openlist'));
					}
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'Push Invite failed! Please contact system developer.');
				$this->redirect(array('loan/openlist'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Validation failed! Please double check required fields and try again.');
		}
	}

	public function check_pending_loan()
	{
		if (LoanRequest::model()->count(array('condition'=>'borrower_id = :borrower_id AND status = "P"', 'params'=>array(':borrower_id'=>Yii::app()->user->id)))) {
			Yii::app()->user->setFlash('error', 'You have a pending loan request. Please wait for System administrator for clearance.');
			$this->redirect(array('account/dashboard'));
		}

		return true;
	}
}