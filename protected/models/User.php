<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $account_id
 * @property string $id_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $address1
 * @property string $address2
 * @property string $province
 * @property string $city
 * @property string $contact_number
 * @property string $tin
 * @property integer $business_type_id
 * @property string $business_name
 * @property string $supporting_documents
 */
class User extends CActiveRecord
{
	use BasicHelper;

	public $business_category;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, address1, province, city, contact_number, tin', 'required'),
			array('business_type_id, business_category, business_name', 'required', 'on'=>'createNewBorrower'),
			array('business_type_id, contact_number', 'numerical', 'integerOnly'=>true),
			array('account_id', 'length', 'max'=>11),
			array('id_name, first_name, middle_name, last_name, province, city, business_name', 'length', 'max'=>64),
			array('address1, address2', 'length', 'max'=>128),
			array('contact_number, tin', 'length', 'max'=>32),
			array('supporting_documents', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, id_name, first_name, middle_name, last_name, address1, address2, province, city, contact_number, tin, business_type_id, business_name', 'safe', 'on'=>'search'),
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
			'business_type' => array(self::BELONGS_TO, 'BusinessType', 'business_type_id'),
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
			'id_name' => 'ID Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'province' => 'Province',
			'city' => 'City',
			'contact_number' => 'Contact Number',
			'tin' => 'Tin',
			'business_type_id' => 'Business Type',
			'business_name' => 'Business Name',
			'supporting_documents' => 'Supporting Documents',
			'business_category' => 'Business Category',
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
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('id_name',$this->id_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('tin',$this->tin,true);
		$criteria->compare('business_type_id',$this->business_type_id);
		$criteria->compare('business_name',$this->business_name,true);
		$criteria->compare('supporting_documents',$this->supporting_documents,true);
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function addSupportedDocuments(array $document_files)
	{
		$file_ids = [];

		foreach($document_files as $file) {
			$filehandler = new ImageFileHandler($file, ImageFileHandler::DOCUMENT_FILES, $this->account_id);
			
			if($filehandler->saveUpload())
				$file_ids[] = $filehandler->_id;
		}

		$this->supporting_documents = json_encode($file_ids);
		return $file_ids;
	}
}
