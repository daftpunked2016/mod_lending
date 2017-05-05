<?php

class PackageController extends Controller
{
	public $layout = '/layouts/user_main';

	public function actionList()
	{
		$condition = "";
		$search_filters = 0;
		if (!empty($_GET['search'])) {
			#Method redirect if search filter is empty
			if (empty($_GET['search']['amount']) && empty($_GET['search']['interest_rate']) && empty($_GET['search']['months_payable'])) {
				Yii::app()->user->setFlash('error', 'Please enter atleast 1 search filter.');
				$this->redirect(array('loan/investments'));
			} else {
				$search_filters = 1;
			}

			if (!empty($_GET['search']['amount'])) {
				$condition = "t.amount = {$_GET['search']['amount']}";
			}

			if (!empty($_GET['search']['interest_rate'])) {
				$condition = "t.interest_rate = {$_GET['search']['interest_rate']}";
			}

			if (!empty($_GET['search']['months_payable'])) {
				$condition = "t.months_payable = {$_GET['search']['months_payable']}";
			}
		}

		$packages = Package::model()->adminPackages()->findAll(array('condition'=>$condition));

		$package = new Package;

		if (isset($_POST['Package'])) {
			$package->attributes = $_POST['Package'];
			$package->package_name = "CUSTOM PACKAGE";
			$package->account_id = Yii::app()->user->id;

			$valid = $package->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($package->save()) {
						$transaction->commit();
						$this->redirect(array('package/apply', 'id'=>$package->id));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Posting of Investment failed. Please try again.');
					$this->redirect(array('package/list'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Validation failed! Please double check required fields.');
			}
		}

		$this->render('list', array(
			'packages' => $packages,
			'package' => $package,
			'search_filters' => $search_filters,
		));
	}

	public function actionApply($id)
	{
		$loan = new Loan;

		$loan->account_id = Yii::app()->user->id;
		$loan->package_id = $id;
		$loan->status = "P"; #Pending
		$loan->date_created = date('Y-m-d H:i');

		$valid = $loan->validate();

		if ($valid) {
			$transaction = Yii::app()->db->beginTransaction();

			try {
				if ($loan->save()) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Investment application has been sent to Admin. Please wait for the approval. Thank you!');
					$this->redirect(array('loan/list'));
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', 'Investment application failed. Please try again.');
				$this->redirect(array('package/list'));
			}
		}
	}
}