<?php

class LoanController extends Controller
{
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
}