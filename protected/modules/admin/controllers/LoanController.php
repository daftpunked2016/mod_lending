<?php

class LoanController extends Controller
{
	public $layout = '/layouts/main';

	public function actionList($status)
	{
		if ($status == "A") {
			$condition = array('join'=>'INNER JOIN package p ON t.package_id = p.id', 'condition'=>'t.status IN ("A", "I")');
		} else {
			$condition = array('join'=>'INNER JOIN package p ON t.package_id = p.id', 'condition'=>'t.status = :s', 'params'=>array(':s'=>$status));
		}

		$condition2 = "";

		$search_filters = 0;
		if (!empty($_GET['search'])) {
			if (empty($_GET['search']['name']) && empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable']) && empty($_GET['search']['date_created'])) {
				Yii::app()->user->setFlash('error', 'Please encode at least 1 search filter.');
				$this->redirect(array('loan/list', 'status'=>$status));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['name'])) {
				$condition2 .= "CONCAT(user.first_name,' ',user.last_name) LIKE '%".$_GET['search']['name']."%'";
			}

			if (!empty($_GET['search']['amount'])) {
				$condition['condition'] .= " AND p.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition['condition'] .= " AND p.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition['condition'] .= " AND p.months_payable = {$_GET['search']['months_payable']}";
			}

			if (!empty($_GET['search']['date_created'])) {
				$condition['condition'] .= " AND t.date_created LIKE '%".$_GET['search']['date_created']."%'";
			}
		}

		$loans = Loan::model()->with(array('user'=>array('condition'=>$condition2)))->findAll($condition);

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
			'loansDP' => $loansDP,
			'status' => $status,
			'search_filters' => $search_filters,
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