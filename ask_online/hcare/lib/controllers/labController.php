<?php //session_start();

require_once ROOT_PATH . '/lib/common/form.php';
require_once ROOT_PATH . '/lib/common/commonFunctions.php';
require_once ROOT_PATH . '/lib/common/pagination.php';
require_once ROOT_PATH . '/lib/model/DBFunctions.php';
require_once ROOT_PATH . '/lib/model/lab/labModel.php';
require_once ROOT_PATH . '/lib/common/smsFunctions.php';
require_once ROOT_PATH . '/config_hims.php';





class LabController {

	

	function viewPage($sub_module,$postArr='',$getArr='',$message=''){
	
			$form_creator = new Form();
			
			if(!empty ($message)){
				$form_creator ->popArr['message']=$message;
			}
			
			switch($sub_module){ 
			
							case 'Elements'	   :
				
											$lab_obj=new LabModel();
											
										    //category list
											
											$condition[0]="status != 1";
											$form_creator ->popArr['categoryInfo']=$lab_obj->getCategory($condition);
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/lab/labmaster/create_elements.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['elementInfo']=$lab_obj->getTestElement('',$wheredata);
													
													}
											
											}else{
											
												$k=0;
												 $pagi_obj = new Pagination();
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['elem_name'])){
													
														$message .= " ELEMENT NAME  -  ".$postArr['elem_name'] ." ";
														
														$wheredata[$k]="test_name like '%".$postArr['elem_name']."%'";
														$k++;
													
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status = 0";
												
												//pagination
											    $testCount=$lab_obj->getTestElementCount($wheredata);
												$form_creator ->popArr['perPage']=$perPage=$pagi_obj->perPage=10;//$pagi_obj->perPage;	

                                                if(empty($postArr['current_page'])) $current_page =1;			
			                                    else $current_page = $postArr['current_page'];
			
					
			                                   //set limit value for query
			                                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                               $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($testCount,$current_page);	
                                               $form_creator ->popArr['current_page']=$current_page;	
											   
												$form_creator ->popArr['elementInfo']	=$lab_obj->getTestElement('',$wheredata,'test_name','ASC',$limit);
												$form_creator ->formPath ='/templates/lab/labmaster/manage_elements.php';
											}
											
													break;
					case 'Category'	   :
				
											$lab_obj=new LabModel();
											
										  
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/lab/labmaster/create_category.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['categoryInfo']=$lab_obj->getCategory($wheredata);
													
													}
											
											}else{
											
												$k=0;
												 $pagi_obj = new Pagination();
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['elem_name'])){
													
														$message .= " CATEGORY  -  ".$postArr['elem_name'] ." ";
														
														// $wheredata[$k]="category like '%".$postArr['elem_name']."%'";
														$wheredata[$k]="category like '%".$postArr['elem_name']."%'";
														$k++;
													
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status != 1";
												
												//pagination
											    $catCount=$lab_obj->getCategoryCount($wheredata);
												$form_creator ->popArr['perPage']=$perPage=$pagi_obj->perPage=10;//$pagi_obj->perPage;	

                                                if(empty($postArr['current_page'])) $current_page =1;			
			                                    else $current_page = $postArr['current_page'];
			                                    // $current_page =1;
			
					
			                                   //set limit value for query
			                                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                               $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($catCount,$current_page);	
                                               $form_creator ->popArr['current_page']=$current_page;	
											   
												$form_creator ->popArr['categoryInfo']	=$lab_obj->getCategory($wheredata,'category','ASC',$limit);
												$form_creator ->formPath ='/templates/lab/labmaster/manage_category.php';
											}
											
													break;
					case 'Group_test'	   :
				
											$lab_obj=new LabModel();
											
										   //category list
											
											$condition[0]="status != 1";
											$form_creator ->popArr['categoryInfo']=$lab_obj->getCategory($condition);
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/lab/labmaster/create_group_test.php';
													
													
													//elements
													$elem_condn[0]="status=0";
													$form_creator ->popArr['elementInfo']=$lab_obj->getTestElement('',$elem_condn,'test_name','asc');
													
													$sub_condn[0]="status=0";
													$form_creator ->popArr['subCategoryInfo']=$lab_obj->getSubCategory($sub_condn,'subcategory','asc');
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['testInfo']=$lab_obj->getGroupTest($wheredata);
														
														$subcondn[0]="tid=".$id;
														// $subcondn[1]="eid >0";
														$form_creator ->popArr['elementSelected']=$lab_obj->getGroupTestElement($subcondn,'id','asc');
														$form_creator ->popArr['elemIdSelected']=$lab_obj->getTestElemID($subcondn);
														
														// $subcondn[0]="tid=".$id;
														// $subcondn[1]="sid >0";
														// $form_creator ->popArr['subCatSelected']=$lab_obj->getGroupTestElement($subcondn,'id','asc');
														// $form_creator ->popArr['subCatIdSelected']=$lab_obj->getTestElemSubcatID($subcondn,'id','asc');
													
													}
											
											}else{
											
												$k=0;
												 $pagi_obj = new Pagination();
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['tst_name'])){
													
														$message .= " TEST NAME  -  ".$postArr['tst_name'] ." ";
														
														$wheredata[$k]="test_name like '%".$postArr['tst_name']."%'";
														$k++;
													
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status = 0";
												
												//pagination
											    $catCount=$lab_obj->getGroupTestCount($wheredata);
												$form_creator ->popArr['perPage']=$perPage=$pagi_obj->perPage=10;//$pagi_obj->perPage;	

                                                if(empty($postArr['current_page'])) $current_page =1;			
			                                    else $current_page = $postArr['current_page'];
			
					
			                                   //set limit value for query
			                                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                               $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($catCount,$current_page);	
                                               $form_creator ->popArr['current_page']=$current_page;	
											   
												$form_creator ->popArr['testInfo']	=$lab_obj->getGroupTest($wheredata,'test_name','ASC',$limit);
												$form_creator ->formPath ='/templates/lab/labmaster/manage_group_test.php';
											}
											
													break;
							case 'SubCategory'	   :
				
											$lab_obj=new LabModel();
										
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/lab/labmaster/create_sub_category.php';
													
													
													//elements
													$elem_condn[0]="status=0";
													$form_creator ->popArr['elementInfo']=$lab_obj->getTestElement('',$elem_condn);
													
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['subCatInfo']=$lab_obj->getSubCategory($wheredata);
														
														$subcondn[0]="sid=".$id;
														$subcondn[1]="eid >0";
														$subcondn[2]="status =0";
														$form_creator ->popArr['elementSelected']=$lab_obj->getSubGroupElement($subcondn,'id','asc');
														
														
														$form_creator ->popArr['elemIdSelected']=$lab_obj->getSubgpElemID($subcondn);
														
													
													}
											
											}else{
											
												$k=0;
												 $pagi_obj = new Pagination();
												
												if(isset($postArr['action']) && ($postArr['action']=="SEARCH")){
												
													
												
													$wheredata=array();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['tst_name'])){
													
														$message .= " CATEGORY NAME  -  ".$postArr['tst_name'] ." ";
														
														$wheredata[$k]="subcategory like '%".$postArr['tst_name']."%'";
														$k++;
													
													}
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status = 0";
												
												//pagination
											    $catCount=$lab_obj->getSubCategoryCount($wheredata);
												$form_creator ->popArr['perPage']=$perPage=$pagi_obj->perPage=10;//$pagi_obj->perPage;	

                                                if(empty($postArr['current_page'])) $current_page =1;			
			                                    else $current_page = $postArr['current_page'];
			
					
			                                   //set limit value for query
			                                   $limit=$pagi_obj->pageLimit($current_page,$perPage);	
                                               $form_creator ->popArr['pagination']=$pagi_obj->printPageLinks($catCount,$current_page);	
                                               $form_creator ->popArr['current_page']=$current_page;	
											   
												$form_creator ->popArr['subCatInfo']	=$lab_obj->getSubCategory($wheredata,'subcategory','ASC',$limit);
												$form_creator ->formPath ='/templates/lab/labmaster/manage_sub_category.php';
											}
											
													break;
						case 'new_result_entry':
						                          $bill_obj=new Billing();
												  $user_obj=new User();
												  $pagi_obj = new Pagination();
													
									
													$wheredata=array();
													$k=0;
													if(!empty($postArr['from_date'])) {
													
														$wheredata[$k++]="bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
														
													}
													if(!empty($postArr['to_date'])) {
													
														
														$wheredata[$k++]="bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
													}
													if(!empty($postArr['billno'])) {
														$wheredata[$k++]="id ='".$postArr['billno']."'";
													}
													
													if(!empty($postArr['type'])) {
														
														$wheredata[$k++]="type ='".$postArr['type']."'";
														if(!empty($postArr['patient_id'])) {
															 $wheredata[$k++]="ref_no ='".$postArr['patient_id']."'";
														}
													}
													if(empty($wheredata)){
													   if(!empty($_GET['old_data']))
                                                            {
                                                             $wheredata[$k++]="bill_date <'".date("Y-m-d")." 23:59:59'";
                                                            }
                                                        else{   
														     $wheredata[$k++]="bill_date >='".date("Y-m-d")." 00:00:00'";
														     $wheredata[$k++]="bill_date <='".date("Y-m-d")." 23:59:59'";
														    }
													}
                                                        $wheredata[$k++]="lab_status ='0'";
														
														//$user_data[0]="a.user_type='6'"." or "."a.user_type='7'";
													$userInfo="";
													$user_data="";	
													$userInfo=$user_obj->getfullUserInfo($user_data);
										// if(!empty($userInfo)){
															
										    if(count($userInfo) >0){
										    	$user_id='';
											for($i=0;$i<count($userInfo);$i++){
														
												if($i == 0 ){
													$user_id .="(";
												}
														
												if($i == ((count($userInfo))-1)){
														
													$user_id .=$userInfo[$i][0].")";
												}else{
													$user_id .=$userInfo[$i][0].",";
												}
											}
											$wheredata[$k++]="user_id in $user_id";
                                            }
                                        // }

                                            $wheredata[$k++]="status ='0'";
                                                        $form_creator ->popArr['post']=$postArr;
                                        /*......SET TOTAL COUNT TO BE VIEWED IN A PAGE......*/
                                            if(!empty($_GET['old_data']))
                                               {
                                                    $perPage=15; 
                                                    if(empty($postArr['current_page'])) 
                                                        {
                                                    	   $current_page =1;	
                                                        }
                                                    else{ 
                                                    	   $current_page = $postArr['current_page']; 
                                                    	}  
                                                    $limit=$pagi_obj->pageLimit($current_page,$perPage);
                                        /*.....get total count of.......*/
                                                    $patientCount=$bill_obj->getBillCount($wheredata);  

                                                    $form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata,'id','desc','', $limit);
                                        
                                        /*......set pagination link......*/
                                                    $form_creator ->popArr['pagination']= $pagi_obj->printPageLinks($patientCount,$current_page,$perPage);	
                                        /*......set current page.........*/
                                                    $form_creator ->popArr['current_page']=$current_page;
                                                }	  
													
											else{	
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($wheredata);
											    }		
													
						                            $form_creator ->formPath ='/templates/lab/result_entry/new_result_entry.php';
						                            break;

						           
						case 'search_lab_bill' : 
						                        $bill_obj=new Billing();
													$user_obj=new User();

																									
													$wheredata=array();
													$k=0;
													if(!empty($postArr['from_date'])) {
													
														$wheredata[$k++]="a.bill_date >='".date("Y-m-d",strtotime($postArr['from_date']))." 00:00:00'";
														
													}
													if(!empty($postArr['to_date'])) {
													
														
														$wheredata[$k++]="a.bill_date <='".date("Y-m-d",strtotime($postArr['to_date']))." 23:59:59'";
													}
													if(!empty($postArr['billno'])) {
														$wheredata[$k++]="a.id ='".$postArr['billno']."'";
													}
													
													if(!empty($postArr['type'])) {
														
														$wheredata[$k++]="type ='".$postArr['type']."'";
														if(!empty($postArr['patient_id'])) {
															
															 $wheredata[$k++]="a.ref_no ='".$postArr['patient_id']."'";
														}
														
														if(($postArr['type'] == "OP" || $postArr['type'] == "IP")  && !empty($postArr['patient_name'])){
															
															$wheredata[$k++]="b.first_name like'".$postArr['patient_name']."%'";
															
														}else if($postArr['type'] == "DIRECT" && !empty($postArr['patient_name'])){
															
															$wheredata[$k++]="c.name like'".$postArr['patient_name']."%'";
														}
													}else if(!empty($postArr['patient_name'])) {
														
														$wheredata[$k++]="(b.first_name like'".$postArr['patient_name']."%' || c.name like'".$postArr['patient_name']."%')";
														
													}
													
													if(empty($wheredata)){
														$wheredata[$k++]="a.bill_date >='".date("Y-m-d")." 00:00:00'";
														$wheredata[$k++]="a.bill_date <='".date("Y-m-d")." 23:59:59'";
													}
                                                    $wheredata[$k++]="a.lab_status ='1'";
                                                
													
													/*$user_data[0]="a.user_type='6'"." or "."a.user_type='7'";
													$userInfo=$user_obj->getfullUserInfo($user_data);
															
										    if(count($userInfo) >0){
											for($i=0;$i<count($userInfo);$i++){
														
												if($i == 0 ){
													$user_id .="(";
												}
														
												if($i == ((count($userInfo))-1)){
														
													$user_id .=$userInfo[$i][0].")";
												}else{
													$user_id .=$userInfo[$i][0].",";
												}
											}
											$wheredata[$k++]="user_id in $user_id";
										}*/
													 
													$form_creator ->popArr['post']=$postArr;
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfoAllField($wheredata);
													
						                            $form_creator ->formPath ='/templates/lab/result_entry/search_lab_bill.php';
												    break;
					case 'result_entry' :  
					                        $bill_obj=new Billing();
											$db_function =new DBFunction();
											$lab_obj=new LabModel();
											
					                        $billno=$getArr['billno'];

					                        if (!empty($billno)) {
					                        	
												$wheredata_mul=array();
												$wheredata_mul[0] = "status = 0";
												$wheredata_mul[1] = "bill_id = '".$billno."'";
												$bill_data_type=$db_function->getIdToValueMultiple("type",$wheredata_mul,"hcare_bill_items");

					                        }

					                        $wheredata[0]="bill_id=".$billno;
											$wheredata[1]="(type='L' or type='LT' or type='LE')";
											$form_creator ->popArr['billItemInfo']=$billItemInfo=$bill_obj->getLabBillItems($wheredata);


											if (!empty($bill_data_type) && $bill_data_type=="PACKAGE") {


													foreach ($billItemInfo as $key => $row) {
													    $distance[$key] = $row[11];
													}
													
													array_multisort($distance, SORT_ASC, $billItemInfo);

											}
											
					                        
											
											$testInfo=array();
											
											if(!empty($billItemInfo)){
												$k=0;
											 for($i=0;$i<count($billItemInfo);$i++){
                                               
											    $test_type=$billItemInfo[$i][3];
												
												if($test_type == "LT"){
													
													//category name
													
													$testInfo[$k][0]=$billItemInfo[$i][7];
													$testInfo[$k][1]="";//value
													$testInfo[$k][2]="";//normal
													$testInfo[$k][3]="";//tid
													$testInfo[$k][4]=$billItemInfo[$i][6];//cid
													$testInfo[$k][5]="3";//type
													$testInfo[$k][6]="";//unit
													$k++;
													
													$testInfo[$k][0]=$billItemInfo[$i][5];
													$testInfo[$k][1]="";//value
													$testInfo[$k][2]="";//normal
													$testInfo[$k][3]=$billItemInfo[$i][4];//tid
													$testInfo[$k][4]="";//cid
													$testInfo[$k][5]="1";//type
													$testInfo[$k][6]="";//unit
													$testInfo[$k][8]="";//
													$testInfo[$k][9]=$lab_obj->getDescription($billItemInfo[$i][4]);
													$k++;


		// NEW CHANGES START
			$subcondn=array();
			$subcondn[0]="tid=".$billItemInfo[$i][4];
			$elementSelected=$lab_obj->getGroupTestElement($subcondn,'id','asc');
				
			
			// MAIN ELEMENT START								
			if (!empty($elementSelected)) {
									
				// MAIN ELEMENT FOR LOOP START					
				for ($j=0; $j < count($elementSelected) ; $j++) { 
															

					// IF IT IS ELEMENT START
					if ($elementSelected[$j][2] > 0) {
						
						$subcondn=array();
						$subcondn[0]="tid = '".$billItemInfo[$i][4]."'";
						$subcondn[1]="eid = '".$elementSelected[$j][2]."'";
						$elements=$lab_obj->getGroupTestElement($subcondn,'id','asc');

						if (!empty($elements)) {

							for ($p=0; $p < count($elements) ; $p++) { 
								

								$eid=$elements[$p][2];
								$range="";
								$range=$db_function->getidToValue("normal1","id",$eid,"hcare_lab_element");
								$range2=$db_function->getidToValue("normal2","id",$eid,"hcare_lab_element");
								$range3=$db_function->getidToValue("normal3","id",$eid,"hcare_lab_element");
								$range4=$db_function->getidToValue("normal4","id",$eid,"hcare_lab_element");
								$range5=$db_function->getidToValue("normal5","id",$eid,"hcare_lab_element");
								$range6=$db_function->getidToValue("normal6","id",$eid,"hcare_lab_element");

								if(!empty($range2)) $range .="<br>".$range2;
								if(!empty($range3)) $range .="<br>".$range3;
								if(!empty($range4)) $range .="<br>".$range4;
								if(!empty($range5)) $range .="<br>".$range5;
								if(!empty($range6)) $range .="<br>".$range6;

								$testInfo[$k][0]=$elements[$p][3];
								$testInfo[$k][1]="";//value
								$testInfo[$k][2]=$range;//normal
								$testInfo[$k][3]=$eid;//tid
								$testInfo[$k][4]=$db_function->getidToValue("category","id",$eid,"hcare_lab_element");//cid
								$testInfo[$k][5]="10";//type
								$testInfo[$k][6]=$db_function->getidToValue("unit","id",$eid,"hcare_lab_element");//unit
								$testInfo[$k][8]="";
								$testInfo[$k][9]=$lab_obj->getDescription($eid);
								$k++;


							}


						}

					}
					// IF IT IS ELEMENT END


					// IF IT IS SUB CATEGORY START
					if ($elementSelected[$j][4] > 0) {
						
						$subcondn=array();
						$subcondn[0]="tid = '".$billItemInfo[$i][4]."'";
						$subcondn[1]="sid = '".$elementSelected[$j][4]."'";
						$subCategory=$lab_obj->getGroupTestElement($subcondn,'id','asc');
						
						if (!empty($subCategory)) {
							
							for ($p=0; $p < count($subCategory) ; $p++) { 

								// var_dump($subCategory[$p]);
								
								$sid=$subCategory[$p][4];
															
								$testInfo[$k][0]=$subCategory[$p][5];
								$testInfo[$k][1]="";//value
								$testInfo[$k][2]="";//normal
								$testInfo[$k][3]=$sid;//tid
								$testInfo[$k][4]="";//cid
								$testInfo[$k][5]="2";//type
								$testInfo[$k][6]="";//unit
								$testInfo[$k][8]="";
								$testInfo[$k][9]=$lab_obj->getDescription($sid);
								$k++;



								$subcondn = array();
								$subcondn[0]="sid=".$sid;
								$subcondn[1]="eid >0";
								$subcondn[2]="status =0";
								$subCategorySelected[$p]=$lab_obj->getSubGroupElement($subcondn,'id','asc');


								if (!empty($subCategorySelected[$p])) {
									
									for ($g=0; $g < count($subCategorySelected[$p]) ; $g++) { 
										
										// var_dump($subCategorySelected[$p][$g]);
										$eid=$subCategorySelected[$p][$g][2];
										$range="";
										$range=$db_function->getidToValue("normal1","id",$eid,"hcare_lab_element");
										$range2=$db_function->getidToValue("normal2","id",$eid,"hcare_lab_element");
										$range3=$db_function->getidToValue("normal3","id",$eid,"hcare_lab_element");
										$range4=$db_function->getidToValue("normal4","id",$eid,"hcare_lab_element");
										$range5=$db_function->getidToValue("normal5","id",$eid,"hcare_lab_element");
										$range6=$db_function->getidToValue("normal6","id",$eid,"hcare_lab_element");

										if(!empty($range2)) $range .="<br>".$range2;
										if(!empty($range3)) $range .="<br>".$range3;
										if(!empty($range4)) $range .="<br>".$range4;
										if(!empty($range5)) $range .="<br>".$range5;
										if(!empty($range6)) $range .="<br>".$range6;


										$testInfo[$k][0]=$subCategorySelected[$p][$g][3];
										$testInfo[$k][1]="";//value
										$testInfo[$k][2]=$range;//normal
										$testInfo[$k][3]=$eid;//tid
										$testInfo[$k][4]=$db_function->getidToValue("category","id",$eid,"hcare_lab_element");//cid
										$testInfo[$k][5]="20";//type
										$testInfo[$k][6]=$db_function->getidToValue("unit","id",$eid,"hcare_lab_element");//unit
										$testInfo[$k][8]="";
										$testInfo[$k][9]=$lab_obj->getDescription($eid);
										$k++;



									}

								}












							}

						}



					}
					// IF IT IS SUB CATEGORY END



				}
				// MAIN ELEMENT FOR LOOP END
			}
			// MAIN ELEMENT END


		// NEW CHANGES END

													
												}else if($test_type == "LE"){
													
													$eid=$billItemInfo[$i][4];
													$range="";
												    $range=$db_function->getidToValue("normal1","id",$eid,"hcare_lab_element");
													$range2=$db_function->getidToValue("normal2","id",$eid,"hcare_lab_element");
													$range3=$db_function->getidToValue("normal3","id",$eid,"hcare_lab_element");
													$range4=$db_function->getidToValue("normal4","id",$eid,"hcare_lab_element");
													$range5=$db_function->getidToValue("normal5","id",$eid,"hcare_lab_element");
													$range6=$db_function->getidToValue("normal6","id",$eid,"hcare_lab_element");
													 
													if(!empty($range2)) $range .="<br>".$range2;
													if(!empty($range3)) $range .="<br>".$range3;
													if(!empty($range4)) $range .="<br>".$range4;
													if(!empty($range5)) $range .="<br>".$range5;
													if(!empty($range6)) $range .="<br>".$range6;
													
													
													$testInfo[$k][0]=$billItemInfo[$i][5];
													$testInfo[$k][1]="";//value
													$testInfo[$k][2]=$range;//normal
													$testInfo[$k][3]=$billItemInfo[$i][4];//tid
													$testInfo[$k][4]=$db_function->getidToValue("category","id",$eid,"hcare_lab_element");//cid
													$testInfo[$k][5]="0";//type
													$testInfo[$k][6]=$db_function->getidToValue("unit","id",$eid,"hcare_lab_element");//unit
													$testInfo[$k][8]="";
													$testInfo[$k][9]=$lab_obj->getDescription($billItemInfo[$i][4]);

													$k++;
                                                }											 
											}
											}
											$form_creator ->popArr['paction']="SAVE";
											$form_creator ->popArr['billno']=$billno;
											$form_creator ->popArr['testItemInfo']=$testInfo;
											$billcondn[0]="id=".$billno;
											$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
											$form_creator ->formPath ='/templates/lab/result_entry/result_entry_form.php';
					                          break;
				
				case 'print_lab_result' :
				                            $lab_obj=new LabModel();
											$bill_obj=new Billing();
											$emp_obj=new Employee();
											
				                            $billno=$postArr['billno'];
											
											if(empty($billno)) $billno=$getArr['billno'];
											$result_id=$postArr['result_id'];
											if(empty($result_id)){
												$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
												$result_id=$resultInfo[0][0];
											}
											
											
											if(!empty($result_id)){
												
												$wheredata[0]="result_id=".$result_id;
												$form_creator ->popArr['resultEntryInfo']=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
												$is_field[]="a.`lab_in_charge_status`=1";
												$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($is_field);
												
												$billcondn[0]="id=".$billno;
												$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
												
											}

											$form_creator ->popArr['post'] = $postArr;	
											$form_creator ->formPath ='/templates/lab/result_entry/print_lab_result.php';											

											
				                          break;
					case 'view_lab_result' :
				                            $lab_obj=new LabModel();
											$bill_obj=new Billing();
											
				                            $billno=$postArr['billno'];
											
											if(empty($billno)) $billno=$getArr['billno'];
											$result_id=$postArr['result_id'];
											if(empty($result_id)){
												$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
												$result_id=$resultInfo[0][0];
											}
											
											
											if(!empty($result_id)){
												
												$wheredata[0]="result_id=".$result_id;
												$form_creator ->popArr['resultEntryInfo']=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
												
												$billcondn[0]="id=".$billno;
												$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
												
											}
											
											$form_creator ->formPath ='/templates/lab/result_entry/view_lab_result.php';
				                          break;
					case 'edit_lab_result' : $lab_obj=new LabModel();
											$bill_obj=new Billing();

											$action=$getArr['action'];


											
				                            $billno=$postArr['billno'];
											
											if(empty($billno)) $billno=$getArr['billno'];
											$result_id=$postArr['result_id'];
											if(empty($result_id)){
												$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
												$result_id=$resultInfo[0][0];
											}
											
											
											if(!empty($result_id)){
												
												$wheredata[0]="result_id=".$result_id;
												$resultEntryInfo=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
												$testInfo=array();
												if(!empty($resultEntryInfo)){
													
													for($i=0;$i<count($resultEntryInfo);$i++){
														 
													$testInfo[$i][0]=$resultEntryInfo[$i][3];
													$testInfo[$i][1]=$resultEntryInfo[$i][4];//value
													$testInfo[$i][2]=$resultEntryInfo[$i][5];//normal
													$testInfo[$i][3]=$resultEntryInfo[$i][2];//tid
													$testInfo[$i][4]=$resultEntryInfo[$i][8];//cid
													$testInfo[$i][5]=$resultEntryInfo[$i][7];//type
													$testInfo[$i][6]=$resultEntryInfo[$i][6];//unit
													$testInfo[$i][7]=$resultEntryInfo[$i][18];//testrnge
													$testInfo[$i][8]=$resultEntryInfo[$i][19];//description
													}
												}
												// var_dump($testInfo);
												$billcondn[0]="id=".$billno;
												$form_creator ->popArr['billInfo']=$billInfo=$bill_obj->getBillInfo($billcondn);

												$ageInfo=$billInfo[0][4];
												$age_in=explode(" ",$ageInfo);
												$age=$age_in[0];
												$age_type=$age_in[1];

												
											}
											 // var_dump($billInfo);

											if(!empty($action)){
												$form_creator ->popArr['paction']=$action;

											}else{

												$form_creator ->popArr['paction']="UPDATE";

											}


											
											$form_creator ->popArr['billno']=$billno;
											$form_creator ->popArr['testItemInfo']=$testInfo;
											$form_creator ->popArr['age']=$age;
											$form_creator ->popArr['age_type']=$age_type;

											$wheredata_test = array();
											$wheredata_test[0]="bill_id=".$billno;
											$wheredata_test[1]="(type='L' or type='LT' or type='LE')";
											$form_creator ->popArr['billItemInfo']=$billItemInfo=$bill_obj->getLabBillItems($wheredata_test);


											// FOR MANTOX TEST DETAILS START
											$wheredata_result = array();
											$wheredata_result[0]="bill_no=".$billno;
											$wheredata_result[1]="type='HR'";
											$form_creator ->popArr['mantoxResult']=$mantoxResult=$lab_obj->getLabresultEntryById($wheredata_result,"id","desc");
											// FOR MANTOX TEST DETAILS END

					                          $form_creator ->formPath ='/templates/lab/result_entry/result_entry_form.php';
				                              break;

				//for email
				case 'email_lab_result_copy' :
												$lab_obj=new LabModel();
												$bill_obj=new Billing();
												
										        $billno=$postArr['billno'];
												
												if(empty($billno)) $billno=$getArr['billno'];
												$result_id=$postArr['result_id'];
												if(empty($result_id)){
													$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
													$result_id=$resultInfo[0][0];
												}
												
												
												if(!empty($result_id)){
													
													$wheredata[0]="result_id=".$result_id;
													$form_creator ->popArr['resultEntryInfo']=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
													
													$billcondn[0]="id=".$billno;
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
													
												}
												//for email
												if(!empty($getArr['email'])){
													$email = $getArr['email'];
												}else{
													$email = null;
												}
												$form_creator ->popArr['email'] = $email;
												$form_creator ->popArr['post'] = $postArr;
												$form_creator ->popArr['billno'] = $billno;
												$form_creator ->formPath ='/templates/lab/result_entry/email_lab_result.php';
												break;
				//for email
				case 'email_lab_result' :
												$lab_obj=new LabModel();
												$bill_obj=new Billing();
												$hobj=new HospitalInfo();
												$emp_obj=new Employee();
												// echo 111111;exit;
												
										        $billno=$postArr['billno'];
												
												if(empty($billno)) $billno=$getArr['billno'];
												$result_id=$postArr['result_id'];
												if(!empty($postArr['result_id'])){
													$result_id=$postArr['result_id'];
												}
												
												if(empty($result_id)){
													$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
													$result_id=$resultInfo[0][0];
												}
												
												
												if(!empty($result_id)){


													
													$wheredata[0]="result_id=".$result_id;
													$form_creator ->popArr['resultEntryInfo']=$resultEntryInfo=$lab_obj->getLabresultEntryById($wheredata,"id","asc");
													// var_dump($resultEntryInfo);exit;

													$is_field[]="a.`lab_in_charge_status`=1";
												$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($is_field);
												 // var_dump($empInfo);
													
													$billcondn[0]="id=".$billno;
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
													
												}
												//for email
												if(!empty($getArr['email'])){
													$email = $getArr['email'];
												}else{
													$email = null;
												}
												
												$form_creator ->popArr['hInfo'] =$hinfo=$hobj->getHospitalInfo();
												$form_creator ->popArr['smtpInfo'] =$smtpInfo=$lab_obj->getSmtpSettings();
												$form_creator ->popArr['email'] = $email;
												$form_creator ->popArr['post'] = $postArr;
												$form_creator ->popArr['billno'] = $billno;
												$form_creator ->formPath ='/templates/lab/result_entry/email_lab_result.php';
												break;	
				//for download
				case 'download_pdf' :	
												$lab_obj=new LabModel();
												$bill_obj=new Billing();
												$hobj=new HospitalInfo();
												$emp_obj=new Employee();
												
										        $billno=$postArr['billno'];
										         // echo $billno;exit();
										        $pdf_download_status=1;
										        $form_creator ->popArr['pdf_download_status']=$pdf_download_status;
												
												if(empty($billno)) $billno=$getArr['billno'];
												$result_id=$postArr['result_id'];
												if(empty($result_id)){
													$form_creator ->popArr['resultInfo']=$resultInfo=$lab_obj->getLabresultInfo($billno);
													$result_id=$resultInfo[0][0];
												}
												
												
												if(!empty($result_id)){
													
													$wheredata[0]="result_id=".$result_id;
													$form_creator ->popArr['resultEntryInfo']=$lab_obj->getLabresultEntryById($wheredata,"id","asc");

													$is_field[]="a.`lab_in_charge_status`=1";
												$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($is_field);
													
													$billcondn[0]="id=".$billno;
													$form_creator ->popArr['billInfo']=$bill_obj->getBillInfo($billcondn);
													
												}

												$form_creator ->popArr['post'] = $postArr;
												$form_creator ->popArr['billno'] = $billno;
												$form_creator ->popArr['hInfo'] =$hinfo=$hobj->getHospitalInfo();
												$form_creator ->formPath ='/templates/lab/result_entry/email_lab_result.php';
												// $form_creator ->formPath ='/templates/lab/result_entry/download_result_pdf.php';
												break;	
case 'email_settings_lab'	   :
				
											$lab_obj=new LabModel();
											$wheredata=array();
											$wheredata[0]="usage_type = 'LAB'";
											$form_creator ->popArr['smtpInfo']=$smtpInfo=$lab_obj->getSmtpSettings($wheredata);
											// var_dump($smtpInfo);
											
										   
											$form_creator ->formPath ='/templates/admin/email settings/smtp_settings_form_lab.php';
											
											
													break;		
case 'smtp_settings_reports'	   :
				
											$lab_obj=new LabModel();
											$gen_obj = new General();
											$wheredata_smtp=array();
											$wheredata_smtp[0]="usage_type = 'REPORT'";
											$form_creator ->popArr['smtpInfo']=$smtpInfo=$lab_obj->getSmtpSettings($wheredata_smtp);
											// var_dump($smtpInfo);
											
											
											$wheredata=array();
			 								$wheredata[0]="id = 1";
			 								$form_creator ->popArr['regEmails']=$regEmails=$gen_obj->getRegEmails($wheredata);
											
										   
											$form_creator ->formPath ='/templates/admin/email settings/email_reports.php';
											
											
													break;
	case 'Lab_employees'		:
				
									$spec_obj=new Speciality();
									$dep_obj=new Department();
									$des_obj=new Designation();
									$emp_obj=new Employee();
									$user_obj=new User();
									// $wheredata[0]="id=39";

									$form_creator ->popArr['department']=$depInfo= $dep_obj->getDepartment('',$wheredata);
									// var_dump($depInfo);exit();
									$form_creator ->popArr['SpecialityInfo']	= $spec_obj->getSpeciality();
									$form_creator ->popArr['DesignationInfo']	= $des_obj->getDesignation();
							
										if(isset($postArr['paction']) && ($postArr['paction']=="SEARCH")){

											if(isset($postArr['search_by'])){
												$searchby=$postArr['search_by'];
												
												if(!empty($postArr['search_for'])){
													$search_for=$postArr['search_for'];

													if($searchby == 'first_name'){
														$is_field[]="a.`first_name`like '".$search_for."%'";

													}
												}
											}
										}
										$is_field[]="(d.`user_type`=6 or d.`user_type`=7)";
										$is_field[]="d.`status`=0";
										$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($is_field);
										 // var_dump($empInfo);exit();
										$userInfo=array();
										if(!empty($empInfo)){
											for($i=0;$i<count($empInfo);$i++){
												$empid=$empInfo[$i][0];
												$wheredata[0]="employee_id=".$empid;
												
												$userInfo[$i]=$user_obj->getUser('',$wheredata);
											}
										}
										$form_creator ->popArr['userInfo']=$userInfo;
										$form_creator ->formPath ='/templates/lab/labemployee/employees.php';
									// }
									break;	
					case 'Lab_signature':
										
										$emp_obj=new Employee();
										$user_obj=new User();
										if(!empty($postArr['id'])){
											 $emp_id = $postArr['id'];
											// echo $emp_id; exit();
										}
										$is_field[0]="(d.`user_type`=6 or d.`user_type`=7)";
										$is_field[1]="d.`status`=0";
										$is_field[2]="a.`id`=".$emp_id;
										$form_creator ->popArr['EmployeeInfo']=$empInfo= $emp_obj->getEmployee($is_field);
										  // var_dump($empInfo);exit();
										$userInfo=array();
										if(!empty($empInfo)){
											for($i=0;$i<count($empInfo);$i++){
												$empid=$empInfo[$i][0];
												$wheredata[0]="employee_id=".$empid;
												
												$userInfo[$i]=$user_obj->getUser('',$wheredata);
											}
										}

										$form_creator ->formPath ='/templates/lab/labemployee/employee_signature_upload_form.php';

									break;																																																	
																			
						
			}
			
			$form_creator->display();
	
	}
	
     function manageElements($post){
	
			$lab_obj=new LabModel();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$lab_obj->addElements($post);
								
					}else{
					
						$status=$lab_obj->updateElements($post);
					}
			
			}else if($action == "DELETE"){
				
				$status=$lab_obj->deleteElements($post);
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Elements',$post,'',$message);
	
	
	}
	 function manageCategory($post){
	
			$lab_obj=new LabModel();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$lab_obj->addCategory($post);
								
					}else{
					
						$status=$lab_obj->updateCategory($post);
					}
			
			}else if($action == "DELETE"){
				
				$status=$lab_obj->deleteCategory($post);
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Category',$post,'',$message);
	
	
	}
	 function manageGroupTest($post){

			$lab_obj=new LabModel();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$result=$lab_obj->addGroupTest($post);
						$status=$result[0];
						$tid=$result[1];
					}else{
					
						$result=$lab_obj->updateGroupTest($post);
						$status=$result[0];
						$tid=$result[1];
						
						$del_condn[0]="tid=".$tid;
						$lab_obj->deleteGroupTestElement($del_condn);
					}
			
			}else if($action == "DELETE"){
				
				$status=$lab_obj->deleteGroupTest($post);
				$status=$lab_obj->deleteTestElement($post);
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
				
				if($action =="ADD" || $action == "UPDATE"){
				//add test element
				$elementSelected=$post['elem_selected'];

				// var_dump($elementSelected);exit();

				if (!empty($elementSelected)) {
					
					// $elementSelected=explode("#", $elementSelected);

					for ($i=0; $i < count($elementSelected) ; $i++) { 
						
						$abc[$i] = explode("#", $elementSelected[$i]);

					}

				}

				if (!empty($abc)) {
					
					for ($i=0; $i < count($abc) ; $i++) { 

						// var_dump($abc[$i]);
						
						if ($abc[$i][1] == "elements") {
							$lab_obj->addGroupTestElement($tid,$abc[$i][0]);
						}
						else if ($abc[$i][1] == "sub_category") {
							$lab_obj->addTestSubCategory($tid,$abc[$i][0]);
						}

					}

				}

				// exit();
				
				// if(!empty($elementSelected)){
				// 	for($i=0;$i<count($elementSelected);$i++) {
				//        $lab_obj->addGroupTestElement($tid,$elementSelected[$i]);
				// 	}
				// }
				
				
				// $sub_cat=$post['sub_cat'];
			
				
				// if(!empty($sub_cat)){
				// 	for($i=0;$i<count($sub_cat);$i++) {
				//        $lab_obj->addTestSubCategory($tid,$sub_cat[$i]);
				// 	}
				// }
				}
				
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Group_test',$post,'',$message);
	
	
	}
	function manageSubcategory($post){
	
			$lab_obj=new LabModel();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$result=$lab_obj->addSubCategory($post);
						$status=$result[0];
						$sid=$result[1];
					}else{
					
						$result=$lab_obj->updateSubCategory($post);
						$status=$result[0];
						$sid=$result[1];
						
						$del_condn[0]="sid=".$sid;
						$lab_obj->deleteSubCategoryElement($del_condn);
					}
			
			}else if($action == "DELETE"){
				
				$status=$lab_obj->deleteSubCategory($post);
				$status=$lab_obj->deleteSubCatElement($post);
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
				
				if($action =="ADD" || $action == "UPDATE"){
				//add test element
				$elementSelected=$post['elem_selected'];
				
				if(!empty($elementSelected)){
					for($i=0;$i<count($elementSelected);$i++) {
				       $lab_obj->addsubCatElement($sid,$elementSelected[$i]);
					}
				}
				}
				
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('SubCategory',$post,'',$message);
	
	
	}
	
	function save_result_entry($post,$get){
		
		$lab_obj=new LabModel();
		$bill_obj=new Billing();
		$sms_obj = new SmsFunctions();
		$db_function =new DBFunction();
		$config_obj=new Config_hims();
		
		$type=$post['type'];
		$paction=$post['paction'];
		
		if($paction == "UPDATE"){
			$resultInfo=$lab_obj->getLabresultInfo($post['billno']);
			$result_id=$resultInfo[0][0];
			
			 $resultInfo=array();
			 $resultInfo[0]=$result_id;
		     $resultInfo[1]=$get['auth_id'];
			 $resultInfo[2]=$_SESSION['user_id'];
			 
			 
			 $lab_obj->update_lab_result($resultInfo);
			
			$where[0]="result_id=".$result_id;
			$lab_obj->delete_existing_result($where);
		}else{
		
		   $resultInfo[0]=$post['billno'];
		   $resultInfo[1]=date("Y-m-d H:i");
		   $resultInfo[2]=$get['auth_id'];
		   $resultInfo[3]=$_SESSION['user_id'];
		   $result_id=$lab_obj->save_lab_result($resultInfo);
		}
		
		if(!empty($type)){
		 
            for($i=0;$i<count($type);$i++){
               
			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]=$post['test_name'][$i];
			   $resultItemInfo[2]=$post['result_value'][$i];
			   $resultItemInfo[3]=$post['normal'][$i];
			   $resultItemInfo[4]=$post['tid'][$i];
			   $resultItemInfo[5]=$post['cid'][$i];
			   $resultItemInfo[6]=$type[$i];
			   $resultItemInfo[7]=$post['unit'][$i];
			   $resultItemInfo[8]=$result_id;
			   $resultItemInfo[9]=$post['test_range'][$i];

			   $description_data=$post[''.$i."_".$post['tid'][$i]."_tinymce".''][0];
			   $testValue  = trim(strip_tags($description_data));
						// echo $testValue;
								
				  if(!strlen($testValue) >= 1)
				
                    {
                        $description ='';
                     }
                     else
                     {
                        // $description =$description_data;
                        $description =$description_data;
                    }
			   
			   
			   $lab_obj->save_result_entry($resultItemInfo,$description);
            }			
		}


		// MONTOX CHANGES START
			if (!empty($post['arm_type'])) { 
				

			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]='';
			   $resultItemInfo[2]='<br>MANTOX TEST DETAILS<hr style="border-top: 2px solid #0f0f10;border-style: dashed;margin-top: 5px;margin-bottom: 5px;">';
			   $resultItemInfo[3]='';
			   $resultItemInfo[4]='';
			   $resultItemInfo[5]='';
			   $resultItemInfo[6]='HR';
			   $resultItemInfo[7]='';
			   $resultItemInfo[8]=$result_id;
			   $resultItemInfo[9]='';
			   
			   $lab_obj->save_result_entry($resultItemInfo);


			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]="<p style='padding-left: 20%;'>ARM</p>";
			   $resultItemInfo[2]=$post['arm_type'];
			   $resultItemInfo[3]='';
			   $resultItemInfo[4]='';
			   $resultItemInfo[5]='';
			   $resultItemInfo[6]='HR';
			   $resultItemInfo[7]='';
			   $resultItemInfo[8]=$result_id;
			    $resultItemInfo[9]='';
			   
			   $lab_obj->save_result_entry($resultItemInfo);

		
				
			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]="<p style='padding-left: 20%;'>GIVEN AT</p>";
			   $resultItemInfo[2]=$post['given_at'];
			   $resultItemInfo[3]='';
			   $resultItemInfo[4]='';
			   $resultItemInfo[5]='';
			   $resultItemInfo[6]='HR';
			   $resultItemInfo[7]='';
			   $resultItemInfo[8]=$result_id;
			    $resultItemInfo[9]='';
			   
			   $lab_obj->save_result_entry($resultItemInfo);

		
				
			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]="<p style='padding-left: 20%;'>READING ON</p>";
			   $resultItemInfo[2]=$post['reading_on'];
			   $resultItemInfo[3]='';
			   $resultItemInfo[4]='';
			   $resultItemInfo[5]='';
			   $resultItemInfo[6]='HR';
			   $resultItemInfo[7]='';
			   $resultItemInfo[8]=$result_id;
			    $resultItemInfo[9]='';
			   
			   $lab_obj->save_result_entry($resultItemInfo);


			   $resultItemInfo[0]=$post['billno'];
			   $resultItemInfo[1]='';
			   $resultItemInfo[2]='<hr style="border-top: 2px solid #0f0f10;border-style: dashed;margin-top: 5px !important;">';
			   $resultItemInfo[3]='';
			   $resultItemInfo[4]='';
			   $resultItemInfo[5]='';
			   $resultItemInfo[6]='HR';
			   $resultItemInfo[7]='';
			   $resultItemInfo[8]=$result_id;
			    $resultItemInfo[9]='';
			   
			   $lab_obj->save_result_entry($resultItemInfo);


			}
		// MONTOX CHANGES END




		if($paction == "SAVE"){
		   $bill_obj->update_lab_status($post['billno']);
		
		   $cust_type=$db_function->getidToValue("type","id",$post['billno'],"hcare_bill");
		   $ref_no=$db_function->getidToValue("ref_no","id",$post['billno'],"hcare_bill");
		   $opno=$db_function->getidToValue("opno","id",$post['billno'],"hcare_bill");
		
		   if($cust_type == "OP" || $cust_type == "IP"){
			
		     $phone=$db_function->getidToValue("contact_no","id",$opno,"hcare_op_patient_info");
		  
		   }else{
		
		 
		    $phone=$db_function->getidToValue("contact_no","id",$ref_no,"hcare_direct_customer");
		    }
		 
		     //echo $message."/".$phone;
		     if(strlen($phone) >= 10 && $phone>0){


				if ($config_obj->sms_status=="YES") {
														
			       $message=$sms_obj->lab_report_ready_sms;
			       $smsStatus = $sms_obj->sendSMS($phone,$message);		 
			       $bill_obj->update_sms_status($post['billno'],$smsStatus);

				}


		     }
			 
			 // $message=$sms_obj->lab_report_ready_sms;
		}
		
		
		$billno=$post['billno'];
		$post=array();
		$post['billno']=$billno;
		$post['result_id']=$result_id;
		$this->viewPage('print_lab_result',$post,'',$message);
		
	}

//for mail
	function updateMailStatus($post,$get){ 
		$bill_obj=new Billing();
		$user_obj=new User();		
		if(!empty($post['email_status'])) {
			$result = $bill_obj->updateEmailStatus($post['email_status'],$post['billno']);
		}
		$message='';
		$this->viewPage('search_lab_bill',$post,$get,$message);											
	}
	function saveSmtpSettings($post,$usage_type=null)
	{
		
		$lab_obj=new LabModel();
		$wheredata=array();
		$wheredata[0]="usage_type='".$usage_type."'";
		// $wheredata[0]="usage_type = 'LAB'";

		$smtpInfo=$lab_obj->getSmtpSettings($wheredata);
		// var_dump($smtpInfo);exit;
		// $usage_type='LAB';
		if (empty($smtpInfo)) {
			
			$result = $lab_obj->saveSmtpSettings($post,$usage_type);
		}
		else{
			$result = $lab_obj->updateSmtpSettings($post,$usage_type);
		}

		if($result){
			$message="Successfully Updated"; 
		}else{
			$message="Failed";
		}
		if($usage_type=='LAB'){
			$this->viewPage('email_settings_lab',$post,'',$message);
		}else{
			$this->viewPage('smtp_settings_reports',$post,'',$message);
		}


	}

		function labInChargeUpdate($post){
		// echo "aaaaaa";exit();
		$lab_obj=new LabModel();
		$db_obj=new DBFunction();
		$id=$post['id'];
		$lab_in_status=$post['lab_in_status'];
		if($lab_in_status == 1){
			$status=0;
			$lab_obj->updateLabInCharge($id,$status);
		}else{
		
		$lab_obj->clearLabInCharge();
		$status=1;
		$lab_obj->updateLabInCharge($id,$status);
	}
		$postArr['lab_in_charge_id']=$id;
		$this->viewPage('Lab_employees',$postArr);

	}
	    function add_lab_signature($post){

		  $lab_obj=new LabModel();
		  $db_obj=new DBFunction();	

		  // $opid=$post['id'];
		  $emp_id=$post['emp_id'];
		  $filename_uploaded=$post['filename_sign'];
		  // echo $emp_id;exit();
		  $file_name = $_FILES['document']['name'];
		  // $remark = $post['remark'];
		  $documentInfo['empno']=$post['emp_id'];
		  // $documentInfo['visit_id']="";
		  $documentInfo['document_name']=$file_name;
		  // $documentInfo['remarks']=$remark;

		  $allowed =  array('png' ,'jpg', 'pdf', 'jpeg');
		  $file_name = $_FILES['document']['name'];
		  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		  $file_path = "../../lib/lab_signatures/".$documentInfo['empno']."/";
               

    //       //FILE SIZE AND TYPE CHECKING      
		  // if(!in_array($ext,$allowed) || $_FILES['document']['size'] > 2097152   ) {



				// 	  		if (!in_array($ext,$allowed)) {
					  					  		
						  		
				// 		  		$post['active_module']="patient_documents";
				// 	       		$this->viewPage('View_Patient_Record',$post); 
				// 	       		echo "<script>showDialog('Error','File type not allowed','error',2);</script>";

				// 	  		}
				// 	  		else{			  				

						  		
				// 		  		$post['active_module']="patient_documents";
				// 	       		$this->viewPage('View_Patient_Record',$post); 
				// 	       		echo "<script>showDialog('Error','File size must be less than 2 MB','error',2);</script>";
				// 	  		}




		  // }
		  // else{
		  if(empty($filename_uploaded)){
		  			//FILE PATH CHECKING
					if (!is_dir($file_path)){

					mkdir($file_path, 0755);
					move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

														  
					}
					else{
						 
						 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
					
					}


						$lab_obj->update_signature($emp_id,$documentInfo);
	        			$post=array();
	        			$postArr['id']=$emp_id;
	        			$this->viewPage('Lab_signature',$postArr);
	        			// $post['id']=$emp_id;
	        			// $post['active_module']="patient_documents";
	       				// $this->viewPage('View_Patient_Record',$post);  




		   }
		   else{

		   	$file_path_old="../../lib/lab_signatures/".$documentInfo['empno']."/".$filename_uploaded;
		   	if(!empty($file_path_old)){
				if(file_exists($file_path_old)){
				
						unlink($file_path_old);
				}
			}
			//FILE PATH CHECKING
					if (!is_dir($file_path)){

					mkdir($file_path, 0755);
					move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);

														  
					}
					else{
						 
						 move_uploaded_file($_FILES["document"]["tmp_name"], $file_path . $_FILES["document"]["name"]);
					
					}


						$lab_obj->update_signature($emp_id,$documentInfo);
		   	

		   	$post=array();
			$postArr['id']=$emp_id;
			$this->viewPage('Lab_signature',$postArr);


		   }

	}
		function remove_lab_signature($post){
	       
	            $lab_obj=new LabModel();
		  		$db_obj=new DBFunction();
	           
		        $id=$post['hidden_remove'];
		        $filename_uploaded=$post['filename_sign'];
		        $file_path_old="../../lib/lab_signatures/".$id."/".$filename_uploaded;
		   	if(!empty($file_path_old)){
				if(file_exists($file_path_old)){
				
						unlink($file_path_old);
				}
			}
		        // echo $filename_uploaded;exit();

		        $lab_obj->remove_lab_signature($id);

		        $postArr['id']=$id;
			$this->viewPage('Lab_signature',$postArr); 

		                                
	}

	function update_patient_info($post,$get){ 
		
		$lab_obj=new LabModel();
		$bill_obj=new Billing();
		$sms_obj = new SmsFunctions();
		$db_function =new DBFunction();
		$config_obj=new Config_hims();
		
		
		$paction=$post['paction'];
		
		if($paction == "EDIT_PATIENT_INFO"){ 

			$age=$post['patient_age']." ".$post['patient_age_type'];

			// echo $age; exit;


			$dataInfo                  = array();

			$dataInfo['id']            = $post['direct_id']; 

			$dataInfo['name']          = $post['patient_name']; 
			$dataInfo['age']           = $age; 
			$dataInfo['gender']        = $post['patient_gender']; 
			$dataInfo['place']         = $post['patient_place']; 
			$dataInfo['contact_no']    = $post['patient_contact_no']; 
			$dataInfo['refferal_info'] = $post['patient_referral_info']; 
			 $dataInfo['prefix']        = $post['patient_prefix']; 
			 $dataInfo['doctor_direct_ID'] = $post['patient_doctor_direct_ID'];
			 $dataInfo['doctor_direct']    = $post['patient_doctor_direct'];
			 $dataInfo['paction']       =$paction;

			$bill_obj->updateCustomer($dataInfo);

			$email=$post['patient_email'];
			$billno=$post['billno'];
			$result=$bill_obj->editEmail($email,$billno);



		}
		
		
		$this->viewPage('search_lab_bill',$post,'',$message);
		
	}


	
}



?>
