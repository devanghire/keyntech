<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/RestController.php';
require_once APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Category_api extends RestController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model');
	}

	/*
	API Name: Category_api.
	Method:GET.
	Description: To get the all category list .
	By:Devang Hire.
	Created on: 24 January 2025 10:14:45 .
	*/

	function index_get()
	{
		try {
			$allCaregory = $this->Category_model->list();
			$Response['Message'] = "success";
			$Response['ResponseCode'] = 200;
			$Response['ErrorMessage'] = "";
			$Response['Records'] = $allCaregory;
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
		exit;
	}
	/*
		API Name: Category_api/categoryExist.
		Method:POST.
		Description: To check the category name is exist or not .
		By:Devang Hire.
		Created on: 24 January 2025 10:50:05 .
	*/
	function categoryExist_post()
	{
		$category_name =  $this->post('category_name');
		try {
			if (!empty($category_name)) {
				$result = $this->Category_model->categoryExist($category_name);
				$Response['Message'] = $result['message'];
				$Response['ResponseCode'] = $result['code'];
				$Response['ErrorMessage'] = "";
				$Response['Records'] = array();
			} else {
				throw new Exception("Must Enter Category Name ", 400);
			}
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
		exit;
	}
	/*
		API Name: Category_api/add.
		Method:POST.
		Description: To add new category name .
		By:Devang Hire.
		Created on: 24 January 2025 11:50:01 .
	*/
	function add_post()
	{
		$category_name =  $this->post('category_name');
		$selected_category = $this->post('selected_category');
		$textcategory_id = $this->post('textcategory_id');
		$cateId = $this->post('cateId');
		try {

			if (is_array($category_name) && !empty($category_name)) {

				if (isset($cateId) && !empty($cateId)) {
					$result = $this->Category_model->update($selected_category, $textcategory_id, $category_name, $cateId);
				} else {
					$result = $this->Category_model->add($selected_category, $category_name);
				}
				$Response['Message'] = $result['message'];
				$Response['ResponseCode'] = 200;
				$Response['ErrorMessage'] = "";
				$Response['Records'] = array();
			} else {
				throw new Exception("Must Enter Category Name ", 400);
			}
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
		exit;
	}
	/*
		API Name: Category_api/remove.
		Method:DELETE.
		Description: To DELETE category from databse .
		By:Devang Hire.
		Created on: 24 January 2025 12:30:06 .
	*/
	function remove_delete($id = null)
	{

		try {
			if ($id != null) {
				$result = $this->Category_model->remove($id);
				$Response['Message'] = "Category deleted succesfully";
				$Response['ResponseCode'] = 200;
				$Response['ErrorMessage'] = "";
				$Response['Records'] = array();
			} else {
				throw new Exception("Data not found", 400);
			}
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
		exit;
	}
	function getCategoryNameList_get()
	{

		try {
			$allCaregory = $this->Category_model->categoryExist(array());
			$Response['Message'] = "success";
			$Response['ResponseCode'] = 200;
			$Response['ErrorMessage'] = "";
			$Response['Records'] = $allCaregory;
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
		exit;
	}
	function getSingleData_post()
	{

		$categoryId =  $this->post('categoryId');
		try {
			if (!empty($categoryId)) {

				$result = $this->Category_model->getSingleData($categoryId);
				$Response['Message'] = "success";
				$Response['ResponseCode'] = 200;
				$Response['ErrorMessage'] = "";
				$Response['Records'] = $result;
			} else {
				throw new Exception("Must Enter Category Name ", 400);
			}
		} catch (Exception $e) {
			$Response['Message'] = 'Fail';
			$Response['ResponseCode'] = $e->getCode();
			$Response['ErrorMessage'] = $e->getMessage();
			$Response['Records'] = new stdClass();
		}
		echo json_encode($Response, TRUE);
	}
}
