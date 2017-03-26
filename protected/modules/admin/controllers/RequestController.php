<?php

class RequestController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex($status)
	{
		switch ($status) {
			case 'P':
				$status_word = "Pending";
				break;
			case 'A':
				$status_word = "Approved";
				break;
			case 'R':
				$status_word = "Rejected";
				break;
			default:
				$status_word = "Open";
				break;
		}

		$request_data = LoanRequest::model()->findAll(array('condition'=>'status = :s', 'params'=>array(':s'=>$status)));
		$requestDP = new CArrayDataProvider($request_data, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list', array(
			'status_word' => $status_word,
			'status' => $status,
			'requestDP' => $requestDP
		));
	}

	public function actionApprove($id)
	{
		$request = LoanRequest::model()->findByPk($id);
		$old_status = $request->status;

		if ($request) {
			$request->status = "A";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Approval of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		}
	}

	public function actionReject($id)
	{
		$request = LoanRequest::model()->findByPk($id);
		$old_status = $request->status;

		if ($request) {
			$request->status = "R";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been rejected Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Rejection of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		}
	}

	public function actionDelete($id)
	{
		$request = LoanRequest::model()->findByPk($id);
		$old_status = $request->status;

		if ($request) {
			$request->delete();

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been deleted Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Deletion of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		}
	}
}