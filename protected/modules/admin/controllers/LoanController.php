<?php

class LoanController extends Controller
{
	public $layout = '/layouts/main';

	public function actionList()
	{
		$loans = Loan::model()->findAll();
		$loansDP = new CArrayDataProvider($loans, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list', array(
			'loansDP' => $loansDP
		));
	}

	public function actionApprove($id)
	{
		$loan = Loan::model()->findByPk($id);
		$loan->status = "A";

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application approved.');
			$this->redirect(array('loan/list'));
		}
	}

	public function actionReject($id)
	{
		$loan = Loan::model()->findByPk($id);
		$loan->status = "R";

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application rejected.');
			$this->redirect(array('loan/list'));
		}
	}
}