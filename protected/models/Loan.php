<?php

/**
 * This is the model class for table "loan".
 *
 * The followings are the available columns in table 'loan':
 * @property string $id
 * @property integer $account_id
 * @property integer $package_id
 * @property string $status
 * @property string $date_started
 * @property string $date_created
 */
class Loan extends CActiveRecord
{
	CONST STATUS_PENDING = "P";
	CONST STATUS_APPROVED = "A";
	CONST STATUS_REJECTED = "R";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'loan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, package_id, status, date_created', 'required'),
			array('account_id, package_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			array('date_started', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, package_id, status, date_started, date_created', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'user' => array(self::BELONGS_TO, 'User', 'account_id'),
			'package' => array(self::BELONGS_TO, 'Package', 'package_id'),
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
			'account_id' => 'Account',
			'package_id' => 'Package',
			'status' => 'Status',
			'date_started' => 'Date Started',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_started',$this->date_started,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Loan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAmortizationSchedule($loan_data)
	{
		$package_data = $loan_data->package;

		if (!empty($loan_data->date_started)) {
			$start_date = $loan_data->date_started;
		} else {
			$start_date = $loan_data->date_created;
		}

		$interest_rate = ($package_data->interest_rate / 100) * $package_data->months_payable;

		#PMT
		$interest = $interest_rate / 12;
		$monthly_amortization = $interest * -$package_data->amount * pow((1 + $interest), $package_data->months_payable) / (1 - pow((1 + $interest), $package_data->months_payable));

		#SCHEDULING
		for ($i=1; $i <= $package_data->months_payable; $i++) {
			$result['schedule'][$i]['payment_date'] = date('Y/m/d', strtotime($start_date. "+ ".$i." month"));
			$result['schedule'][$i]['scheduled_payment'] = number_format($monthly_amortization, 2);
		}

		$loan_balance = $package_data->amount;
		$total_interest = 0;
		foreach ($result['schedule'] as $key => $value) {
			$result['schedule'][$key]['loan_balance'] = number_format($loan_balance, 2);

			$principal = $monthly_amortization - ($loan_balance * ($interest_rate / 12));
			$result['schedule'][$key]['principal'] = number_format($principal, 2);

			$interest_schedule = $loan_balance * ($interest_rate / 12);
			$result['schedule'][$key]['interest'] = number_format($interest_schedule, 2);

			$ending_balance = $loan_balance - $principal;
			$result['schedule'][$key]['ending_balance'] = number_format($ending_balance, 2);

			$total_interest += $interest_schedule;
			$result['schedule'][$key]['cumulative_interest'] = number_format($total_interest, 2);			

			$loan_balance = $ending_balance;
		}

		$one_time_service_fee = ($package_data->amount + $total_interest) * 0.015;
		$total_payment = $package_data->amount + $total_interest;
		$grand_total = $total_payment + $one_time_service_fee;

		#LOAN SUMMARY
		$result['loan_summary']['monthly_amortization'] = number_format($monthly_amortization, 2);
		$result['loan_summary']['months_payable'] = $package_data->months_payable;
		$result['loan_summary']['total_interest'] = number_format($total_interest, 2);
		$result['loan_summary']['interest_rate'] = $package_data->interest_rate;
		$result['loan_summary']['total_payment'] = number_format($total_payment, 2); #add total interest here
		$result['loan_summary']['one_time_service_fee'] = number_format($one_time_service_fee, 2);
		$result['loan_summary']['grand_total'] = number_format($grand_total, 2);
		
		return $result;
	}
}
