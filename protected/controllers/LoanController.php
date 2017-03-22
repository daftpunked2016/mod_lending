<?php

class LoanController extends Controller
{
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_REJECTED = "R";

	public $layout = '/layouts/user_main';

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
		$loan->delete();

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application has been cancelled.');
			$this->redirect(array('loan/list'));
		}
	}

	public function actionInvestments()
	{
		$investments = Loan::model()->isApproved()->findAll();
		$investmentsDP = new CArrayDataProvider($investments, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('investments', array(
			'investmentsDP' => $investmentsDP
		));
	}
}