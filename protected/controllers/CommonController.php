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
}