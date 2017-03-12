<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$this->render('index', array(

		));
	}

	public function actionLogin()
	{	
		$this->layout ='default/login';

		$model = new AdminLoginForm;

		if(isset($_POST['AdminLoginForm'])) {
			$model->attributes = $_POST['AdminLoginForm'];

			if ($model->validate() && $model->login()) {
				$this->redirect(array('default/index'));
			}
		}

		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		if(isset($_SESSION['token'])) {
			unset($_SESSION['token']);
		}
			
		Yii::app()->getModule('admin')->user->logout(false);
		Yii::app()->user->setFlash('success', 'Logout Successful.');
		$this->redirect(Yii::app()->getModule('admin')->user->loginUrl);
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error) {

			if(Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}
}