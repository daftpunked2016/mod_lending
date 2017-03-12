<?php

class ContentController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$content_data = Content::model()->findAll();

		$contentDP = new CArrayDataProvider($content_data, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'contentDP'=>$contentDP
		));
	}

	public function actionAdd()
	{
		$content = new Content;

		if (isset($_POST['Content'])) {
			$content->attributes = $_POST['Content'];

			$valid = $content->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					if ($content->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Content Successfully Added!');
						$this->redirect(array('content/index'));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('success', 'Content Validation Failed! Please contact System Developer.');
						$this->redirect(array('content/index'));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('success', 'Content Saving Failed! Please contact System Developer.');
					$this->redirect(array('content/index'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Content Validation Failed! Please Check the required Fields.');
			}
		}

		$this->render('add', array(
			'content' => $content,
		));
	}

	public function actionEdit($id)
	{
		$content = Content::model()->findByPk($id);

		if (isset($_POST['Content'])) {
			$content->attributes = $_POST['Content'];

			$valid = $content->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					if ($content->save()) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Content Edit Successful!');
						$this->redirect(array('content/edit', 'id'=>$content->id));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', 'Content Saving Edit Failed! Please contact System Developer.');
						$this->redirect(array('content/edit', 'id'=>$content->id));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Content Saving Edit Failed! Please contact System Developer.');
					$this->redirect(array('content/edit', 'id'=>$content->id));					
				}
			} else {
				Yii::app()->user->setFlash('error', 'Content Validation Failed! Please Check the required Fields.');
			}
		}

		$this->render('edit', array(
			'content' => $content,
		));
	}

	public function actionActivate($id)
	{
		$content = Content::model()->findByPk($id);

		if (!empty($content)) {
			$content->status = "A";

			if ($content->save()) {
				Yii::app()->user->setFlash('success', 'Content Activation Complete!');
				$this->redirect(array('content/index'));
			} else {
				Yii::app()->user->setFlash('error', 'Content Validation Failed! Please contact System developer.');
				$this->redirect(array('content/index'));
			}
		} else {
			Yii::app()->user->setFlash('success', 'Content Empty! Please contact System Developer.');
			$this->redirect(array('content/index'));
		}
	}

	public function actionDisable($id)
	{
		$content = Content::model()->findByPk($id);

		if (!empty($content)) {
			$content->status = "D";

			if ($content->save()) {
				Yii::app()->user->setFlash('success', 'Content Disable Complete!');
				$this->redirect(array('content/index'));
			} else {
				Yii::app()->user->setFlash('error', 'Content Validation Failed! Please contact System developer.');
				$this->redirect(array('content/index'));
			}
		} else {
			Yii::app()->user->setFlash('success', 'Content Empty! Please contact System Developer.');
			$this->redirect(array('content/index'));
		}
	}
}