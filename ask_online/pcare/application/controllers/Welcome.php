<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  function __construct()
     {
        // Call the Model constructor
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
     }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

        $this->load->library('pagination');
        $this->load->library('table');
        $this->load->model('demo_page');
            // $this->load->library('database');

        $result_per_page = 3;  // the number of result per page

        $config['base_url'] = base_url() . 'index.php/welcome/index/';
        $config['total_rows'] = $this->demo_page->count_items();
        $config['per_page'] = $result_per_page;
        $this->pagination->initialize($config);

        $datatable = $this->demo_page->get_items($result_per_page, $this->uri->segment(3)); 

        $data['datatable']=$datatable;
        $data['result_per_page']=$result_per_page;       

        $this->load->view('welcome_message',$data);
	}
	public function download_csv(){

		$name = $this->input->post('my_name');
		$age = $this->input->post('my_age');
		$no = $this->input->post('my_no');
		$array = array(
			array('Name', $name),
			array('Age', $age),
			array('No', $no)
			
		);
 
		$this->load->helper('csv');
		array_to_csv($array, 'test.csv');
	}

		public function dbexport() {
		$this->load->dbutil();
		$prefs = array(
		'format' => 'zip',
		'filename' => 'my_db_backup.sql'
		);
		$backup =& $this->dbutil->backup($prefs);
		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'public/uploads/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup);
		$this->load->helper('download');
		force_download($db_name, $backup);
		}
	    public function email(){

		// $this->load->library('email');

			$config['protocol']         = 'smtp';
			$config['smtp_host']        = 'ssl://smtp.mailgun.org';
			$config['smtp_port']        = 465;
			$config['smtp_user']        = 'postmaster@mg.doctorbooking.in';
			$config['smtp_pass']        = '9416bae871d72c69fa3d69341aaa6ef0';
			$config['smtp_crypto']      = '';
			$config['charset']          = 'utf-8';
			$config['mailtype']         = 'html';
			$config['email']['newline'] = "rn";

			$this->load->library('email',$config); 
			$this->email->from('suroor@uniziontechnologies.com', 'Sender Name');
			$this->email->to('vipint05@gmail.com','Recipient Name');
			$this->email->subject('Your Subject');
			$this->email->message('Your Message'); 
			if($this->email->send()) {
			    echo 'Message has been sent.';
			} else {
			    echo $this->email->print_debugger();
			}

		}
		public function file_upload(){

		         $config['upload_path']   = 'E:\wamp\www\code\upload'; 
		         $config['allowed_types'] = 'gif|jpg|png|docx|txt'; 
		         $config['max_size']      = 200; 
		         $config['max_width']     = 1024; 
		         $config['max_height']    = 768;  
		         $this->load->library('upload', $config);
					
		         if ( ! $this->upload->do_upload('my_file')) {
		            $error = array('error' => $this->upload->display_errors()); 
		            // $this->load->view('upload_form', $error); 
		            var_dump($error);
		         }
					
		         else { 
		            $data = array('upload_data' => $this->upload->data()); 
		            // $this->load->view('upload_success', $data); 
		            var_dump($data);
		         } 

		}
		public function pdf($html=null){

    	include (APPPATH."third_party/dompdf/autoload.inc.php");

    	 $html=$this->load->view('welcome_message', true);
     
    	$dompdf=new Dompdf \ Dompdf();
    	$dompdf->load_html("<h1>Testing Text</h1>");
    	$dompdf->render();
    	 $dompdf->stream('file'.'pdf');



		}
		public function validation(){

                $this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');

                if ($this->form_validation->run() == FALSE)
                {
                        var_dump("okkkkkkkkkkkk");
                }
                else
                {
                       var_dump("not okkkkkkkkkkkk");
                }	

		}
		// public function sms(){
		// 		$config = Array(
		// 		    'protocol' => 'smtp',
		// 		    'smtp_host' => 'ssl://smtp.googlemail.com',
		// 		    'smtp_port' => 465,
		// 		    'smtp_user' => 'xxx',
		// 		    'smtp_pass' => 'xxx',
		// 		    'mailtype'  => 'html', 
		// 		    'charset'   => 'iso-8859-1'
		// 		);
		// 		$this->load->library('email', $config);
		// 		$this->email->set_newline("\r\n");

		// 		// Set to, from, message, etc.

		// 		$result = $this->email->send();			
		// }
	

		








}
