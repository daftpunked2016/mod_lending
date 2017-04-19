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

	public function actionOpen()
	{
		$open_request = OpenRequest::model()->findAll();
		$open_requestDP = new CArrayDataProvider($open_request, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('open', array(
			'open_requestDP' => $open_requestDP
		));
	}

	public function actionApprove($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request) {
			$old_status = $request->status;
			$request->status = "A";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Approval of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}
	}

	public function actionReject($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request) {
			$old_status = $request->status;
			$request->status = "R";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been rejected Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Rejection of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}
	}

	public function actionDelete($id)
	{
		$request = LoanRequest::model()->findByPk($id);

		if ($request) {
			$old_status = $request->status;
			$request->delete();

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been deleted Successfully!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			} else {
				Yii::app()->user->setFlash('success', 'Deletion of Loan Request failed!');
				$this->redirect(array('request/index', 'status'=>$old_status));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/index', 'status'=>'P'));
		}
	}

	public function actionApproveRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			$request->status = "A";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been approved Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Approval of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}

	public function actionRejectRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			$request->status = "R";

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been rejected Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Rejection of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}

	public function actionDeleteRequest($id)
	{
		$request = OpenRequest::model()->findByPk($id);

		if ($request) {
			#Method delete package data first
			$request->package->delete();
			$request->package->save();

			$request->delete();

			if ($request->save()) {
				Yii::app()->user->setFlash('success', 'Loan request has been deleted Successfully!');
				$this->redirect(array('request/open'));
			} else {
				Yii::app()->user->setFlash('success', 'Deletion of Loan Request failed!');
				$this->redirect(array('request/open'));
			}
		} else {
			Yii::app()->user->setFlash('error', 'The borrower has removed / cancelled his request.');
			$this->redirect(array('request/open'));
		}
	}
}