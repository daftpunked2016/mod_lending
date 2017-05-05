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
		// Yii::app()->user->logout();
		// $this->redirect(Yii::app()->homeUrl);
		if(isset($_SESSION['token'])) {
			unset($_SESSION['token']);
		}

		Yii::app()->user->logout(false);
		Yii::app()->user->setFlash('success','You have successfully logged out your Account.');
		$this->redirect('login');
	}
}