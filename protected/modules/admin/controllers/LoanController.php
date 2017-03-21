<?php

class LoanController extends Controller
{
	public $layout = '/layouts/main';

	public function actionList($status)
	{
		$loans = Loan::model()->findAll(array('condition'=>'status = :s', 'params'=>array(':s'=>$status)));
		$loansDP = new CArrayDataProvider($loans, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		switch ($status) {
			case 'A':
				$class_name = "approved";
				break;
			case 'P':
				$class_name = "pending";
				break;
			case 'R':
				$class_name = "rejected";
				break;
		}

		$this->render('list', array(
			'class_name' => $class_name,
			'loansDP' => $loansDP
		));
	}

	public function actionApprove($id)
	{
		$loan = Loan::model()->findByPk($id);
		$old_status = $loan->status;
		$loan->status = "A";

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application approved.');
			$this->redirect(array('loan/list', 'status'=>$old_status));
		}
	}

	public function actionReject($id)
	{
		$loan = Loan::model()->findByPk($id);
		$old_status = $loan->status;
		$loan->status = "R";

		if ($loan->save()) {
			Yii::app()->user->setFlash('success', 'Loan application rejected.');
			$this->redirect(array('loan/list', 'status'=>$old_status));
		}
	}
}