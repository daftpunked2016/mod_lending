<?php

class LoanController extends Controller
{
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_REJECTED = "R";

	public $layout = '/layouts/user_main';


	public function actionIndex()
	{
		$loan_requests = LoanRequest::model()->findAll(array('condition' => 'borrower_id = :aid', 'params'=>array(':aid'=>Yii::app()->user->id)));
		$loan_requestsDP = new CArrayDataProvider($loan_requests, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'loan_requestsDP' => $loan_requestsDP
		));
	}

	public function actionList()
	{
		$loans = Loan::model()->findAll(array('condition' => 'account_id = :aid', 'params'=>array(':aid'=>Yii::app()->user->id)));
		$loansDP = new CArrayDataProvider($loans, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list', array(
			'loansDP' => $loansDP
		));
	}

	public function actionCancel($id)
	{	
		$loan = Loan::model()->findByPk($id);

		#Method delete package record if investor cancel his custom investment package
		if ($loan->package->account_id === Yii::app()->user->id) {
			$loan->package->delete();
			$loan->package->save();
		}

		$loan->delete();

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application has been cancelled.');
			$this->redirect(array('loan/list'));
		}
	}

	public function actionInvestments()
	{
		#Method validate if investment request is pending
		if (LoanRequest::model()->count(array('condition'=>'borrower_id = :borrower_id AND status = "P"', 'params'=>array(':borrower_id'=>Yii::app()->user->id)))) {
			Yii::app()->user->setFlash('error', 'You have a pending loan request. Please wait for System administrator for clearance.');
			$this->redirect(array('account/dashboard'));
		}

		$investments = Loan::model()->isApproved()->findAll(array('condition'=>'id NOT IN (SELECT loan_id FROM loan_request WHERE status IN ("A", "P"))'));
		$investmentsDP = new CArrayDataProvider($investments, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('investments', array(
			'investmentsDP' => $investmentsDP
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

		#viewing variable
		$result['package_name'] = strtoupper($package_data->package_name);
		$result['amount'] = number_format($package_data->amount, 2);
		$result['rate'] = ($package_data->interest_rate * 100)."%";
		$result['payable_in'] = $package_data->months_payable;
		$result['service_fee'] = number_format(Loan::model()->getServiceFee($package_data), 2);
		$result['total'] = "P ".number_format(Loan::model()->getTotal($package_data), 2);
		$result['per_month_total'] = number_format(Loan::model()->getPerMonthTotal($package_data), 2);
		$result['payable_to'] = $loan_data->account->user->check_payable_to;

		$this->renderPartial('computation', array(
			'result' => $result,
			'loan_data' => $loan_data,
			'viewing' => $viewing,			
		));
	}

	public function actionCancelLoan($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request->status === "A") {
			Yii::app()->user->setFlash('error', 'Your Loan Request is been Approved. Please contact System Administrator for more details.');
			$this->redirect(array('loan/index'));
		}

		$request->delete();

		if ($request->save()) {
			Yii::app()->user->setFlash('success', 'Loan Request cancelled Complete!');
			$this->redirect(array('loan/index'));
		}
	}

	public function actionPostRequest()
	{


		$this->render('post_request', array(

		));
	}
}