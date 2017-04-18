<?php

class PackageController extends Controller
{
	public $layout = '/layouts/user_main';

	public function actionList()
	{
		$packages = Package::model()->adminPackages()->findAll();

		// foreach ($packages as $key => $value) {
		// 	switch ($value->id) {
		// 		case 1:
		// 			$packages[$key]['class'] = "bg-gray disabled color-palette";
		// 			break;
		// 		case 2:
		// 			$packages[$key]['class'] = "bg-yellow disabled color-palette";
		// 			break;
		// 		default:
		// 			$packages[$key]['class'] = "bg-gray-active color-palette";
		// 			break;
		// 	}
		// }

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