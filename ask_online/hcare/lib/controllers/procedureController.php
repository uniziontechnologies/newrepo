<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/model/procedure/category.php';
require_once ROOT_PATH . '/lib/model/procedure/procedure.php';
require_once ROOT_PATH . '/lib/model/procedure/health_package.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/lab/labModel.php';


class ProcedureController {

	var $addSuccess="Added Successfully";
	var $addfailed="Failed To Add";
	var $updateSuccess="Updated Successfully";
	var $updatefailed="Failed To Update";
	var $deleteSuccess="Deleted Successfully";
	var $deletefailed="Failed To Delete";

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			switch($sub_module){
				
				
				case 'Manage_Procedure'			:
													$proc_obj=new Procedure();
													$cat_obj=new Category();
													$dbObj=new DBFunction();
											
											
											
											$form_creator ->popArr['category']=$cat_obj->getCategory();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/procedure/procedure_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['procedureInfo']=$proc_obj->getProcedure('',$wheredata);
													
													}	
													
											
											}else{
											
												$k=0;
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
													$likefield='';
													$wheredata=array();
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['category'])){
													
														$message .= " CATEGORY  -  ".$dbObj->getidToValue("category","id",$postArr['category'],"hcare_procedure_category") ." ";
														
														$wheredata[$k]="category_id = '".$postArr['category']."'";
														$k++;
													}if(!empty($postArr['procedure'])){
													
														$message .= " PROCEDURE  -  ".$postArr['procedure'] ." ";
														
														$wheredata[$k]="`procedure_test` like '%".$postArr['procedure']."%'";
														$k++;
													}
												}
												
												$form_creator ->popArr['message']	=$message;
												
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
													$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
													
												}
												$wheredata[$k]="status = 0";
												$form_creator ->popArr['procedureInfo']	=$proc_obj->getProcedure('',$wheredata);
												$form_creator ->formPath ='/templates/procedure/manage_procedure.php';
											}
											
													break;
													
													
				case 'Manage_Category'			:
													
													$cat_obj=new Category();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/procedure/category_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['categoryInfo']=$cat_obj->getCategory('',$wheredata);
													
													}
											
											}else{
											
												$k=0;
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['category'])){
													
														$message .= " CATEGORY NAME  -  ".$postArr['category'] ." ";
														
														$wheredata[$k]="category like '%".$postArr['category']."%'";
														$k++;
													
													}
													$form_creator ->popArr['message']	=$message;
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="(status = 0 or status=2)";
											
												$form_creator ->popArr['category']	=$cat_obj->getCategory('',$wheredata);
												$form_creator ->formPath ='/templates/procedure/manage_category.php';
											}
											
													break;
			case 'health_checkup_package'	:$lab_obj=new LabModel();
			                                 $proc_obj=new Procedure();
							                 $pack_obj=new Health_package();
							                 $emp_obj=new Employee();

			                                  if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											  
												$is_field[0]="a.title='Dr'";												
												$form_creator ->popArr['doctors']=$emp_obj->getEmployee($is_field);	

							     $form_creator ->formPath ='/templates/procedure/health_package_form.php';
							      if($postArr['action']=="CREATE_PAGE"){
												
								$form_creator ->popArr['action']="ADD";
													
							     }else {								
													
													
								$form_creator ->popArr['action']="UPDATE";
								
								$id=$postArr['id'];					
								$condition[0]="status=0";
								$condition[1]="id=".$id;
							       $form_creator ->popArr['packageInfo']=$packageInfo=$pack_obj->getHealthPackage('',$condition);
							       $labTestSelected=array();
							       $labElementSelected=array();
							       $procedureSelected=array();
							       if(!empty($packageInfo)){
							        
								    $condn[0]="status=0";
								    $condn[1]="test_type='LT'";
								    $condn[2]="package_id=".$packageInfo[0][0];
								    $labTestSelected=$pack_obj->getPackageElementId('',$condn);
								    
								    $condn[1]="test_type='LE'";
								    $labElementSelected=$pack_obj->getPackageElementId('',$condn);
								    
								     $condn[1]="test_type='P'";
								    $procedureSelected=$pack_obj->getPackageElementId('',$condn);
								 
							       }
							      $form_creator ->popArr['labTestSelected']=$labTestSelected;
							      $form_creator ->popArr['labElementSelected']=$labElementSelected;
							      $form_creator ->popArr['procedureSelected']=$procedureSelected;
								
								
													
							     }
							     
								$labCondn[0]="status=0";
							    $form_creator ->popArr['labTestInfo']=$lab_obj->getGroupTest($labCondn);
								$form_creator ->popArr['labElementInfo']=$lab_obj->getTestElement('',$labCondn);
								$wheredata[0]="status = 0";
								$form_creator ->popArr['procedureInfo']=$proc_obj->getProcedure('',$wheredata);
						        }else{
							       $condition[0]="status=0";

							       if (!empty($postArr['package_name'])) {
							       		$condition[1]="package_name like '%".$postArr['package_name']."%'";
							       }

							       
							       $form_creator ->popArr['packageInfo']=$packageInfo=$pack_obj->getHealthPackage('',$condition);
							       $elementInfo=array();
							       if(!empty($packageInfo)){
							         for($i=0;$i<count($packageInfo);$i++){
								    $condn[0]="status=0";
								    $condn[1]="package_id=".$packageInfo[$i][0];
								    $elementInfo[$i]=$pack_obj->getHealthPackageElements('',$condn);
								 }
							       }
							      $form_creator ->popArr['elementInfo']=$elementInfo;
			                                      $form_creator ->formPath ='/templates/procedure/health_checkup_packages.php';
						        }
											 break;
													
			
			}
			
			$form_creator->display();
	
	}
	
	function manageCategory($post){
	
			$cat_obj=new Category();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$cat_obj->addCategory($post);
								
					}else{
					
						$status=$cat_obj->updateCategory($post);
					}
			
			}else{
			
				$is_cat_in_use=$cat_obj->checkCategory($post);
				if($is_cat_in_use){
					$status=$cat_obj->deleteCategory($post);
				}else {
				
					$message ="Category Already in Use";
					$this->viewPage('Manage_Category',$post,'',$message);
					exit();
				}
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Manage_Category',$post,'',$message);
	
	
	}
	function manageProcedure($post){
	
			$proc_obj=new Procedure();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$proc_obj->addProcedure($post);
								
					}else{
					
						$status=$proc_obj->updateProcedure($post);
					}
			
			}else{
			
				$status=$proc_obj->deleteProcedure($post);
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Manage_Procedure',$post,'',$message);
	
	
	}
	
	function manageHealthPackage($post){
	
	
			$pack_obj=new Health_package();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$package_id=$pack_obj->addHealthPackage($post);
					if($package_id > 0) {	
					    if(count($post['group_test']) > 0){
					    
					      for($i=0;$i<count($post['group_test']);$i++){
					      
						 $pack_obj->addPackageElements($post['group_test'][$i],"LT",$package_id);
					       }
					     }  
                                           if(count($post['elements']) > 0){
					    
					      for($i=0;$i<count($post['elements']);$i++){
					      
						 $pack_obj->addPackageElements($post['elements'][$i],"LE",$package_id);
					       }
					     } 
                                          if(count($post['procedure']) > 0){
					    
					      for($i=0;$i<count($post['procedure']);$i++){
					      
						 $pack_obj->addPackageElements($post['procedure'][$i],"P",$package_id);
					       }
					     }  
                                          $status=true;					     
					}else $status=false;			
					}else{
					
						$status=$pack_obj->updateHealthPackage($post);
						
						$pack_obj->deleteHPackageElements($post);
						
						$package_id=$post['id'];
						if($package_id > 0) {	
					             if(count($post['group_test']) > 0){
					    
					                  for($i=0;$i<count($post['group_test']);$i++){
					      
						             $pack_obj->addPackageElements($post['group_test'][$i],"LT",$package_id);
					                  }
					             }  
                                                     if(count($post['elements']) > 0){
					    
					                 for($i=0;$i<count($post['elements']);$i++){
					      
						          $pack_obj->addPackageElements($post['elements'][$i],"LE",$package_id);
					                 }
					           } 
                                                   if(count($post['procedure']) > 0){
					    
					                  for($i=0;$i<count($post['procedure']);$i++){
					      
						          $pack_obj->addPackageElements($post['procedure'][$i],"P",$package_id);
					                 }
					          }  
                                                   $status=true;					     
					        }else $status=false;	
					}
			
			}else{
			
				
					$status=$pack_obj->deleteHealthPackage($post);
				        $status=$pack_obj->deleteHPackageElements($post);
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('health_checkup_package',$post,'',$message);
	
	
	}

	function healthCheckupPackageOrder($post)
	{
		$pack_obj=new Health_package();
		
		if (!empty($post)) {
			
			if (!empty($post['order_no'])) {
				
				for ($i=0; $i < count($post['order_no']) ; $i++) { 
					
					$pack_obj->healthCheckupPackageOrderUpdate($post['package_ids'][$i],$post['package_test_ids
						_id'][$i],$post['order_no'][$i]);

				}

			}

		}

		$post['action'] = "EDIT_PAGE";
		$message = "Order Updated Successfully !!";

		$this->viewPage('health_checkup_package',$post,'',$message);

	}
	
	
}


?>