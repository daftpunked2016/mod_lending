<?php

/**
 * This is the model class for table "loan_request".
 *
 * The followings are the available columns in table 'loan_request':
 * @property string $id
 * @property string $loan_id
 * @property string $borrower_id
 * @property string $status
 * @property string $date_created
 */
class LoanRequest extends CActiveRecord
{
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_REJECTED = "R";
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'loan_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('borrower_id, status, date_created', 'required'),
			array('loan_id, borrower_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, loan_id, borrower_id, status, date_created', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'borrower_id'),
			'loan' => array(self::BELONGS_TO, 'Loan', 'loan_id'),
		);
	}

	public function scopes()
	{
		return array(
			'isPending' => array(
				'condition' => 't.status = "'.self::STATUS_PENDING.'"',
			),

			'isApproved' => array(
				'condition' => 't.status = "'.self::STATUS_APPROVED.'"',
			),

			'isRejected' => array(
				'condition' => 't.status = "'.self::STATUS_REJECTED.'"',
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
			'loan_id' => 'Loan',
			'borrower_id' => 'Borrower',
			'status' => 'Status',
			'date_created' => 'Date Created',
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
		$criteria->compare('loan_id',$this->loan_id,true);
		$criteria->compare('borrower_id',$this->borrower_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoanRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
