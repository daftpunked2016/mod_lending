<?php

class LoanController extends Controller
{
	public $layout = '/layouts/main';

	public function actionList($status)
	{
		
		if ($status == "A") {
			$loans = Loan::model()->findAll(array('condition'=>'status IN ("A", "I")'));
		} else {
			$loans = Loan::model()->findAll(array('condition'=>'status = :s', 'params'=>array(':s'=>$status)));
		}

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
		
		if (!empty($loan)) {
			$old_status = $loan->status;
			$loan->status = "A";

			if ($loan->save()) {
				Yii::app()->user->setFlash('success', 'Investment application Approved.');
				$this->redirect(array('loan/list', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Investment application has been removed or cancelled by the Investor.');
			$this->redirect(array('loan/list', 'status'=>'P'));
		}
	}

	public function actionReject($id)
	{
		$loan = Loan::model()->findByPk($id);
		
		if (!empty($loan)) {
			$old_status = $loan->status;
			$loan->status = "R";

			if ($loan->save()) {
				Yii::app()->user->setFlash('success', 'Investment application Rejected.');
				$this->redirect(array('loan/list', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Investment application has been removed or cancelled by the Investor.');
			$this->redirect(array('loan/list', 'status'=>'P'));
		}
	}
}