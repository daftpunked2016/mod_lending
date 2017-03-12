<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property string $id
 * @property string $from_account_id
 * @property string $to_account_id
 * @property string $message
 * @property string $date_created
 * @property string $seen_status
 * @property string $sent_status
 * @property string $delete_status
 */
class Message extends CActiveRecord
{
	CONST STATUS_SENT = "S";
	CONST STATUS_DRAFTS = "D";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_account_id, to_account_id, message, date_created, sent_status', 'required'),
			array('from_account_id, to_account_id', 'length', 'max'=>11),
			array('seen_status, sent_status, delete_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from_account_id, to_account_id, message, date_created, seen_status, sent_status, delete_status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'from_account' => array(self::BELONGS_TO, 'Account', 'from_account_id'),
			'to_account' => array(self::BELONGS_TO, 'Account', 'to_account_id'),
		);
	}

	public function scopes()
	{
		return array(
			'isSent' => array(
				'condition' => 't.sent_status = "'.self::STATUS_SENT.'"',
			),

			'isDrafts' => array(
				'condition' => 't.sent_status = "'.self::STATUS_DRAFTS.'"',
			),

			'isDeleted' => array(
				'condition' => 't.delete_status = "Y"',
			),

			'isNotDeleted' => array(
				'condition' => 't.delete_status = "N"',
			),

			'isSeen' => array(
				'condition' => 't.seen_status = "R"',
			),

			'isNotSeen' => array(
				'condition' => 't.seen_status = "U"',
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_account_id' => 'From Account',
			'to_account_id' => 'To Account',
			'message' => 'Message',
			'date_created' => 'Date Created',
			'seen_status' => 'Seen Status',
			'sent_status' => 'Sent Status',
			'delete_status' => 'Delete Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from_account_id',$this->from_account_id,true);
		$criteria->compare('to_account_id',$this->to_account_id,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('seen_status',$this->seen_status,true);
		$criteria->compare('sent_status',$this->sent_status,true);
		$criteria->compare('delete_status',$this->delete_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Message the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
