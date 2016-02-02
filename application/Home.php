<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(isset($_SESSION['loggedin'])) {
				$activites=$this->common_model->getTodaysActivities();
				
				$data['activities']=$activites;
				$this->load->view('user/home',$data);
			}
		else
			{
			$this->load->view('common/login');	
			}
	}
	
	public function authenticate() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email');	
		$this->form_validation->set_rules('pass', 'Password', 'required|trim');
		$this->form_validation->set_message('xss_clean', 'Error Message');
		
		if($this->form_validation->run()) {
			$r=$this->common_model->authenticateUser($this->input->post('email'), $this->input->post('pass'));
			if($r['status']==-1) {$data['error']=1; $data['name']="123";$this->load->view('common/login',$data);}
			else {
				 $logindata = array(
					'loggedin' => 1,
					'id'=>$r['user']->id,
					'email'  => $r['user']->email,
					'firstname' => $r['user']->firstname,
					'lastname' => $r['user']->lastname,
					'is_admin'=>$r['user']->is_admin,
					'is_active'=>$r['user']->is_active,
					'pic'=>$r['user']->image
					);

				$this->session->set_userdata($logindata);
				if($_SESSION['is_active']==1){
				redirect('home/index');
			}
			else
			{	?>
		<script>alert("Contact the Administration");</script><?
				$this->load->view('common/login');
				}
			}
			}
		else {$this->load->view('common/login');}
	}
	
	public function logout() {
		session_destroy();
		redirect('home/index');
		}
	
	public function addActivity() {
		if(isset($_SESSION['loggedin'])) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('activity','Activity','required|trim|xss_clean');
		if($this->form_validation->run()) 
		{
			$text=$this->input->post('activity');
			$aid=$this->common_model->addActivity($text);
			 preg_match_all('/(?<!\w)@\w+/',$text,$matches);
			 $this->common_model->sendmessage($matches,$text,$aid);
    		//print_r($matches);
			
			redirect('home/index');
		}
		else 
		{
			$activites=$this->common_model->getTodaysActivities();
			$data['activities']=$activites;
			$this->load->view('user/home',$data);
		}
		}
		else
		{
			$this->load->view('common/login');	
			
		}
		}
	
	public function activityDetails() {
		if(isset($_SESSION['loggedin'])) {
		$id=$this->uri->segment(3);
		if(isset($id)) :
		$_SESSION['activity_id']=$id;
		$data['activity']=$this->common_model->getActivityDetails($id);
		$this->load->view('user/activity',$data);
		else : 
		redirect('home/index');
		endif;}
		else
		{
			$this->load-view('common/login');
		}
		}
	
	public function addComment() {
		if(isset($_SESSION['loggedin'])) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('comment','Comment', 'required|trim');
		if($this->form_validation->run()) {
			$data = array(
				'activity_id'=>$_SESSION['activity_id'],
				'user_id'=>$_SESSION['id'],
				'comment_text'=>$this->input->post('comment'),
				'comment_date'=> date('Y-m-d H:i:s')
				);
			$this->common_model->addnotificationcomment($data);
			$this->common_model->addComment($data);
			//$this->common_model->notification($data);
			
			redirect('home/activityDetails/'.$_SESSION['activity_id']);
		}

	
		else
			{
			$id=$_SESSION['activity_id'];
			$data['activity']=$this->common_model->getActivityDetails($id);
			$this->load->view('user/activity',$data);	
			}
		}
		else
		{
			$this->load->view('common/login');
			}
		}
		public function edit(){
			if(isset($_SESSION['loggedin'])) 
			{
		
			$this->load->view('user/profile');
		}
			else
			{
				$this->load->view('common/login');
			}
		}
		public function editProfile(){
			if(isset($_SESSION['loggedin'])) {
		$this->load->library('form_validation');
			$this->form_validation->set_rules('Fname', 'first name', 'required|trim');
		$this->form_validation->set_rules('Lname', 'last name', 'required|trim');
		//$this->form_validation->set_rules('Email', 'Email', 'required|trim|valid_email');	
		if($this->form_validation->run()) {
			$data = array(
				'firstname'=>$this->input->post('Fname'),
				'lastname'=>$this->input->post('Lname'),
				//'email'=>$this->input->post('Email'),
				'email'=>$_SESSION['email'],
				
				);
			$id=$_SESSION['id'];
				$this->common_model->editProfile($data,$id);
				//$r['user']=$this->common_model->username($id);
				 $logindata = array(
					'loggedin' => 1,
					'id'=>$id,
					'email'  => $data['email'],
					'firstname' => $data['firstname'],
					'lastname' => $data['lastname'],
					'is_admin'=>$_SESSION['is_admin'],
					'is_active'=>1,
					);

				$this->session->set_userdata($logindata);
				$this->load->view('user/profile',$data);
				//redirect('home/index');
			}
		}
		else{
			$this->load->view('common/login');
		}
		}
		public function password(){
			if(isset($_SESSION['loggedin'])) {
		
			$this->load->library('form_validation');
			
		$this->form_validation->set_rules('oldpass', 'Old Password', 'required|trim');
		$this->form_validation->set_rules('newpass', 'New Password', 'required|trim|matches[confpass]');
		$this->form_validation->set_rules('confpass', 'Confirm Password', 'required|trim');
		if($this->form_validation->run()) {
			$data = array(
				
				'password'=>$this->input->post('newpass'),
				);
			$id=$_SESSION['id'];
			$sql = $this->db->select('*')->from('users')->where('email',$this->session->userdata('email'))->where('password',$this->input->post('oldpass'))->get();
			
			echo $sql->num_rows();
			if($sql->num_rows()==1)
			{ 
				$this->common_model->editProfile($data,$id);
				//$data=array('message'=>'succesfully changed!);
				$this->load->view('user/profile',$data);
				redirect('home/index');
			}
			else
				{
					
					?>
				<script>alert("Wrong password");</script>
				<?
					$this->load->view('user/profile',$data);
				}
			
			}
			else
			{
				$this->load->view('user/profile');	
			}
		
		}
		else
		{
			$this->load->view('common/login');
		}
	}
		public function alluser()
		{
			if(isset($_SESSION['loggedin'])) {
		
			$data['users']=$this->common_model->alluser();

			$this->load->view('user/alluser',$data);
		}
		else
		{
			$this->load->view('common/login');
		}
		}
		public function getDateActivities(){
if(isset($_SESSION['loggedin'])) {
				
				$id1=$this->uri->segment(3);
				$id=$this->uri->segment(4);
				//echo date('d-m-Y',strtotime($id));die;
				//$id = date("Y-d-m", strtotime($id));
				$data['date']=$id;
				$today=date('Y-d-m H:i:s', strtotime($id));
				$tomorrow=date('Y-d-m H:i:s', strtotime($id)+86400);
				$today=date('Y-m-d H:i:s', strtotime($id));
				$tomorrow=date('Y-m-d H:i:s', strtotime($id)+86400);
//$today=mdate('%Y-%m-%d', time()).' 00:00:00';
				
//$id = date("Y-m-d", strtotime($id));
				//echo $today;
				//echo $tomorrow;//die;
				
		if(isset($id)) :
		
	//$activities=$this->common_model->getDateActivities($today,$tomorrow,$id1);
$data['activities']=$this->common_model->getDateActivities($today,$tomorrow,$id1);
//print_r($activities);
//$data['activities']=$activities;
//$user=$this->common_model->username($id1);
$data['user']=$this->common_model->username($id1);
$data['use']=$id1;
//$data=array('activities'=>$activities,'use'=>$id1,'user'=>$user);
	//echo $id;die;
	//echo $data['activity'];
		//print_r($use);
//var_dump($data);die();
	
		$this->load->view('user/home_date',$data);

		else : 
		//redirect('home/index');
			//$id;
		endif;
				
			}
		else
			{
			$this->load->view('common/login');	
			}
		}
		public function adduser()
		{	if(isset($_SESSION['loggedin'])) {
		
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Fname', 'first name', 'required|trim');
		$this->form_validation->set_rules('Lname', 'last name', 'required|trim');
		$this->form_validation->set_rules('Email', 'Email', 'required|trim|valid_email');	
		$this->form_validation->set_rules('newpass', 'New Password', 'required|trim|matches[confpass]');
		$this->form_validation->set_rules('confpass', 'Confirm Password', 'required|trim');
		if($this->form_validation->run()) {
			$data = array(
				'firstname'=>$this->input->post('Fname'),
				'lastname'=>$this->input->post('Lname'),
				'email'=>$this->input->post('Email'),
				'password'=>$this->input->post('newpass'),
				'is_active'=>1,
				);
			 
				$this->common_model->adduser($data);
				redirect('home/alluser');
			}
			else
				{
					$this->load->view('user/adduser');
				}
			//redirect('home/activityDetails/'.$_SESSION['activity_id']);

		   //redirect('home/adduser');
			}
			else{
				$this->load->view('common/login');
			}
		}
			public function allactivities()
			{
				//$name=$this->uri->segment(3);
				if(isset($_SESSION['loggedin'])) {
		$id=$this->uri->segment(3);
			$data['activities']=$this->common_model->getTodaysActivities1($id);
			$data['user']=$this->common_model->username($id);
			$data['date1']=$id;
			$data['use']=$id;
			$this->load->view('user/allactivities',$data);
			}
			else{
				$this->load->view('common/login');
			}
		}
			public function approve()
			{
				if(isset($_SESSION['loggedin'])) {
		

				$id=$this->uri->segment(3);
				$id1=$this->uri->segment(4);
				$data = array(
				
				'is_approved'=>1,
				);
				$_SESSION['activity_id']=$id;
				$data['activities']=$this->common_model->approve($id,$data,$id1);
				$data['user']=$this->common_model->username($id1);
				$data['use']=$id1;
				$this->common_model->addsome($data['is_approved'],$id,$id1);
				$data['activity']=$this->common_model->getActivityDetails($id);
				$this->load->view('user/activity',$data);
				
				//$this->load->view('user/activityDetails',$data);
			}
			else
			{
				$this->load->view('common/login');
			}
		}
			public function disable()
			{	if(isset($_SESSION['loggedin'])) {
		
				$id=$this->uri->segment(3);
				$data=array(
					'is_active'=>0,
				);
				$data['users']=$this->common_model->disable($id,$data);

				$this->load->view('user/alluser',$data);
			}
			else{
				$this->load->view('common/login');
			}
		}
			public function enable()
			{
				if(isset($_SESSION['loggedin'])) {
		$id=$this->uri->segment(3);
				$data=array(
					'is_active'=>1,
				);
				$data['users']=$this->common_model->disable($id,$data);

				$this->load->view('user/alluser',$data);
			}
			else
			{
				$this->load->view('common/login');
			}
		}
		public function unapprove()
			{
				if(isset($_SESSION['loggedin'])) {
				$id=$this->uri->segment(3);
				$id1=$this->uri->segment(4);
				$data = array(
				
				'is_approved'=>0,
				);
				$_SESSION['activity_id']=$id;
				$data['activities']=$this->common_model->approve($id,$data,$id1);
				$data['user']=$this->common_model->username($id1);
				$data['use']=$id1;
				$this->common_model->addsome($data['is_approved'],$id,$id1);
				$data['activity']=$this->common_model->getActivityDetails($id);
				$this->load->view('user/activity',$data);
				//$this->load->view('user/home_date',$data);
			}
			else{
				$this->load->view('common/login');
			}
		}
		public function activityfeed()
		{
			if(isset($_SESSION['loggedin'])) 
				{
				$id=$this->uri->segment(3);
				$data['activities']=$this->common_model->activityfeed();
				$this->load->view('user/activityfeed',$data);
				}
			else
				{
				$this->load->view('common/login');
				}
		}
		public function newfeed()
		{if(isset($_SESSION['loggedin'])) {
		
			$id=$this->uri->segment(3);
			$data['error']=false;
			$data['role']='user';
			if($_SESSION['is_admin']==1) {$data['role']='admin';}

			$data['activities']=$this->common_model->newfeed($id);
			  if($data['activities']){   
         		echo json_encode( $data);
        		// var_dump($data);die();
    		} 
    else {
         echo json_encode( array('error' => true) );
    }
		}
		else
		{
			$this->load->view('common/login');
		}
		}
		public function notification()
		{
			if(isset($_SESSION['loggedin'])) {
		
			$data['notification']=$this->common_model->readnotify();
			//$this->common_model->setasread();
			//var_dump($data);die();
			
			$this->load->view('user/notification',$data);
			
		}
		else
		{
			$this->load->view('common/login');
		}
	}
		public function get()
		{
			if(isset($_SESSION['loggedin'])) {
		
			$data['notification']=$this->common_model->getnotify();
			$this->common_model->setasread();
			$data['notified']=true;
			if($data['notification'])
			{
				echo json_encode($data);
			}
			else
			{
				echo json_encode(array('error'=>true));
			}
		}
		else{
			$this->load->view('common/view');
		}
	}
		public function getme()
		{
			if(isset($_SESSION['loggedin'])) {
		
			$data['notification']=$this->common_model->getnotify();
			$this->common_model->setasread();
			if($data['notification'])
			{
				echo json_encode($data);
			}
			else
			{
				echo json_encode(array('error'=>true));
			}
		}
		else{
			$this->load->view('common/login');
		}
	}
	public function report1()
	{	$data['temp_u']=$this->common_model->alluser();
	
	foreach($data['temp_u'] as $temp)
	{
		$temp->activities=$this->common_model->getTodaysActivities1($temp->id);
		$this->load->view('user/report',$data);
	}
	//var_dump($data);
	//die();
}
function getActivitiesForReport($date) {
$data='';
if($date!=-1)
	{	
		$data['temp_u']=$this->common_model->gendatereport($date);
	}
	else
	{
		$data['temp_u']=$this->common_model->genreport();
		
	}
	return $data;
}
public function report()
	{	
		$Rdate=0;
		$Rdate=$this->uri->segment(3);
		$data='';
		if($Rdate==0) {
			$data=$this->getActivitiesForReport(-1);
		}
		else
				{

					$data=$this->getActivitiesForReport($Rdate);
				}
				$data['date']=$Rdate;
		$this->load->view('user/report',$data);
	//$data[]
}
public function printit()
{
		$Rdate=0;
		$Rdate=$this->uri->segment(3);
		$data='';
		
		if($Rdate==0) {
			$data=$this->getActivitiesForReport(-1);
		}
		else
		{
			$data=$this->getActivitiesForReport($Rdate);
		}
		$data['date']=$Rdate;
		$this->load->view('user/printit',$data);
}

public function emailer(){
			$Rdate=0;
			$Rdate=$this->uri->segment(3);
			$data='';
			if($Rdate==0) {
				$data=$this->getActivitiesForReport(-1);
			}
			else
			{
				$data=$this->getActivitiesForReport($Rdate);
			}
			
			$data['date']=$Rdate;
			$config['mailtype']='html';
			$this->load->library('email');
			$this->email->initialize($config);
			$q=$this->db->select('*')->from('users')->where('is_admin',1)->get();
			$r=$q->result();
			foreach($r as $r1)
					{
						$tempE=$r1->email;
						$this->email->from('noreply@designkarkhana.work', 'Daily Log Application');
						$this->email->to($tempE); 
						$message="<html><body style='padding:30px;'><div style='padding-left:15px; padding-right:15px; padding-bottom:15px; padding-top:15px; border:#dedede thin solid; max-width:600px; margin-left:auto; margin-right:auto; margin-top:0px; margin-bottom:0px;'><h1 style='padding:0px; margin:0px;'>Activity Report - ".$Rdate."</h1><ul style='padding:0px; margin:0px;'>";
						
						if(count($data['temp_u'])==0) :
						
							$message+="<li class='no-activity nolist'>No Users!</li>";
						
						else :
							//print_r($users);
								foreach($data['temp_u'] as $use) {
									
									$message.="<li class='nolist' style='list-style:none; margin-top:15px'>";
									$message.="<div style='font-size:16px; font-weight:bold'>";
									$message.=ucwords($use->firstname)." " .ucwords($use->lastname);
									$message.="</div>";
								
								
									if(count($use->activity)==0)
										{
										$message.="<ul style='margin-bottom:15px;'>";
										$message.= "<li style='font-weight:bold;'>No activity !</li></ul>";
										}
									else
										{
											$message.="<ul style='margin-bottom:15px;'>";
										foreach($use->activity as $act)
											{
											$message.= "<li";
											if($act->is_approved==1) {$message.= " style='color:#009900' ";}
											else {$message.=" style='color:#cc0000' ";}
											$message.=">";
											$message.=($act->activity_text);
											$message.= "</li>";
											}
											$message.= "</ul>";
										}
									$message.='</li>';
								}
						endif;
						$this->email->subject('Activity Report - '.$Rdate);
						$message.='</div></ul></body></html>';
						$this->email->message($message);	
						
						$this->email->send();
					}
			echo $this->email->print_debugger();
			$this->load->view('user/report',$data);
			
			}
public function reminder()
{
	$config['mailtype']='html';
	$this->load->library('email');
	$this->email->initialize($config);
	$q=$this->db->select('*')->from('users')->get();
	$user=$q->result();
	foreach($user as $use)
		{
			$temp=$use->email;
			$this->email->from('noreply@designkarkhana.work', 'Daily Log Application');
			$this->email->to($temp);
			$message="<html><body>";
			$message.="<p>Hello User,</p>"			
			$message.="<p>This is a reminder to log your daily activities.</p><p>Thank you</p>";
			$messgae.="</body></html>";
			$this->email->subject('Daily Reminder to log Activity');
			$this->email->message($message);
			$this->email->send();
		}
			echo $this->email->print_debugger();
			$this->load->view('user/report',$data);

		}
		public function userreport()
		{
			$startdate=$this->uri->segment(3);
			$endate=$this->uri->segment(4);
			$use=$this->uri->segment(5);
			$data['temp_u']=$this->common_model->alluser();
			$data['activity']=$this->common_model->userreport($startdate,$endate,$use);
			$data['user']=$this->common_model->username($use);
			$startdate=date('Y-m-d H:i:s', strtotime($startdate));
			//$endate=date('Y-d-m H:i:s', strtotime($endate));
			$endate=date('Y-m-d H:i:s', strtotime($endate));
			$data['startdate']=$startdate;
			$data['endate']=$endate;
			$this->load->view('user/userreport',$data);
		}
		public function emailUserReport(){
			
			$startdate=$this->uri->segment(3);
			$endate=$this->uri->segment(4);
			$use=$this->uri->segment(5);
			$data['temp_u']=$this->common_model->alluser();
			$data['activity']=$this->common_model->userreport($startdate,$endate,$use);
			$data['user']=$this->common_model->username($use);
			$startdate=date('Y-m-d H:i:s', strtotime($startdate));
			$endate=date('Y-m-d H:i:s', strtotime($endate));
			$data['startdate']=$startdate;
			$data['endate']=$endate;
			$config['mailtype']='html';
			$this->load->library('email');
			$this->email->initialize($config);
			$q=$this->db->select('*')->from('users')->where('is_admin',1)->get();
			$r=$q->result();
			foreach($r as $r1)
					{
						$tempE=$r1->email;
						$this->email->from('noreply@designkarkhana.work', 'Daily Log Application');
						$this->email->to($tempE); 
						$message="<html><body style='padding:30px;'><div style='padding-left:15px; padding-right:15px; padding-bottom:15px; padding-top:15px; border:#dedede thin solid; max-width:600px; margin-left:auto; margin-right:auto; margin-top:0px; margin-bottom:0px;'><h1 style='padding:0px; margin:0px;'>Activity Report of- ".$startdate."</h1><ul style='padding:0px; margin:0px;'>";
						
						if(count($data['temp_u'])==0) :
						
							$message+="<li class='no-activity nolist'>No Users!</li>";
						
						else :
							//print_r($users);
								foreach($data['user'] as $use) {
									
									$message.="<li class='nolist' style='list-style:none; margin-top:15px'>";
									$message.="<div style='font-size:16px; font-weight:bold'>";
									$message.=ucwords($use->firstname)." " .ucwords($use->lastname);
									$message.="</div>";
								
								
									if(count($data['activity'])==0)
										{
										$message.="<ul style='margin-bottom:15px;'>";
										$message.= "<li style='font-weight:bold;'>No activity !</li></ul>";
										}
									else
										{
											$message.="<ul style='margin-bottom:15px;'>";
										foreach($data['activity'] as $act)
											{
											$message.= "<li";
											if($act->is_approved==1) {$message.= " style='color:#009900' ";}
											else {$message.=" style='color:#cc0000' ";}
											$message.=">";
											$message.=($act->activity_text);
											$message.= "</li>";
											}
											$message.= "</ul>";
										}
									$message.='</li>';
								}
						endif;
						$this->email->subject('Activity Report - '.$startdate.' to' .$endate);
						$message.='</div></ul></body></html>';
						$this->email->message($message);	
						
						$this->email->send();
					}
			echo $this->email->print_debugger();
			$this->load->view('user/userreport',$data);
			
			}
			public function printUser()
			{
			$startdate=$this->uri->segment(3);
			$endate=$this->uri->segment(4);
			$use=$this->uri->segment(5);
			$data['temp_u']=$this->common_model->alluser();
			$data['activity']=$this->common_model->userreport($startdate,$endate,$use);
			$data['user']=$this->common_model->username($use);
			$startdate=date('Y-m-d H:i:s', strtotime($startdate));
			//$endate=date('Y-d-m H:i:s', strtotime($endate));
			$endate=date('Y-m-d H:i:s', strtotime($endate));
			$data['startdate']=$startdate;
			$data['endate']=$endate;
			$this->load->view('user/printUser',$data);
			}


}

