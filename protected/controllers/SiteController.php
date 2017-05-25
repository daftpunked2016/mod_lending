<?php

class SiteController extends Controller
{
	use BasicHelper;

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$packages = Package::model()->findAll(array('condition'=>'account_id = 1', 'limit'=>3));

		$this->render('index', array(
			'packages' => $packages,
		));
	}

	public function actionRegister($type = null)
	{
		$this->layout = "/layouts/register";

		if ($type) {

			$account = new Account;
			$user = new User;
			$filehandlers = [];
			
			$account->setScenario("createNewAccount");

			#generate unique system identifier for each account && set scenario
			if ($type == "B") {
				$user->setScenario("createNewBorrower");
				$id_name = "BOR".time();
			} else {
				$user->setScenario("createNewInvestor");
				$id_name = "INV".time();
			}

			if (isset($_POST['Account']) && isset($_POST['User'])) {

				$account->attributes = $_POST['Account'];
				$account->account_type = $type;
				$user->attributes = $_POST['User'];

				#Method set business_type_id = 0 if investor
				if ($type == "I") {
					$user->business_type_id = 0;
				}

				$valid = $account->validate();
				$valid = $user->validate() && $valid;

				$document_files = (isset($_FILES['supporting_documents'])) ? $this->rearrangeFiles($_FILES['supporting_documents']) : [];
				$valid_files_loaded = false;

				if($type == "B") {
					if($this->validateFileInput('dti_file',$_FILES) && $this->validateFileInput('sec_file',$_FILES)) {
						$valid_files_loaded = true;
					}
				} else {
					if(!empty($_FILES) && count($document_files) >= 2) {
						$valid_files_loaded = true;
					}
				}

				if ($valid && $valid_files_loaded) {
					$transaction = Yii::app()->db->beginTransaction();

					try {
						if ($account->save()) {
							$user->account_id = $account->id;
							$user->id_name = $id_name.$account->id;

							if($type == "B") {
								$user->addDtiFile($_FILES['dti_file']);
								$user->addSecFile($_FILES['sec_file']);
							}
							$user->addSupportedDocuments($document_files);

							if ($user->save()) {	
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Registration Complete! Please wait for the approval of your Account. Thank you!');
								$this->redirect(array('site/login'));
							}
						}
					} catch (Exception $e) {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'Registration Failed! Please contact System Administrator. Sorry for the inconvenience.');
						$this->redirect(array('site/register', 'type'=>$type));
					}
				} else {
					$error_msg = '<ul>';
					if(!$valid) $error_msg .= '<li> Validation Failed! Please double check required fields. </li>';
					
					if(!$valid_files_loaded) {
						if($type == "B") {
							if(!$this->validateFileInput('dti_file',$_FILES))
								$error_msg .= '<li> DTI File is required. </li>';

							if(!$this->validateFileInput('sec_file',$_FILES))
								$error_msg .= '<li> SEC File is required. </li>';
						} else {
							$error_msg .= '<li> Minimum of 2 document files must be uploaded. </li>';
						}
					} 
						
					$error_msg .= '</ul>';
					Yii::app()->user->setFlash('error', $error_msg);
				}
			}

			$this->render('register', array(
				'account' => $account,
				'user' => $user,
				'type' => $type
			));
		} else {
			$this->render('registration_type', array(

			));
		}
	}

	#This page is only intended to Borrowers Account
	public function actionInvestments()
	{
		$this->layout = "/layouts/top_layout";

		#Method restrict investor to gettings into this page
		if (!empty(Yii::app()->user->id)) {
			$account = Account::model()->findByPk(Yii::app()->user->id);

			if ($account->account_type == "I") {
				$this->redirect(array('account/dashboard'));
			}
		}

		$investments = Loan::model()->isApproved()->with('package')->findAll(array('condition'=>'t.id NOT IN (SELECT loan_id FROM loan_request WHERE status IN ("A", "P"))'));
		$investmentsDP = new CArrayDataProvider($investments, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('investments', array(
			'investmentsDP' => $investmentsDP
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = "/layouts/login";

		#Method redirect if user is already logged in
		if (!empty(Yii::app()->user->id)) {
			$this->redirect(array('account/dashboard'));
		}

		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])) {
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				// $this->redirect(Yii::app()->user->returnUrl);
				$this->redirect(array('account/dashboard'));
			}
		}

		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(isset($_SESSION['token'])) {
			unset($_SESSION['token']);
		}

		Yii::app()->user->logout(false);
		Yii::app()->user->setFlash('success','You have successfully logged out your Account.');
		$this->redirect('login');
	}

	public function actionTest()
	{
		$loan_data = Loan::model()->findByPK(61);
		$package_data = Package::model()->findByPk($loan_data->package_id);
		$start_date = $loan_data->date_started;

		$interest_rate = ($package_data->interest_rate / 100) * $package_data->months_payable;

		#PMT
		$interest = $interest_rate / 12;
		$monthly_amortization = $interest * -$package_data->amount * pow((1 + $interest), $package_data->months_payable) / (1 - pow((1 + $interest), $package_data->months_payable));

		#AMORIZATION SCHEDULING
		for ($i=1; $i <= $package_data->months_payable; $i++) { 
			// if ($i === 1) {
			// 	$result['schedule'][$i]['payment_date'] = date('m/d/Y', strtotime($start_date));
			// } else {
			// 	$result['schedule'][$i]['payment_date'] = date('m/d/Y', strtotime($start_date. "+ ".($i-1)." month"));
			// }

			$result['schedule'][$i]['payment_date'] = date('Y/m/d', strtotime($start_date. "+ ".$i." month"));

			$result['schedule'][$i]['scheduled_payment'] = number_format($monthly_amortization, 2);
		}

		$loan_balance = $package_data->amount;
		$total_interest = 0;
		foreach ($result['schedule'] as $key => $value) {
			$result['schedule'][$key]['loan_balance'] = number_format($loan_balance, 2);

			$principal = $monthly_amortization - ($loan_balance * ($interest_rate / 12));
			$result['schedule'][$key]['principal'] = number_format($principal, 2);

			$interest_schedule = $loan_balance * ($interest_rate / 12);
			$result['schedule'][$key]['interest'] = number_format($interest_schedule, 2);

			$ending_balance = $loan_balance - $principal;
			$result['schedule'][$key]['ending_balance'] = number_format($ending_balance, 2);

			$total_interest += $interest_schedule;
			$result['schedule'][$key]['cumulative_interest'] = number_format($total_interest, 2);			

			$loan_balance = $ending_balance;
		}

		$one_time_service_fee = ($package_data->amount + $total_interest) * 0.015;

		#LOAN SUMMARY
		$result['loan_summary']['monthly_amortization'] = number_format($monthly_amortization, 2);
		$result['loan_summary']['months_payable'] = $package_data->months_payable;
		$result['loan_summary']['total_interest'] = number_format($total_interest, 2);
		$result['loan_summary']['interest_rate'] = $package_data->interest_rate;
		$result['loan_summary']['total_payment'] = number_format($package_data->amount + $total_interest, 2); #add total interest here
		$result['loan_summary']['one_time_service_fee'] = number_format($one_time_service_fee, 2);

		echo "<pre>";
		print_r($result);
		echo "</pre>";
		exit;
	}
}