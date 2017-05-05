<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{	
		$account = Account::model()->findByPk(Yii::app()->getModule("admin")->user->id);

		$total_investor = Account::model()->isInvestor()->count();
		$total_borrower = Account::model()->isBorrower()->count();
		$total_investment = Loan::model()->isApproved()->count();
		$total_loan = LoanRequest::model()->isApproved()->count();

		$this->render('index', array(
			'total_investor' => $total_investor,
			'total_borrower' => $total_borrower,
			'total_investment' => $total_investment,
			'total_loan' => $total_loan,
			'account' => $account,
			'user' => $account->user,
		));
	}

	public function actionLogin()
	{	
		$this->layout ='default/login';

		$model = new AdminLoginForm;

		if(isset($_POST['AdminLoginForm'])) {
			$model->attributes = $_POST['AdminLoginForm'];

			if ($model->validate() && $model->login()) {
				$this->redirect(array('default/index'));
			}
		}

		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		if(isset($_SESSION['token'])) {
			unset($_SESSION['token']);
		}
			
		Yii::app()->getModule('admin')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
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
}