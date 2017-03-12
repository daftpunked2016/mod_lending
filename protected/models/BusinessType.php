<?php

/**
 * This is the model class for table "business_type".
 *
 * The followings are the available columns in table 'business_type':
 * @property integer $id
 * @property integer $cat_id
 * @property string $type
 * @property string $status
 */
class BusinessType extends CActiveRecord
{
	CONST STATUS_ACTIVE = "A";
	CONST STATUS_INACTIVE = "D";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'business_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_id, type', 'required'),
			array('cat_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>55),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cat_id, type, status', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
	{
		return array(
			'isActive' => array(
				'condition' => 't.status = "'.self::STATUS_ACTIVE.'"',
			),
			
			'isInactive' => array(
				'condition' => 't.status = "'.self::STATUS_INACTIVE.'"',
			),
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
			'category' => array(self::BELONGS_TO, 'BusinessCategory', 'cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cat_id' => 'Cat',
			'type' => 'Type',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BusinessType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function listTypesByCategoryId($cat_id)
	{
		$data = $this::model()->isActive()->findAll(array('condition'=>'cat_id = :cat_id', 'params'=>array(':cat_id'=>$cat_id)));
		
		return $data;
	}
}
