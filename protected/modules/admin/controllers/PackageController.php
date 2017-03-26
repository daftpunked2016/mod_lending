<?php

class PackageController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{	
		$packages = Package::model()->findAll();
		$packagesDP = new CArrayDataProvider($packages, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		#Method count package -- This will be used to restrict button create if reached to 3
		$package_count = count($packagesDP->rawData);

		$this->render('index', array(
			'packagesDP' => $packagesDP,
			'package_count' => $package_count
		));
	}

	public function actionCreate()
	{
		$package = new Package;

		if (isset($_POST['Package'])) {
			$package->attributes = $_POST['Package'];

			$valid = $package->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($package->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Package Added successfully');
						$this->redirect(array('package/index'));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Error in adding of package. Please try again.');
					$this->redirect(array('package/create'));
				}
			}
		}

		$this->render('create', array(
			'package'=>$package
		));
	}

	public function actionEdit($id)
	{
		$package = Package::model()->findByPk($id);

		if (isset($_POST['Package'])) {
			$package->attributes = $_POST['Package'];

			$valid = $package->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($package->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Package has been updated!');
						$this->redirect(array('package/index'));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Package has been failed!');
					$this->redirect(array('package/index'));
				}
			}
		}

		$this->render('edit', array(
			'package' => $package
		));
	}
}