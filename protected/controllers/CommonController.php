<?php

class CommonController extends Controller
{
	public function actionListBusinessType()
	{
		$result = "<option value='' disabled selected>Select Business Type</option>";

		if (!empty($_POST['cat_id'])) {
			$category_id = $_POST['cat_id'];

			$business_types = BusinessType::model()->listTypesByCategoryId($category_id);

			foreach ($business_types as $types) {
				$result .= "<option value=".$types->id.">".$types->type."</option>";
			}
		}

		echo $result;
		exit;
	}

	public function actionListCities()
	{
		$result = "<option value='' disabled selected>Select City</option>";

		if (!empty($_POST['province_id'])) {
			$province_id = $_POST['province_id'];

			$city_data = City::model()->findAll(array('condition'=>'province_id = :pid', 'params'=>array(':pid'=>$province_id)));

			foreach ($city_data as $value) {
				$result .= "<option value=".$value->id.">".$value->name."</option>";
			}
		}

		echo $result;
		exit;
	}
}