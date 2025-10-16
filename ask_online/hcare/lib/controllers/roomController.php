<?php //session_start();



require_once ROOT_PATH . '/lib/model/room/room.php';
require_once ROOT_PATH . '/lib/model/room/roomCategory.php';

require_once ROOT_PATH . '/lib/model/DBFunctions.php';

require_once ROOT_PATH . '/lib/common/form.php';

class RoomController {

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
				
				case 'RoomCategory'	   :
				
											$room_cat_obj=new roomCategory();
											
											if(isset($postArr['action']) && ($postArr['action']=="CREATE_PAGE" || $postArr['action']=="EDIT_PAGE")){ 
											
													$form_creator ->formPath ='/templates/room/category_form.php';
											
													if($postArr['action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
													
													}else {								
													
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['categoryInfo']=$room_cat_obj->getRoomCategory('',$wheredata);
													
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
												}
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[$k]="id='".$postArr['id']."'";
													$k++;
												}
												$wheredata[$k]="status = 0";
											
												$form_creator ->popArr['category']	=$room_cat_obj->getRoomCategory('',$wheredata);
												$form_creator ->formPath ='/templates/room/category.php';
											}
											
													break;
					case 'Room'			:	
											$room_obj=new room();
											$room_cat_obj=new roomCategory();
											// echo 111111;exit;
											
											if(isset($postArr['page_action']) && ($postArr['page_action']=="CREATE_PAGE" || $postArr['page_action']=="EDIT_PAGE")){
											
													$form_creator ->formPath ='/templates/room/room_form.php';
											
													$form_creator ->popArr['categoryInfo']=$room_cat_obj->getRoomCategory();
													
													if($postArr['page_action']=="CREATE_PAGE"){
												
														$form_creator ->popArr['action']="ADD";
														
													
													}else {								
													
														$form_creator ->popArr['bedInfo']=$room_obj->getBedInfo();
													
														$form_creator ->popArr['action']="UPDATE";
													
														$id=$postArr['id'];
														$wheredata[0]="id=".$id;
														$form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails('',$wheredata);
													
													}
											
											}else{
											
												$wheredata=array();

												$form_creator ->popArr['categoryInfo']=$room_cat_obj->getRoomCategory();
													
													$message ="SEARCH RESULT FOR:";
													if(!empty($postArr['category'])){

														
													
														// $message .= " CATEGORY NAME  -  ".$postArr['category'] ." ";
														
														$wheredata[]="room_category ='".$postArr['category']."'";
														
													
													}
											
												if(!empty($postArr['roomno'])){
													
														$message .= " ROOM NO  -  ".$postArr['roomno'] ." ";
														
														$wheredata[]="room_number like '%".$postArr['roomno']."%'";
														
													
													}
												
												
												if(!empty($postArr['bed_capacity'])){
													
														$message .= " BED CAPACITY  -  ".$postArr['bed_capacity'] ." ";
														
														$wheredata[]="bed_capacity like '%".$postArr['bed_capacity']."%'";
														
													
													}
												
												
											
												if(!empty($postArr['id']) && $postArr['action'] == "UPDATE"){
												
														$wheredata[]="id='".$postArr['id']."'";
													
												}
                                                                                                $wheredata[]="status =0 ";
											// var_dump($wheredata);
												$form_creator ->popArr['roomInfo']	=$room_obj->getRoomDetails('',$wheredata);
												$form_creator ->formPath ='/templates/room/manage_rooms.php';
											}
											break;
                                               case 'RoomStatus'   :

                                                                     $room_obj=new room();
								     $room_cat_obj=new roomCategory();
                                                                     $ip_obj= new Inpatient();

                                                                     $reg_obj= new Registration();

                                                                     //get all rooms

                                                                     if(!empty($postArr['category'])){						
														
									$wheredata[]="room_category = '".$postArr['category']."'";
														
								     }
											
								 if(!empty($postArr['roomno'])){
														
									$wheredata[]="room_number like '%".$postArr['roomno']."%'";
								  }			
								if(!empty($postArr['bed_capacity'])){
													
														
									$wheredata[]="bed_capacity = '".$postArr['bed_capacity']."'";
								}
												
                                                                    $wheredata[]="status =0 ";
                                                                     $roomInfo=$room_obj->getRoomDetails('',$wheredata,'room_category','asc');

                                                                    $roomStatus=array();
                                                                    $k=0;

                                                                     if(!empty($roomInfo)){
                                                                       
                                                                       for($i=0;$i<count($roomInfo);$i++) {
                                                                          
                                                                         $roomid=$roomInfo[$i][0];

                                                                          //get bed info
                                                                          $wherebed[0]="room_id ='".$roomid."'";
                                                                          $bedInfo=$room_obj->getBedInfo('',$wherebed);

                                                                           for($j=0;$j<count($bedInfo);$j++) {

                                                                               $bedid=$bedInfo[$j][0];
                                                                               $bed_status=$bedInfo[$j][3];

                                                                               if($bed_status == "ADMITTED") {

                                                                                 $selectCondition[0]="b.`cancelled`=0";
                                                                                 $selectCondition[1]="b.`room_id`='".$roomid."'";
                                                                                 $selectCondition[2]="b.`bed_id`='".$bedid."'";
                                                                                 $selectCondition[3]="(b.`discharge_date`='0000-00-00' OR b.`discharge_date` is NULL)";                                                                         
									         $patients[$i][$j]=$ip_obj->getIPPatientInfo('',$selectCondition,'b.admission_date','asc');


									         if (empty($patients[$i][$j])) {

                                                                             $selectCondition[0]="b.`cancelled`=0";
                                                                                 $selectCondition[1]="b.`obs_room`='".$roomid."'";
                                                                                 $selectCondition[2]="b.`obs_bed`='".$bedid."'";
                                                                                 $selectCondition[3]="(b.`obs_end`='0000-00-00' OR b.`obs_end` is NULL)";

									         	$patients[$i][$j]=$reg_obj->getOPPatientInfo('',$selectCondition,'b.id','asc');

									         	$patients_op=$patients;

									         	
									         }
                                                            
                                                                               }else{
                                                                                    $patients=array();
                                                                               }

                                                                              $roomStatus[$k][0]=$roomInfo[$i][0];
                                                                              $roomStatus[$k][1]=$roomInfo[$i][5];
                                                                              $roomStatus[$k][2]=$roomInfo[$i][2];
                                                                              $roomStatus[$k][3]=$bedInfo[$j][0];
                                                                              $roomStatus[$k][4]=$bedInfo[$j][2];
                                                                          if(count($patients[$i][$j]) >0) {
                                                                            $roomStatus[$k][5]=$patients[$i][$j][0][13];
                                                                              $roomStatus[$k][6]=$patients[$i][$j][0][15];
                                                                              $roomStatus[$k][7]=$patients[$i][$j][0][1]." ".$patients[$i][$j][0][2]." ".$patients[$i][$j][0][3];
                                                                              $roomStatus[$k][8]=$patients[$i][$j][0][19];
                                                                              $roomStatus[$k][9]=$patients[$i][$j][0][20];
                                                                              $roomStatus[$k][10]=$patients[$i][$j][0][17]." ".$patients[$i][$j][0][18];

                                                                              if (!empty($patients_op[$i][$j])) {
                                                                              	$roomStatus[$k][10]=$patients_op[$i][$j][0][15]." ".$patients_op[$i][$j][0][16];
                                                                              	$roomStatus[$k][5]="";
                                                                              	$roomStatus[$k][6]=$patients_op[$i][$j][0][0];
                                                                              }

                                                                          }else{

                                                                              $roomStatus[$k][5]="";
                                                                              $roomStatus[$k][6]="";
                                                                              $roomStatus[$k][7]="";
                                                                              $roomStatus[$k][8]="";
                                                                              $roomStatus[$k][9]="";
                                                                              $roomStatus[$k][10]="";
                                                                         }
                                                                              $roomStatus[$k][11]=$bed_status;
                                                                               $k++;
                                                                           

                                                                           }//ends ed for loop

                                                                       }//ends for room loop
                                                                     }//ends if room

                                                                     $form_creator ->popArr['roomStatus']=$roomStatus;

                                                                     $form_creator ->popArr['categoryInfo']=$room_cat_obj->getRoomCategory();

								    $form_creator ->formPath ='/templates/room/room_status.php';
    
                                                                                        break;
                                        case 'Nursing_Stations':


                                                                  $room_obj=new room();
                                                                  $condition=array();
                                                                  $k=0;

                                                                 
                                                                  if(!empty($postArr['station_name'])){
                                                                  	$condition[$k]="station_name like '%".$postArr['station_name']."%'";
                                                                  	$k++;
                                                                  }
                                                                   $condition[$k] = "status=0";
		
			
		                                                  $stationInfo=$room_obj->getNursingStation($condition);
                                                                  $srooms=array();

                                                                  if(!empty($stationInfo)){

                                                                    for($i=0;$i<count($stationInfo);$i++) {

                                                                       $station_id=$stationInfo[$i][0];

                                                                        $wheredata[0]="station_id=".$station_id;
                                                                        $wheredata[1]="status =0 ";
                                                                        $roomInfo=$room_obj->getRoomDetails('',$wheredata);

                                                                        if(!empty($roomInfo)){

                                                                           for($j=0;$j<count($roomInfo);$j++) {

                                                                              $srooms[$i][$j][0]=$roomInfo[$j][2];
                                                                           }
                                                                        }

                                                                     }

                                                                 }
                                                                 $form_creator ->popArr['stationInfo']=$stationInfo;
                                                                 $form_creator ->popArr['roomInfo']=$srooms;

                                                                 $form_creator ->formPath ='/templates/room/nursing_stations.php';
    
                                                                                        break;
                                       case 'Create_Nursing_Station' : $room_obj=new room();
								       $room_cat_obj=new roomCategory();
                                                                       $db_function =new DBFunction(); 

                                                                       if($postArr['page_action']=="CREATE_PAGE"){
												
										$form_creator ->popArr['action']="ADD";
                                                                                $form_creator ->popArr['room_assigned_list']='';
                                                                                $form_creator ->popArr['station_name']='';
                                                                                $form_creator ->popArr['station_id']='';


                                                                                $wheredata[]="station_id=0 ";
														
													
									}else{


                                                                               $form_creator ->popArr['action']="UPDATE";


                                                                              $station_id=$postArr['id'];
									      $condn[0]="id=".$id;

                                                                              $form_creator ->popArr['station_name']=$db_function->getidToValue("station_name","id",$station_id,"hcare_nursing_stations"); 
                                                                              $form_creator ->popArr['station_id']=$station_id;

                                                                              $condn[0]="station_id=".$station_id;
                                                                              $condn[1]="status =0 ";
                                                                              $roomInfo=$room_obj->getRoomDetails('',$condn);

                                                                              $srooms=array();

                                                                        if(!empty($roomInfo)){

                                                                           for($j=0;$j<count($roomInfo);$j++) {

                                                                              $srooms[$j]=$roomInfo[$j][0];
                                                                           }
                                                                        } 
                                                                               $form_creator ->popArr['room_assigned_list']=$srooms;


                                                                              $wheredata[]="(station_id=0 or station_id=".$station_id.")";

                                                                        }

                                                                      $form_creator ->popArr['categoryInfo']=$room_cat_obj->getRoomCategory(); 

                                                                      if(!empty($postArr['category'])){						
														
									$wheredata[]="room_category = '".$postArr['category']."'";
														
								     }

                                                                     $wheredata[]="status =0 ";
                                                                     
                                                                     
                                                                     $form_creator ->popArr['roomInfo']=$room_obj->getRoomDetails('',$wheredata,'id','asc');
                                                                     

                                                                     $form_creator ->formPath ='/templates/room/create_nursing_station.php';
    
                                                                                        break;

					
										
						
									
			
			}
			
			$form_creator->display();
	
	}
	function manageRoomCategory($post){
	
			$room_cat_obj=new roomCategory();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$status=$room_cat_obj->addRoomCategory($post);
								
					}else{
					
						$status=$room_cat_obj->updateRoomCategory($post);
					}
			
			}else{
			
				$status=$room_cat_obj->deleteRoomCategory($post);
				/*$is_dep_in_use=$dep_obj->checkDepartment($post);
				if($is_dep_in_use){
					$status=$dep_obj->deleteDepartment($post);
				}else {
				
					$message ="Department Already in Use";
					$this->viewPage('Department',$post,'',$message);
					exit();
				}*/
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('RoomCategory',$post,'',$message);
	
	
	}
	function manageRooms($post){
	
			$room_obj=new Room();
			
			$action=$post['action'];
			
			if($action =="ADD" || $action == "UPDATE"){
			
					if($action =="ADD"){
								
						$room_id=$room_obj->addRoom($post);
						$post['id']=$room_id;
						$room_obj->addBeds($post);
								
					}else{
					

						$condition[] = "room_id=".$post['id'];
						$status=array();	
						$bedInfo=$room_obj->getBedInfo('',$condition);

						if (!empty($bedInfo)) {
							

							for ($i=0; $i <count($bedInfo) ; $i++) { 
								
								if ($bedInfo[$i][3]=="FREE") {
									$status[$i] = 0;
								}
								else{
									$status[$i] = 1;
								}

							}


						}

						if (!in_array(1, $status)) {

							$status=$room_obj->updateRoom($post);
							
							$room_obj->deleteBeds($post);
							$room_obj->addBeds($post);


						}
						else{
							$status="";
						}


					}
			
			}else{
			
				
				$status=$room_obj->deleteRoom($post);
				/*$is_dep_in_use=$dep_obj->checkDepartment($post);
				if($is_dep_in_use){
					$status=$dep_obj->deleteDepartment($post);
				}else {
				
					$message ="Department Already in Use";
					$this->viewPage('Department',$post,'',$message);
					exit();
				}*/
			
			}
			
			
			if($status){
				$message=strtolower($action)."Success";
				$message=$this->$message; 
			}else{
				$message=strtolower($action)."failed";
				$message=$this->$message;
			}
			$this->viewPage('Room',$post,'',$message);
	
	
	}
       public function check_room_status($post){
	
		//create instance
		
		$room_obj= new Room();	
	
		//get room id
		$room_id=$post['id'];
		
		
		$condition[] = "room_id=".$room_id;
		
		$status=0;	
		$bedInfo=$room_obj->getBedInfo('',$condition);
			
			
			for($i=0;$i<count($bedInfo);$i++){
			
				if($bedInfo[$i][3] == "ADMITTED"){
                                   $status=1;
                                }
			}
			
	
		
		$data['room_status']=$status;
		
		 echo json_encode($data);
	}
	
        function deleteRoom($post){
	
		$room_obj= new Room();
		
		$status=$room_obj->deleteRoom($post);
		$this->viewPage("Room",$post);
	}
        function processStation($post) {

         $action = $post['page_action'];

           switch ($action) {


                case 'ADD' :

                             $room_obj= new Room();
                             // $status=$room_obj->addNursingStation($post);
                             // $station_id=$this->dbConnection->mysqli_connect->insert_id;

                            $station_id=$room_obj->addNursingStation($post);

                            $roomInfo=$post['rooms'];
                            

                            if(!empty($roomInfo)) {

                                for($i=0;$i<count($roomInfo);$i++) {

                                   $room_obj->addStationRoom($roomInfo[$i],$station_id);
                                }
                           }
                                break;
                case 'UPDATE':

                                  $room_obj= new Room();
                                  $station_id=$post['id'];
                                  $station_name=$post['station_name'];

                                  $status=$room_obj->updateStationName($station_id,$station_name);

                                  $room_obj->deleteStationRoom($station_id);

                                  $roomInfo=$post['rooms'];

                                 if(!empty($roomInfo)) {

                                     for($i=0;$i<count($roomInfo);$i++) {

                                        $room_obj->addStationRoom($roomInfo[$i],$station_id);
                                      }
                                }
                             

                               break;
               case 'DELETE'  :

                                $room_obj= new Room();
                                $station_id=$post['id'];

                                $room_obj->deleteStationRoom($station_id);

                                $room_obj->deleteStation($station_id);

                                break;
           }

           $this->viewPage("Nursing_Stations",$post);

        }

        function check_station_name($get){

                $room_obj= new Room();	
	
		
		$station_name=$get['sname'];
                $station_id=$get['sid'];
		
		
		$condition[] = "station_name='".$station_name."'";
                $condition[] = "status=0";

                if(!empty($station_id)) $condition[] = "id!='".$station_id."'";
		
			
		$stationInfo=$room_obj->getNursingStation($condition);

               if(empty($stationInfo)) $count=0;
               else $count=count($stationInfo);

                $data['station_count']=$count;
		
		 echo json_encode($data);


       }

  public function check_category_status($post){ 
	
		//create instance
		
		$room_obj= new Room();	
	
		//get category id
		$category_id=$post['id'];
		
		
		$condition[] = "room_category=".$category_id;
		$condition[] = "status=0";
		
		// $status=0;	
		$roomInfo=$room_obj->getRoomDetails('',$condition);
			
			
			 if(empty($roomInfo)) $status=0;
               else $status=1;

              
		
		$data['room_status']=$status;

		// echo 111;exit;
		
		 echo json_encode($data);
	}
	
	
	
	
	
}


?>
