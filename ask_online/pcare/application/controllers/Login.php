<?php
class Login extends CI_Controller 
{
	
  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }


	function index(){ 
	
		
		  if($this->user->is_logged_in()){
		  
		  		
		     	 redirect('dashboard');
		 }else{
		 	
				$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
			
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('login');
				}
				else
				{
				 redirect('dashboard');
				}
			
			}
		}	
		function username_check($username)
			{ 	
				$password = $this->input->post("password");	
		
				if(!$this->user->login($username,$password))
				{
					$this->form_validation->set_message('username_check', $this->lang->line('login_invalid_username_and_password'));
					return false;
				}
					return true;	
			}
		
		function user_authentication(){
		
			 $username = $this->input->post("username");
			$password = $this->input->post("password");	
			
			$criteria[]="user_name = '".$username."'";
			$criteria[]="password = '".md5($password)."'";
			
			$userInfo=$this->user->getUsers($criteria);
			
			if(empty($userInfo)){
				
				$data['authentication']="failed";
			}else{
			
				$data['authentication']="success";
				$data['user_id']=$userInfo[0][0];
				
			}
			
			echo json_encode($data);
		}
	
public function logout(){
	
		$this->session->sess_destroy();
		$this->load->view('login');
	}}
?>