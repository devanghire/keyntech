<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function list(){

		$result = array();
		$allCategoryList = $this->db->select('id,name,parent_id')->from('categories')->order_by('id', 'asc')->get()->result_array();
		if (!empty($allCategoryList)) {
			foreach ($allCategoryList as $item) {
				$parentId = $item['parent_id'];
				if (!isset($result[$parentId])) {
					$result[$parentId] = $item;
					$result[$parentId]['children'] = array();
				} else {
					$result[$parentId]['children'][] = $item;
				}
			}
		}
		$summarizedData = array_values($result);
		return $summarizedData;
	}
	public function categoryExist($category_name){

		$response = array();
		if(!empty($category_name)){
			if(is_array($category_name)){
				$this->db->where_in('name', $category_name);
			}else{
				$this->db->where('name', $category_name);
			}
		}
		$this->db->where('id = parent_id', null, false);
		$this->db->select('id,parent_id,name');
		$query = $this->db->get('categories');
		$result = $query->result_array();
		if(!empty($result)){
			$response['message']="Category name already exist"; 
			$response['code']=200; 
			$response['data']=(empty($category_name))?$result:array(); 
		}else{
			$response['message']="Category name not exist"; 
			$response['code']=404;
			$response['data']=array();  
		}
		return $response;
	}
	public function add($selected_category, $category_name,$flag="add"){
		$response=array();
		$existingParentAddChildCategory = array();
		$categoryExist['code'] =($flag=="edit")?200:"";
		if($flag=='add'){
			$categoryExist = $this->categoryExist($category_name);
		}
		if($categoryExist['code'] !=200){
			foreach ($selected_category as $key => $category) {
				$existingParentAddChildCategory[] = array(
					'name' => $category_name[$key],
					'parent_id' => ($category > 0) ? $category : 0 
				);
			}

			if (!empty($existingParentAddChildCategory)) {
				$this->db->insert_batch('categories', $existingParentAddChildCategory);
			}

			$this->db->set('parent_id', 'id', false);
			$this->db->where('parent_id', 0);
			$this->db->update('categories');
			$response['message']="Category added succesfully"; 
			$response['code']=200; 
		}else{
			$response['message']="Category name already exist"; 
			$response['code']=404; 
		}
		return $response;
		
	}
	public function remove($id){
		$this->db->delete('categories',array('parent_id'=>$id));
	}
	public function getSingleData($categoryId){
		
		$this->db->select('c1.*, c2.name AS parent_name');
		$this->db->from('categories c1');
		$this->db->join('categories c2', 'c1.parent_id = c2.id', 'left');
		$this->db->where('c1.parent_id', $categoryId);
		$query = $this->db->get();
		$result = $query->result_array();

		$listOfCategoryExist = $this->categoryExist(array());
		$html='';

		if(!empty($result)){
			
			foreach ($result as $key => $value) {
				$html.='<div class="row rowforClone"><label for="pwd" class="col-sm-2">Category Name:</label>';
				$html.='<input type="hidden" name="cateId" value ="'.$value['parent_id'].'">';
				$html.='<div class="col-sm-3"><input type="text" class="form-control category_name" name="category_name[]" placeholder="Enter Category Name" value="'.$value['name'].'"></div>';
				$html.='<input type="hidden" name="textcategory_id" value = "'.$value['id'].'">';
				$html.='<label class="col-sm-2">Parent Caregory:</label><div class="col-sm-3">';
				$html.='<select class="form-control selected_category_list" name="selected_category[]">';
				$html.='<option value="0">Add New Or Select</option>';
				if(!empty($listOfCategoryExist['data'])){
					foreach($listOfCategoryExist['data'] as $cat_val){
						$selected="";
						if($value['parent_id']==$cat_val['id']){
							$selected = "selected";
						}
						$html.='<option value="'.$cat_val['id'].'" '.$selected.'>'.$cat_val['name'].'</option>';
					}
				}
				$html.='</select></div>';			
				$html.='<div class="col-sm-1"></div></div>';
			}
		}
		return $html;
	}
	public function update($selected_category,$textcategory_id,$category_name,$cateId){
		$response=array();
		if(isset($cateId[0]) && !empty($cateId)){
			foreach ($textcategory_id as $key => $value) {	
				$updateData = array('parent_id'=>$selected_category[$key],'name'=>$category_name[$key],"updated_at"=>date('Y-m-d h:i:s'));
				$whereData = array('id'=>$value);
				$this->db->update('categories',$updateData,$whereData);
			}
		}
		$response['message']="Category updated succesfully"; 
		$response['code']=200; 
		return $response;
	}
}
