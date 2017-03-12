<?php

class MessageController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex($folder)
	{
		$account_id = Yii::app()->getModule('admin')->user->id;

		switch ($folder) {
			case 'inbox':
				$messages = Message::model()->isSent()->isNotDeleted()->findAll(array('condition'=>'to_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
				break;
			case 'sent':
				$messages = Message::model()->isSent()->findAll(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
				break;
			case 'drafts':
				$messages = Message::model()->isDrafts()->isNotDeleted()->findAll(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
				break;
			case 'trash':
				$messages = Message::model()->isDeleted()->findAll(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
				break;
			default:
				Yii::app()->user->setFlash('error', 'Invalid Navigation. Please try again.');
				$this->redirect(array('message/index', 'folder'=>'inbox'));
				break;
		}

		#Method counting (inbox & drafts)
		$inbox_count = Message::model()->isSent()->isNotSeen()->isNotDeleted()->count(array('condition'=>'to_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
		$drafts_count = Message::model()->isDrafts()->isNotDeleted()->count(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));

		$messagesDP = new CArrayDataProvider($messages, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('index', array(
			'folder' => $folder,
			'messagesDP' => $messagesDP,
			'inbox_count' => $inbox_count,
			'drafts_count' => $drafts_count,
		));
	}

	public function actionCompose($drafts = false, $id = null)
	{	
		$account_id = Yii::app()->getModule('admin')->user->id;

		$message = new Message;

		#Method messages from drafts -> SEND
		if ($id) {
			$message = Message::model()->findByPk($id);

			$_POST['Message'] = $message->attributes;
		}

		if (isset($_POST['Message'])) {
			$message->attributes = $_POST['Message'];

			#Method initialize default values
			$message->from_account_id = $account_id;
			$message->date_created = date('Y-m-d H:i:s');
			$message->seen_status = "U";
			$message->delete_status = "N";

			if ($drafts) {
				$message->sent_status = "D";
			} else {
				$message->sent_status = "S";
			}

			$valid = $message->validate();

			if ($valid) {
				$transaction = Yii::app()->db->beginTransaction();

				try {
					if ($message->save()) {
						$transaction->commit();
						
						if ($message->sent_status == "S") {
							Yii::app()->user->setFlash('success', 'Message sent!');
							$this->redirect(array('message/index', 'folder'=>'inbox'));
						} else {
							Yii::app()->user->setFlash('success', 'Message save as drafts.');
							$this->redirect(array('message/index', 'folder'=>'drafts'));
						}
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Message sending failed.');
					$this->redirect(array('message/index', 'folder'=>'inbox'));
				}
			} else {
				Yii::app()->user->setFlash('error', 'Validation Failed. Please double check required fields');
			}
		}

		#Method get all accounts
		$approved_accounts = Account::model()->isUser()->isApproved()->findAll();

		#Method counting (inbox & drafts)
		$inbox_count = Message::model()->isSent()->isNotSeen()->isNotDeleted()->count(array('condition'=>'to_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
		$drafts_count = Message::model()->isDrafts()->isNotDeleted()->count(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));

		$this->render('compose', array(
			'message' => $message,
			'inbox_count' => $inbox_count,
			'drafts_count' => $drafts_count,
			'approved_accounts' => $approved_accounts,
		));
	}

	public function actionRead($id)
	{	
		$account_id = Yii::app()->getModule('admin')->user->id;

		$message = Message::model()->findByPk($id);

		#Method redirect if message is not for this account
		if (!empty($message)) {
			if ($message->from_account_id != $account_id && $message->to_account_id != $account_id) {
				Yii::app()->user->setFlash('error', 'Warning: You don\'t have the permission to view this message.');
				$this->redirect(array('message/index', 'folder'=>'inbox'));
			}
		}

		#Method update seen status
		if (!empty($message)) {
			if ($message->sent_status == "S" && $message->from_account_id != $account_id) {
				$message->seen_status = "R";
				$message->save();
			}
		}

		#Method counting (inbox & drafts)
		$inbox_count = Message::model()->isSent()->isNotSeen()->isNotDeleted()->count(array('condition'=>'to_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));
		$drafts_count = Message::model()->isDrafts()->isNotDeleted()->count(array('condition'=>'from_account_id = :account_id', 'params'=>array(':account_id'=>$account_id)));

		$this->render('read', array(
			'message' => $message,
			'account_id' => $account_id,
			'inbox_count' => $inbox_count,
			'drafts_count' => $drafts_count,
		));
	}

	public function actionTrash($id)
	{
		$message = Message::model()->findByPk($id);

		if (!empty($message)) {
			$message->delete_status = "Y";

			if ($message->save()) {
				Yii::app()->user->setFlash('success', 'Message moved to Trash.');
				$this->redirect(array('message/index', 'folder'=>'trash'));
			}
		}
	}
}