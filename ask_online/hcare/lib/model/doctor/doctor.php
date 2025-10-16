<?php

require_once ROOT_PATH . '/lib/confs/DMLFunctions.php';
require_once ROOT_PATH . '/lib/confs/config.php';
class Doctor{

	var $dbConnection;
	
	
	function __construct(){
		$conf=new Config();
		$this->dbConnection=new DMLFunctions($conf);
		date_default_timezone_set('Asia/Kolkata');
	}
        function save_present_complaint($complaints,$duration,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","complaints","duration","date_time","update_history");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$complaints,$duration,date("d-m-Y H:i a"),$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_presenting_complaints");
		
		if($result) return true;
		else return 0;
	}
	function getPresent_complaint($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_presenting_complaints",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
                                                $arrList[$i][5]=$row[5];
                                              
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[6])){
			                             $history_split=explode("&&",$row[6]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_presenting_complaint($cid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_presenting_complaints","update_history","id",$cid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$cid,"hcare_presenting_complaints");
		
		if($result) return true;
		else return 0;
		
	}
	function save_provisional_diagnosis($diagnosis,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","diagnosis","date_time","update_history");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$diagnosis,date("d-m-Y H:i a"),$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_provisional_diagnosis");
		
		if($result) return true;
		else return 0;
	}
	
	function getProv_diagnosis($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_provisional_diagnosis",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_prov_diagnosis($pid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_provisional_diagnosis","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_provisional_diagnosis");
		
		if($result) return true;
		else return 0;
		
	}
	function save_procedure_prescribed($pid,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","pid","date_time","update_history");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$pid,date("d-m-Y H:i a"),$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_procedure_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function getProcedure_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_procedure_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$this->dbConnection->idToValue('hcare_procedure','procedure_test','id', $row[3]);
						$arrList[$i][5]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_procedure_presc($pid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_procedure_prescribed","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_procedure_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_labtest_prescribed($tid,$cid,$post,$type){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","tid","cid","date_time","update_history","type");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$tid,$cid,date("d-m-Y H:i a"),$update_history,$type);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_labtest_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function getLabtest_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_labtest_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						
						$type = $row[8];

						$cid=$row[4];
					        $check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row[3]);
					                   
					        if (!empty($type)) {

					        	if($type == 'LE'){
					                $arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row[3]);
								
								}else {
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row[3]); 
								}

					        }
					        else{

					            if($cid == $check_catid){
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row[3]);
								}
								else {
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row[3]);
								}
						


					        }


						
						$arrList[$i][5]=$row[4];
						$arrList[$i][6]=$row[5];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[6])){
			                             $history_split=explode("&&",$row[6]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][7]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_labtest_presc($lid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_labtest_prescribed","update_history","id",$lid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$lid,"hcare_labtest_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_medicine_prescribed($mid,$medicine_name,$course,$days,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","patient_type","visit_id","brand_id","brand_name","med_course","med_days","date_time","update_history");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$mid,$medicine_name,$course,$days,date("d-m-Y H:i a"),$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_medicine_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function getMedicine_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_medicine_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
					if($row[3] == 0) $arrList[$i][4]=$row[4];
					else $arrList[$i][4]=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id', $row[3]);
						$arrList[$i][5]=$row[5];
                                                $arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[8])){
			                             $history_split=explode("&&",$row[8]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][8]= $update_history;
											
						$i++;
				}
				
			
			}
			else{

				while($row=mysqli_fetch_array($result)){
					
					$arrList[$i][0]=$row[0];

					$i++;

				}

			}	
		
		}
		return $arrList;	
	
	}
	function delete_medicine_presc($mid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_medicine_prescribed","update_history","id",$mid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$mid,"hcare_medicine_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_consultation_details($remarks,$cons_status,$followup_date,$opid,$advice,$examination){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_op_visit_info","cons_history","id",$opid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('dr_remarks','cons_status','followup_date','cons_history','dr_advice','examination');
		$field_data=array($remarks,$cons_status,$followup_date,$update_history,$advice,$examination);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$opid,"hcare_op_visit_info");
		
		if($result) return true;
		else return 0;
		
	}
	function setDrconsulted($post){
	
		$field_names1=array('cons_status');
		$field_data=array('YES');
		
		  if(isset($post['opid'])) {
				 $opid=$post['opid'];
				 $post['id']=$opid;
		  }else $opid=$post['id'];
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$opid,"hcare_op_visit_info");
		
		if($result) return true;
		else return 0;
		
	}
	function resetDrconsulted($post){
	
		$field_names1=array('cons_status');
		$field_data=array('');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$post['id'],"hcare_op_visit_info");
		
		if($result) return true;
		else return 0;
		
	}
	
	 function save_physical_examination($field_names,$field_data){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names[]="update_history";
			
			$field_data[]=$update_history;
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_physical_examination");
		
		if($result) return true;
		else return 0;
	}
	function update_physical_examination($field_names,$field_data,$phid){
		
	
	 //updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_physical_examination","update_history","id",$phid);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			   
	          $field_names[]="update_history";
			
			$field_data[]=$update_history;
			
		$result=$this->dbConnection->update($field_names,$field_data,"id",$phid,"hcare_physical_examination");
		
		if($result) return true;
		else return false;
	
	}
	function getPhysicalExamination($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_physical_examination",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['patient_type'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['temp'];
						$arrList[$i][4]=$row['pulse'];
						$arrList[$i][5]=$row['bp'];
						$arrList[$i][6]=$row['height'];
						$arrList[$i][7]=$row['weight'];
						$arrList[$i][8]=$row['bmi'];
						$arrList[$i][9]=$row['resp'];
						$arrList[$i][10]=$row['oxygen_satu'];
						$arrList[$i][11]=$row['gen_condn'];
					
                                             
						//split updation history
		                                $update_history='';
		                                $update_history_list=array();
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                                $update_history_list[]=$user_name.":".$datetime;
			                             }
			                          }
		                               }
					        $arrList[$i][12]= $update_history;
					        $arrList[$i][13]= $update_history_list;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function add_patient_allergy($allergyInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","opno","visit_id","allergic_to","description","update_history");
			
			$field_data=array("",$allergyInfo['opno'],$allergyInfo['visit_id'],$allergyInfo['allergic_to'],$allergyInfo['description'],$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_patient_allergies");
		
		if($result) return true;
		else return 0;
	}
	function getPatient_allergies($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_patient_allergies",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['allergic_to'];
						$arrList[$i][4]=$row['description'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function CountPatient_allergies($wheredata = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_patient_allergies",'',$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		
		return mysqli_num_rows($result);
	
	}
	function delete_patient_allergy($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_patient_allergies","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_patient_allergies");
		
		if($result) return true;
		else return 0;
		
	}

	function add_patient_document($documentInfo){
	          
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","opno","ipno","visit_id","document_name","remarks","update_history","direct_id","bill_no","cust_type","xray_status");
			
			$field_data=array("",$documentInfo['opno'],$documentInfo['ipno'],$documentInfo['visit_id'],$documentInfo['document_name'],$documentInfo['remarks'],$update_history,$documentInfo['direct_id'],$documentInfo['bill_id'],$documentInfo['cust_type'],$documentInfo['xray_status']);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
	}



	function getPatient_documents($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_patient_documents",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['document_name'];
						$arrList[$i][4]=$row['remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
					        $arrList[$i][6]=$row['bill_no'];
					        $arrList[$i][7]=$row['direct_id'];
					        $arrList[$i][8]=$row['cust_type'];
					        $arrList[$i][9]=$row['xray_status'];
					        $arrList[$i][10]=$row['ipno'];
					        //$arrList[$i][11]=$this->dbConnection->idToValue('hcare_ip_info','ipno','id', $row['ipno']);
					        $arrList[$i][11]=0;
					        //$row['xray_status'];
					        $arrList[$i][12]=$this->dbConnection->idToValue('hcare_bill','bill_date','id', $row['bill_no']);

					       
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

	function delete_patient_document($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
		
	}

	function save_diabetic_status($opno,$diabetic_status){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","opno","diabetic","update_history");
			
			$field_data=array("",$opno,$diabetic_status,$update_history);
			
			
	
		    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_general_info");
		
		if($result) return true;
		else return 0;
	}
	function save_hyper_tension_status($opno,$is_hyper_ten){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","opno","hyper_tension","update_history");
			
			$field_data=array("",$opno,$is_hyper_ten,$update_history);
			
			
	
		    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_op_general_info");
		
		if($result) return true;
		else return 0;
	}
    function update_diabetic_status($opno,$diabetic_status){
		
		//updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_op_general_info","update_history","opno",$opno);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	
	        $field_names=array("diabetic","update_history");
			
			$field_data=array($diabetic_status,$update_history);
			
	  $result=$this->dbConnection->update($field_names,$field_data,"opno",$opno,"hcare_op_general_info");
		
		if($result) return $id;
		else return 0;
	
	}
    function update_hyper_tension_statuss($opno,$is_hyper_ten){
		
		//updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_op_general_info","update_history","opno",$opno);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	
	        $field_names=array("hyper_tension","update_history");
			
			$field_data=array($is_hyper_ten,$update_history);
			
	  $result=$this->dbConnection->update($field_names,$field_data,"opno",$opno,"hcare_op_general_info");
		
		if($result) return $id;
		else return 0;
	
	}
    function get_diabetic_status($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_op_general_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['diabetic'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function get_hyper_tesion_status($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_op_general_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['hyper_tension'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function add_diabetic_reading($readingInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
	
			$field_names=array("id","opno","visit_id","sugar_level","reading_type","reading_date","update_history");
			
			$field_data=array("",$readingInfo['opno'],$readingInfo['visit_id'],$readingInfo['sugar_level'],$readingInfo['reading_type'],$readingInfo['reading_date'],$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_patient_diabetic_readings");
		
		if($result) return true;
		else return 0;
	}
	
	function get_diabetic_readings($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_patient_diabetic_readings",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['sugar_level'];
						$arrList[$i][3]=$row['reading_type'];
						$arrList[$i][4]=$row['reading_date'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function delete_diabetic_reading($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_patient_diabetic_readings","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_patient_diabetic_readings");
		
		if($result) return true;
		else return 0;
		
	}

	function save_past_history($past_history,$post){

	

		$patient_type=$post['patient_type'];
		$visit_id=$post['opid'];
		$op_id=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$visit_id);
		$past_history=$past_history;
			 $datetime=date("Y:m:d H:i:s");
		
		$user_id=$_SESSION['user_id'];
		$update_history = $user_id."|". date("d-m-Y H:i a");
		$status=0;


			$field_names=array("id","patient_type","op_id","visit_id","past_history","datetime","update_history","status");
				
			$field_data=array("",$patient_type,$op_id,$visit_id,$past_history,$datetime,$update_history,$status);	

			$result=$this->dbConnection->insert($field_names,$field_data,"hcare_past_history");

		
		if($result) return true;
		else return 0;		

		
	}

	function getPastHistory($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status=0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_past_history",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
	
		if(mysqli_num_rows($result)>0){
			
				while($row=mysqli_fetch_array($result)){
					
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
						$arrList[$i][5]=$row[5];
						$arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[7])){
			                             $history_split=explode("&&",$row[7]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][8]= $update_history;
					       
											
						$i++;
				}
				
			
		
		
		}

		return $arrList;	
	
	}	

	function delete_past_history($pid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_past_history","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('update_history','status');
		$field_data=array($update_history,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_past_history");
		
		if($result) return true;
		else return 0;
		
	}
	function save_radiology_prescribed($rid,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","rid","date_time","update_history");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$rid,date("d-m-Y H:i a"),$update_history);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_radiology_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function getRadiology_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_radiology_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$this->dbConnection->idToValue('hcare_procedure','procedure_test','id', $row[3]);
						$arrList[$i][5]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_radiology_presc($rid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_radiology_prescribed","update_history","id",$rid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$rid,"hcare_radiology_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_medicine_courses($course){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","course","update_history","status");
			
			$field_data=array("",$course,$update_history,0);
			
			
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_medicine_course");
		
		if($result) return true;
		else return 0;
	}
    function add_referal_info($referalInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","visit_id","date","refering_doc","refered_doc","ref_type","remarks","update_history","status");
			
			$field_data=array("",$referalInfo['visit_id'],$referalInfo['date'],$referalInfo['refering_doc'],$referalInfo['refered_doc'],$referalInfo['ref_type'],$referalInfo['remarks'],$update_history,0);
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_doctor_referal_info");
		
		if($result) return true;
		else return 0;
	}
	function getDrReferalInfo($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_doctor_referal_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['visit_id'];
						$arrList[$i][2]=$row['date'];
						$arrList[$i][3]=$row['refering_doc'];
						$arrList[$i][4]=$row['refered_doc'];
						$arrList[$i][5]=$row['remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
					        $arrList[$i][7]=$row['status'];

					        $arrList[$i][8]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$row['refering_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$row['refering_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','last_name','id',$row['refering_doc']);

					        $arrList[$i][9]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$row['refered_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$row['refered_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','last_name','id',$row['refered_doc']);

					        $arrList[$i][10]=$row['ref_type'];

											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_referal_info($id){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_doctor_referal_info","update_history","id",$id);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_doctor_referal_info");
		
		if($result) return true;
		else return 0;
		
	}
	function save_followup($followup){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","followup","update_history","status");
			
			$field_data=array("",$followup,$update_history,0);
			
			
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_followup_date");
		
		if($result) return true;
		else return 0;
	}



//===============================================================================================================================
//                                   inpatient emr
//===============================================================================================================================
    function save_ip_present_complaint($complaints,$duration,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	
			$field_names=array("id","patient_type","visit_id","complaints","duration","date_time","update_history","ipno","ref_no","entered_by");

			 $datetime=date("Y:m:d H:i:s");
			
		
			
			$field_data=array("",$post['patient_type'],$post['opid'],$complaints,$duration,$datetime,$update_history,$post['ipno'],$post['ref_ipno'],$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_presenting_complaints");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Present_complaint($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_presenting_complaints",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
                                                $arrList[$i][5]=$row[5];
                                              
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[6])){
			                             $history_split=explode("&&",$row[6]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
					        $arrList[$i][7]= $row[7];
					        $arrList[$i][8]= $row[8];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_presenting_complaint($cid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_presenting_complaints","update_history","id",$cid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$cid,"hcare_ip_presenting_complaints");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_provisional_diagnosis($diagnosis,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime=date("Y:m:d H:i:s");
			 
	
			$field_names=array("id","patient_type","visit_id","diagnosis","date_time","update_history","ipno","ref_no","entered_by");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$diagnosis, $datetime,$update_history,$post['ipno'],$post['ref_ipno'],$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_provisional_diagnosis");
		
		if($result) return true;
		else return 0;
	}
	
	function get_ip_Prov_diagnosis($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_provisional_diagnosis",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_prov_diagnosis($pid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_provisional_diagnosis","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_ip_provisional_diagnosis");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_procedure_prescribed($pid,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime=date("Y:m:d H:i:s");
	
			$field_names=array("id","patient_type","visit_id","pid","date_time","update_history","ipno","ref_no","entered_by");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$pid, $datetime,$update_history,$post['ipno'],$post['ref_ipno'],$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_procedure_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Procedure_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_procedure_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$this->dbConnection->idToValue('hcare_procedure','procedure_test','id', $row[3]);
						$arrList[$i][5]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_procedure_presc($pid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_procedure_prescribed","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_ip_procedure_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_labtest_prescribed($tid,$cid,$post,$type){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime=date("Y:m:d H:i:s");
			 

	
			$field_names=array("id","patient_type","visit_id","tid","cid","date_time","update_history","ipno","ref_no","entered_by","type");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$tid,$cid,$datetime,$update_history,$post['ipno'],$post['ref_ipno'],$user_id,$type);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_labtest_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Labtest_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_labtest_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						
						$cid=$row[4];
						$type= $row[12];
					  //       $check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row[3]);
					                   
					  //               if($cid == $check_catid){
					                   
							// 	$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row[3]);
							// }else {
							// 	$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row[3]);
							// }
						$check_catid=$this->dbConnection->idToValue("hcare_lab_test","category","id",$row[3]);
					                   
					        if (!empty($type)) {

					        	if($type == 'LE'){
					                $arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row[3]);
								
								}else {
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row[3]); 
								}

					        }
					        else{

					            if($cid == $check_catid){
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_test","test_name","id",$row[3]);
								}
								else {
									$arrList[$i][4]=$this->dbConnection->idToValue("hcare_lab_element","test_name","id",$row[3]);
								}
						


					        }
						
						$arrList[$i][5]=$row[4];
						$arrList[$i][6]=$row[5];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[6])){
			                             $history_split=explode("&&",$row[6]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][7]= $update_history;
					        $arrList[$i][8]= $row[11];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_labtest_presc($lid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_labtest_prescribed","update_history","id",$lid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$lid,"hcare_ip_labtest_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_medicine_prescribed($mid,$medicine_name,$course,$days,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			 $datetime=date("Y:m:d H:i:s");
			 
	
			$field_names=array("id","patient_type","visit_id","brand_id","brand_name","med_course","med_days","date_time","update_history","ipno","ref_no","entered_by");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$mid,$medicine_name,$course,$days,$datetime,$update_history,$post['ipno'],$post['ref_ipno'],$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_medicine_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Medicine_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_medicine_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
					if($row[3] == 0) $arrList[$i][4]=$row[4];
					else $arrList[$i][4]=$this->dbConnection->idToValue('hcare_pharma_brand','brand','id', $row[3]);
						$arrList[$i][5]=$row[5];
                                                $arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[8])){
			                             $history_split=explode("&&",$row[8]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][8]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_medicine_presc($mid){
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_medicine_prescribed","update_history","id",$mid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$mid,"hcare_ip_medicine_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_consultation_details($post){
	    
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("ip_emr_meta","update_history","ipno",$post['ipno']);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			 $datetime=date("Y:m:d H:i:s");
		       
		
		$field_names1=array('dr_remarks','ipno','date_time','update_history','dr_advice','ref_no','visit_id','entered_by');
		$field_data=array($post['remarks'],$post['ipno'],$datetime,$update_history,$post['advice'],$post['ref_ipno'],$post['opid'],$user_id);
		


		$result=$this->dbConnection->insert($field_names1,$field_data,"ip_emr_meta");
		
		if($result) return true;
		else return 0;
		
	}


	function update_ip_consultation_details($post,$id){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("ip_emr_meta","update_history","ipno",$post['ipno']);
		      
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('dr_remarks','update_history','dr_advice');
		$field_data=array($post['remarks'],$update_history,$post['advice']);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"ip_emr_meta");
		
		if($result) return true;
		else return 0;
		
	}


	function get_ip_consultation_details($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("ip_emr_meta",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['dr_advice'];
						$arrList[$i][4]=$row['dr_remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
					        $arrList[$i][6]=$row['date_time'];
					        $arrList[$i][7]=$row['entered_by'];
					        $arrList[$i][8]=$row['ipno'];
					        $arrList[$i][9]=$row['ref_no'];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}






	
	 function save_ip_physical_examination($field_names,$field_data){
	
	          
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
	         $date_time=date("d-m-Y H:i a");
			$field_names[]="update_history";
			
			$field_data[]=$update_history;


		
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_physical_examination");
		
		if($result) return true;
		else return 0;
	}
	function update_ip_physical_examination($field_names,$field_data,$phid){
		
	
	 //updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_ip_physical_examination","update_history","id",$phid);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			   
	          $field_names[]="update_history";
			
			$field_data[]=$update_history;
			
		$result=$this->dbConnection->update($field_names,$field_data,"id",$phid,"hcare_ip_physical_examination");
		
		if($result) return true;
		else return false;
	
	}
	function get_ip_PhysicalExamination($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_physical_examination",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['patient_type'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['temp'];
						$arrList[$i][4]=$row['pulse'];
						$arrList[$i][5]=$row['bp'];
						$arrList[$i][6]=$row['height'];
						$arrList[$i][7]=$row['weight'];
						$arrList[$i][8]=$row['bmi'];
						$arrList[$i][9]=$row['resp'];
						$arrList[$i][10]=$row['oxygen_satu'];
						$arrList[$i][11]=$row['gen_condn'];
					
                                             
						//split updation history
		                                $update_history='';
		                                $update_history_list=array();
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                                $update_history_list[]=$user_name.":".$datetime;
			                             }
			                          }
		                               }
					        $arrList[$i][12]= $update_history;
					        $arrList[$i][13]= $update_history_list;
					        $arrList[$i][14]=$row['date_time'];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function add_ip_patient_allergy($allergyInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			 $datetime=date("Y:m:d H:i:s");
			
	
			$field_names=array("id","opno","visit_id","allergic_to","description","update_history","ipno","ref_no","date_time","entered_by");
			
			$field_data=array("",$allergyInfo['visit_id'],$allergyInfo['opno'],$allergyInfo['allergic_to'],$allergyInfo['description'],$update_history,$allergyInfo['ipno'],$allergyInfo['ref_ipno'],$datetime,$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_patient_allergies");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Patient_allergies($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_patient_allergies",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['allergic_to'];
						$arrList[$i][4]=$row['description'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
					        $arrList[$i][6]=$row['date_time'];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function Count_ip_Patient_allergies($wheredata = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_patient_allergies",'',$wheredata);	
		$result=$this->dbConnection->executeQuery($query);
		
		return mysqli_num_rows($result);
	
	}
	function delete_ip_patient_allergy($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_patient_allergies","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_ip_patient_allergies");
		
		if($result) return true;
		else return 0;
		
	}

	function add_ip_patient_document($documentInfo){
	          
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			 $datetime=date("Y:m:d H:i:s");
			 
	
			$field_names=array("id","opno","ipno","visit_id","document_name","remarks","update_history","direct_id","bill_no","cust_type","xray_status","date_time","entered_by");
			
			$field_data=array("",$documentInfo['opno'],$documentInfo['ipno'],$documentInfo['visit_id'],$documentInfo['document_name'],$documentInfo['remarks'],$update_history,$documentInfo['direct_id'],$documentInfo['bill_id'],$documentInfo['cust_type'],$documentInfo['xray_status'],$datetime,$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
	}



	function get_ip_Patient_documents($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_patient_documents",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['document_name'];
						$arrList[$i][4]=$row['remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
					        $arrList[$i][6]=$row['bill_no'];
					        $arrList[$i][7]=$row['direct_id'];
					        $arrList[$i][8]=$row['cust_type'];
					        $arrList[$i][9]=$row['xray_status'];
					        $arrList[$i][10]=$row['ipno'];
					       // $arrList[$i][11]=$this->dbConnection->idToValue('hcare_ip_info','ipno','id', $row['ipno']);
					         $arrList[$i][11]=0;
					        //$row['xray_status'];
					        $arrList[$i][12]=$this->dbConnection->idToValue('hcare_bill','bill_date','id', $row['bill_no']);

					       
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

	function delete_ip_patient_document($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
		
	}


	function add_ip_patient_xray_document($documentInfo){
	          
	     
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			 $datetime=date("Y:m:d H:i:s");
			 
	
			$field_names=array("id","opno","ipno","visit_id","document_name","remarks","update_history","direct_id","bill_no","cust_type","xray_status","date_time","entered_by");
			
			$field_data=array("",$documentInfo['opno'],$documentInfo['ipno'],$documentInfo['visit_id'],$documentInfo['document_name'],$documentInfo['remarks'],$update_history,$documentInfo['direct_id'],$documentInfo['bill_id'],$documentInfo['cust_type'],1,$datetime,$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
	}



	function get_ip_Patient_xray_documents($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
				// $wheredata[0]="xray_status = 1";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_patient_documents",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['visit_id'];
						$arrList[$i][3]=$row['document_name'];
						$arrList[$i][4]=$row['remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][5]= $update_history;
					        $arrList[$i][6]=$row['bill_no'];
					        $arrList[$i][7]=$row['direct_id'];
					        $arrList[$i][8]=$row['cust_type'];
					        $arrList[$i][9]=$row['xray_status'];
					        $arrList[$i][10]=$row['ipno'];
					        // $arrList[$i][11]=$this->dbConnection->idToValue('hcare_ip_info','ipno','id', $row['ipno']);
					        $arrList[$i][11]=0;
					        //$row['xray_status'];
					        $arrList[$i][12]=$this->dbConnection->idToValue('hcare_bill','bill_date','id', $row['bill_no']);

					       
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}

	function delete_ip_patient_xray_document($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_patient_documents","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_patient_documents");
		
		if($result) return true;
		else return 0;
		
	}

	function save_ip_diabetic_status($opno,$diabetic_status){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
			 $datetime=date("Y:m:d H:i:s");
	        
			$field_names=array("id","opno","diabetic","update_history","date_time","entered_by");
			
			$field_data=array("",$opno,$diabetic_status,$update_history,$datetime,$user_id);
			
			
	
		    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_general_info");
		
		if($result) return true;
		else return 0;
	}
	function save_ip_hyper_tension_status($opno,$is_hyper_ten){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
			
			 $datetime=date("Y:m:d H:i:s");
	        
			$field_names=array("id","opno","hyper_tension","update_history","date_time","entered_by");
			
			$field_data=array("",$opno,$is_hyper_ten,$update_history,$datetime,$user_id);
			
			
	
		    $result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_general_info");
		
		if($result) return true;
		else return 0;
	}
    function update_ip_diabetic_status($opno,$diabetic_status){
		
		//updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_general_info","update_history","opno",$opno);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	        
	        $field_names=array("diabetic","update_history");
			
			$field_data=array($diabetic_status,$update_history);
			
	  $result=$this->dbConnection->update($field_names,$field_data,"opno",$opno,"hcare_ip_general_info");
		
		if($result) return $id;
		else return 0;
	
	}
    function update_ip_hyper_tension_statuss($opno,$is_hyper_ten){
		
		//updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_general_info","update_history","opno",$opno);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	
	        $field_names=array("hyper_tension","update_history");
			
			$field_data=array($is_hyper_ten,$update_history);
			
	  $result=$this->dbConnection->update($field_names,$field_data,"opno",$opno,"hcare_ip_general_info");
		
		if($result) return $id;
		else return 0;
	
	}
    function get_ip_diabetic_status($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_ip_general_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['diabetic'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function get_ip_hyper_tesion_status($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_ip_general_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['hyper_tension'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function add_ip_diabetic_reading($readingInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime= date("Y-m-d H:i:s");
			
	
			$field_names=array("id","opno","visit_id","sugar_level","reading_type","reading_date","update_history","entered_by","ipno","ref_no","date_time");
			
			$field_data=array("",$readingInfo['opno'],$readingInfo['visit_id'],$readingInfo['sugar_level'],$readingInfo['reading_type'],$readingInfo['reading_date'],$update_history,$user_id,$readingInfo['ipno'],$readingInfo['ref_ipno'],$datetime);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_patient_diabetic_readings");
		
		if($result) return true;
		else return 0;
	}
	
	function get_ip_diabetic_readings($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		$query=$this->dbConnection->BuiltQuery("hcare_ip_patient_diabetic_readings",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['opno'];
						$arrList[$i][2]=$row['sugar_level'];
						$arrList[$i][3]=$row['reading_type'];
						$arrList[$i][4]=$row['reading_date'];
						$i++;
				}
			}
		}
		
		return $arrList;

	}
    function delete_ip_diabetic_reading($aid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_patient_diabetic_readings","update_history","id",$aid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$aid,"hcare_ip_patient_diabetic_readings");
		
		if($result) return true;
		else return 0;
		
	}

	function save_ip_past_history($past_history,$post){

	

		$patient_type=$post['patient_type'];
		$visit_id=$post['opid'];
		$op_id=$this->dbConnection->idToValue("hcare_op_visit_info","opno","id",$visit_id);
		$past_history=$past_history;
			 $datetime=date("Y:m:d H:i:s");
		
		$user_id=$_SESSION['user_id'];
		$update_history = $user_id."|". date("d-m-Y H:i a");
		$status=0;


			$field_names=array("id","patient_type","op_id","visit_id","past_history","date_time","update_history","status","ipno","entered_by");
				
			$field_data=array("",$patient_type,$op_id,$visit_id,$past_history,$datetime,$update_history,$status,$post["ipno"],$user_id);	

			$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_past_history");

		
		if($result) return true;
		else return 0;		

		
	}

	function get_ip_PastHistory($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status=0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_past_history",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
	
		if(mysqli_num_rows($result)>0){
			
				while($row=mysqli_fetch_array($result)){
					
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
						$arrList[$i][5]=$row[5];
						$arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[7])){
			                             $history_split=explode("&&",$row[7]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][8]= $update_history;
					       
											
						$i++;
				}
				
			
		
		
		}

		return $arrList;	
	
	}	

	function delete_ip_past_history($pid){

	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_past_history","update_history","id",$pid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('update_history','status');
		$field_data=array($update_history,'1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$pid,"hcare_ip_past_history");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_radiology_prescribed($rid,$post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime=date("Y:m:d H:i:s");
	
			$field_names=array("id","patient_type","visit_id","rid","date_time","update_history","ipno","ref_no","entered_by");
			
			$field_data=array("",$post['patient_type'],$post['opid'],$rid,$datetime,$update_history,$post["ipno"],$post["ref_ipno"],$user_id);
			
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_radiology_prescribed");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_Radiology_presc($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_radiology_prescribed",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$this->dbConnection->idToValue('hcare_procedure','procedure_test','id', $row[3]);
						$arrList[$i][5]=$row[4];
                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[5])){
			                             $history_split=explode("&&",$row[5]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_radiology_presc($rid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_radiology_prescribed","update_history","id",$rid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$rid,"hcare_ip_radiology_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_medicine_courses($course){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","course","update_history","status");
			
			$field_data=array("",$course,$update_history,0);
			
			
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_medicine_course");
		
		if($result) return true;
		else return 0;
	}
    function add_ip_referal_info($referalInfo){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","visit_id","date","refering_doc","refered_doc","ref_type","remarks","update_history","status");
			
			$field_data=array("",$referalInfo['visit_id'],$referalInfo['date'],$referalInfo['refering_doc'],$referalInfo['refered_doc'],$referalInfo['ref_type'],$referalInfo['remarks'],$update_history,0);
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_doctor_referal_info");
		
		if($result) return true;
		else return 0;
	}
	function get_ip_DrReferalInfo($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_doctor_referal_info",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row['id'];
						$arrList[$i][1]=$row['visit_id'];
						$arrList[$i][2]=$row['date'];
						$arrList[$i][3]=$row['refering_doc'];
						$arrList[$i][4]=$row['refered_doc'];
						$arrList[$i][5]=$row['remarks'];
						
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row['update_history'])){
			                             $history_split=explode("&&",$row['update_history']);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][6]= $update_history;
					        $arrList[$i][7]=$row['status'];

					        $arrList[$i][8]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$row['refering_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$row['refering_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','last_name','id',$row['refering_doc']);

					        $arrList[$i][9]=$this->dbConnection->idToValue('hcare_emp_info','title','id',$row['refered_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','first_name','id',$row['refered_doc'])." ".$this->dbConnection->idToValue('hcare_emp_info','last_name','id',$row['refered_doc']);

					        $arrList[$i][10]=$row['ref_type'];

											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_referal_info($id){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_doctor_referal_info","update_history","id",$id);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$id,"hcare_doctor_referal_info");
		
		if($result) return true;
		else return 0;
		
	}
	function save_ip_followup($followup){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 
	
			$field_names=array("id","followup","update_history","status");
			
			$field_data=array("",$followup,$update_history,0);
			
			
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_followup_date");
		
		if($result) return true;
		else return 0;
	}

function save_ip_ot_note($post){
	
	                
			 $user_id=$_SESSION['user_id'];
			 $update_history = $user_id."|". date("d-m-Y H:i a");
			 $datetime=date("Y-m-d H:i:s");
	
			 $field_names=array("id","patient_type","visit_id","ot_note","date_time","entered_by","update_history","ipno","ref_no");
			
			 $field_data=array("",$post['patient_type'],$post['visit_id'],$post['ot_note'],$datetime,$user_id,$update_history,$post["ipno"],$post["ref_ipno"]);
			
	
		$result=$this->dbConnection->insert($field_names,$field_data,"hcare_ip_ot_notes");
		
		if($result) return true;
		else return 0;
	}

   function edit_ip_ot_note($post){

	           
			$user_id=$_SESSION['user_id'];

			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_ot_notes","update_history","id",$post['oid']);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
	
			$field_names=array("ot_note","update_history");
			
			$field_data=array($post['ot_note_update'],$update_history);

		    $result=$this->dbConnection->update($field_names,$field_data,"id",$post['oid'],"hcare_ip_ot_notes");
		
		    if($result) return $id;
		    else return 0;	
	
		
	}


	function get_ip_ot_notes($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_ip_ot_notes",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
						$arrList[$i][5]=$row[5];
						$arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
						$arrList[$i][8]=$row[8];

                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[8])){
			                             $history_split=explode("&&",$row[8]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                             }
			                          }
		                               }
					        $arrList[$i][9]= $update_history;
					        $arrList[$i][10]=$row[9];
					        $arrList[$i][11]=$row[10];
											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function delete_ip_ot_note($oid){
	
	       //updation history
			$user_id=$_SESSION['user_id'];
			
		         $old_update=$this->dbConnection->idToValue("hcare_ip_ot_notes","update_history","id",$oid);
			
	               if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
		
		$field_names1=array('status','update_history');
		$field_data=array('1',$update_history);
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$oid,"hcare_ip_ot_notes");
		
		if($result) return true;
		else return 0;
		
	}
	function add_covid_status($post){
			
			date_default_timezone_set('Asia/Kolkata');
		                
			$user_id=$_SESSION['user_id'];
			$update_history = $user_id."|". date("d-m-Y H:i a");
			$datetime=date("Y-m-d H:i:s");
		
			$field_names=array("id","patient_type","opno","visit_id","date","travel_abroad","travel_contact","contact_patient","contact_suspect","covid_syptoms","covid_19_symptoms","user_id","update_history","status");
				
			$field_data=array("",$post['patient_type'],$post['opno'],$post['visit_id'],$datetime,$post['travel_abroad'],$post['travel_contact'],$post['contact_patient'],$post['contact_suspect'],$post['covid_syptoms'],$post['covid_19_symptoms'],$user_id,$update_history,0);
				
				
			$result=$this->dbConnection->insert($field_names,$field_data,"hcare_covid_19_status");
			
			if($result) return true;
			else return 0;
	}
	function get_covid_info($selectfield = null,$wheredata = null,$orderbyfield = null,$orderby = null){
	
		$arrList=array();
		
		if(empty($wheredata)){
				$wheredata[0]="status = 0";
		}
		$query=$this->dbConnection->BuiltQuery("hcare_covid_19_status",$selectfield,$wheredata,$orderbyfield,$orderby);	
		$result=$this->dbConnection->executeQuery($query);
		$i=0;
		
		if(mysqli_num_rows($result)>0){
			if(empty($selectfield)){
				while($row=mysqli_fetch_array($result)){
				
						
						$arrList[$i][0]=$row[0];
						$arrList[$i][1]=$row[1];
						$arrList[$i][2]=$row[2];
						$arrList[$i][3]=$row[3];
						$arrList[$i][4]=$row[4];
						$arrList[$i][5]=$row[5];
						$arrList[$i][6]=$row[6];
						$arrList[$i][7]=$row[7];
						$arrList[$i][8]=$row[8];
						$arrList[$i][9]=$row[9];
						$arrList[$i][10]=$row[10];
						$arrList[$i][11]=$row[11];
						$arrList[$i][12]=$row[12];


                                             
						//split updation history
		                                $update_history='';
			
			                        if(!empty($row[12])){
			                             $history_split=explode("&&",$row[12]);
						     
			                           if(!empty($history_split)){
			
			                             for($m=0;$m<count($history_split);$m++) {
			                                $history_info=explode("|",$history_split[$m]);
							$user_name=$this->dbConnection->idToValue('hcare_users','user_name','id', $history_info[0]);
			                                $datetime=$history_info[1];
			                                $update_history .=$user_name.":".$datetime."<br>";
			                                $update_history_list[]=$user_name.":".$datetime;
			                             }
			                          }
		                               }
					        $arrList[$i][13]= $update_history;
					        $arrList[$i][14]=$row[13];
					        $arrList[$i][15]= $update_history_list;

											
						$i++;
				}
				
			
			}
		
		}
		return $arrList;	
	
	}
	function update_covid_status($post,$covid_id){
		
	
	 //updation history
			$user_id=$_SESSION['user_id'];
			date_default_timezone_set('Asia/Kolkata');
			$old_update=$this->dbConnection->idToValue("hcare_covid_19_status","update_history","id",$covid_id);
			if(!empty($old_update)){
	   
	                       $update_history = $user_id."|". date("d-m-Y H:i a")."&&".$old_update;
	   
	               }else{
	                     $update_history = $user_id."|". date("d-m-Y H:i a");
		       }
			   
			$field_names=array("travel_abroad","travel_contact","contact_patient","contact_suspect","covid_syptoms","covid_19_symptoms","update_history");
				
			$field_data=array($post['travel_abroad'],$post['travel_contact'],$post['contact_patient'],$post['contact_suspect'],$post['covid_syptoms'],$post['covid_19_symptoms'],$update_history);
			
		$result=$this->dbConnection->update($field_names,$field_data,"id",$covid_id,"hcare_covid_19_status");
		
		if($result) return true;
		else return false;
	
	}
	function delete_med_days($post){
		
		$field_names1=array('wrong');
		$field_data=array('1');
		
		$result=$this->dbConnection->update($field_names1,$field_data,"id",$post['id'],"hcare_medicine_prescribed");
		
		if($result) return true;
		else return 0;
		
	}
	function update_billid_ip_labtest_prescribed($billid,$prescription_id){

		$field_name=array('hcare_bill_id');
		$field_data=array($billid);
	
	    $result=$this->dbConnection->update($field_name,$field_data,"id",$prescription_id,"hcare_ip_labtest_prescribed");
		
		if($result) return true;
		else return 0;   
			
	}



}


?>
