<?php
class Common_model extends CI_Model {
		
		function authenticateUser($email, $pwd) {
				$r['status']=-1;
				$q=$this->db->select('*')->from('users')->where('email',$email)->where('password',$pwd)->get();
				
				if($r['user']=$q->row()) {$r['status']=1;};
				return $r;
			
			}
		
		function getTodaysActivities() {
			$user=$this->session->userdata('id');
			$today=mdate('%Y-%m-%d', time()).' 00:00:00';
			$q=$this->db->select('*')->from('activities')->where('user_id',$user)->where('activity_date >=',$today)->order_by('activity_date','desc')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
				$r1->comments=$q->num_rows();
				}
			return $r;
			}
			function getTodaysActivities1($user) {
			//$user=$this->session->userdata('id');
			$today=mdate('%Y-%m-%d', time()).' 00:00:00';
			$q=$this->db->select('*')->from('activities')->where('user_id',$user)->where('activity_date >=',$today)->order_by('activity_date','desc')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
				$r1->comments=$q->num_rows();
				}
			return $r;
			}
		
		function addActivity($text) {
			$data['user_id']=$this->session->userdata('id');
			$data['activity_text']=$text;
			$data['activity_date']=mdate('%Y-%m-%d %H:%i:%s', time());
			$data['location']='';
			$this->db->insert('activities',$data);
			return 1;
			}
		
		function getActivityDetails($id) {
			$r=-1;
			$q=$this->db->select('*')->from('activities')->where('id',$id)->get();
			if($r=$q->row()) {
				$q=$this->db->select('a.*, b.firstname, b.lastname')->from('comments as a')->join('users as b','a.user_id=b.id')->where('a.activity_id',$r->id)->order_by('a.id','desc')->get();
				$r->comments=$q->result();
				}
			return $r;
			
			}
			
		
		function addComment($data) {
			$this->db->insert('comments',$data);
			}
			function editProfile($data,$id)
			{
				//var_dump($data);	
				$this->db->where('id', $id)->update('users', $data);

			}
	function getDateActivities($today,$tomorrow,$id1) {
			//$user=$this->session->userdata('id');
			//$date=mdate('%Y-%m-%d', $date).' 00:00:00';
			$q=$this->db->select('*')->from('activities')->where('user_id',$id1)->where('activity_date >=', $today)->where('activity_date <=',$tomorrow)->order_by('id','desc')->get();
			//return $q;
			$r=$q->result();
			//var_dump( $this->db );
			//$r['use']=$id1;
			//$this->db->last_query();die();
			//var_dump($q);die;
			
			foreach($r as $r1) {
				$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
				$r1->comments=$q->num_rows();
				}
			return $r;

			}
			function alluser()
			{
				$q=$this->db->select('*')->from('users')->get();
				$r=$q->result();
				return $r;
			}
			function adduser($data)
			{
				var_dump($data);	
				$this->db->where('id', $id)->insert('users', $data);
				return 1;

			}
			function allactivities($data)
			{
				$q=$this->db->select('*')->from('activities')->where('user_id',$data)->order_by('activity_date','desc')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
				$r1->comments=$q->num_rows();
				}
				
					//$u=$this->db->select('*')->from('users')->where('id',$data)->get();
					//$r['user']=$u->result();
				//$r['user']=$name;
				

			return $r;
			}
			function approve($id,$data,$id1)
			{
				$this->db->where('id', $id)->update('activities', $data);	
				$q=$this->db->select('*')->from('activities')->where('id',$id)->order_by('activity_date','desc')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
				$r1->comments=$q->num_rows();
				}
				//$r['user']=$name;
			return $r;
						}
						function disable($id,$data)
						{
							$this->db->where('id',$id)->update('users',$data);
							$q=$this->db->select('*')->from('users')->get();
				$r=$q->result();
				return $r;
						}
						function username($id)
						{
							$q=$this->db->select('*')->from('users')->where('id',$id)->get();
						$r=$q->result();			
						return $r;
						}
			function activityfeed()
			{
				$q=$this->db->select('*')->from('activities')->order_by('activity_date','desc')->limit(30,0)->get();
				$r=$q->result();
				foreach($r as $r1) 
				{
					$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
					$r1->comments=$q->num_rows();
					$qq=$this->db->select('*')->from('users')->where('id',$r1->user_id)->get();
					$user=$qq->result();
					foreach($user as $use)
					{
					$r1->firstname=$use->firstname;
					$r1->lastname=$use->lastname;
					$r1->is_admin=$use->is_admin;
					}
				}
				return $r;
			}
			function newfeed($id)
			{
				$q=$this->db->select('*')->from('activities')->where('id >',$id)->order_by('activity_date','asc')->get();
				$r=$q->result();
				foreach($r as $r1) 
						{
						$q=$this->db->select('id')->from('comments')->where('activity_id',$r1->id)->get();
						$r1->comments=$q->num_rows();
						$qq=$this->db->select('*')->from('users')->where('id',$r1->user_id)->get();
						$user=$qq->result();
						foreach($user as $use)
						{
							$r1->firstname=$use->firstname;
							$r1->lastname=$use->lastname;
						}
						$r1->activity_date=date('h:i a', strtotime($r1->activity_date));
				}
				return $r;
			}	
			function notification($data){
				$q=$this->db->select('*')->from('users')->where('id',$data['user_id'])->get();
				$r=$q->result();
				$qq=$this->db->select('*')->from('activities')->where('id',$data['activity_id'])->get();
				$rr=$qq->result();
				foreach($r as $r1)
				{
					$newdata=array(
						'from_id'=>$r1->id,

						);
				}
				foreach($rr as $rr1)
				{
					$newdata['ac_id']=$rr1->id;
					$newdata['for_id']=$rr1->user_id;
					$newdata['text']="Commented on:".$rr1->activity_text;
					$newdata['is_read']=0;
				}

				$this->db->insert('notification',$newdata);
			}
			
			function addnotificationcomment($data)
			{
				$q=$this->db->select('*')->from('comments')->where('activity_id',$data['activity_id'])->get();
				$num=$q->num_rows();
				$q=$this->db->select('*')->from('users')->where('id',$data['user_id'])->get();
				$r=$q->row();
				$qq=$this->db->select('*')->from('activities')->where('id',$data['activity_id'])->get();
				$rr=$qq->row();
				
				$newdata=array('from_id'=>$r->id); //commentors id
				$firstname=$r->firstname;
				
				$firstname="<span class='notify'>".$firstname."</span>";
				
				
				$name=$this->db->select('*')->from('users')->where('id',$rr->user_id)->get(); //activity user
				$user=$name->row();
					
				
				if($num==0)
				{
					if($newdata['from_id']!=$user->id) {
						$atext=substr($rr->activity_text,0,20).'...';
						$atext="<span class='actext'>".$atext."</span>";
						$newdata['ac_id']=$rr->id;
						$forid=$rr->user_id;
						$newdata['for_id']=$forid;
						$newdata['text']=$firstname." commented on <b>your</b> activity: ".$atext;
						$newdata['is_read']=0;	
						$this->db->insert('notification',$newdata);
					}
				}

				else
				{
					
				
				$u=$this->db->distinct()->select('user_id')->from('comments')->where('activity_id',$data['activity_id'])->get();
				$uid=$u->result();
				
				foreach($uid as $id){
					
					if(($id->user_id!=$_SESSION['id']))
					{	
						$newdata['for_id']=$id->user_id;
						$atext=substr($rr->activity_text,0,20).'...';
						$atext="<span class='actext'>".$atext."</span>";
						$newdata['ac_id']=$rr->id;
						if($user->id==$newdata['for_id']) {
							$name='your';
							}
						else
							{
							$name=$user->firstname."'s";	
							}
						$newdata['text']=$firstname." commented on <b>".$name."</b> activity: ".$atext;
						$newdata['is_read']=0;	
						$this->db->insert('notification',$newdata);
					}
								
							
				
				}
			}

				}
			
			function getnotify()
			{
				$id=$_SESSION['id'];
				$q=$this->db->select('*')->from('notification')->where('for_id',$id)->where('is_read',0)->get();
				$r=$q->result();
				return $r;
			}
			function readnotify()
			{
				$id=$_SESSION['id'];
				$q=$this->db->select('*')->from('notification')->where('for_id',$id)->order_by('id','desc')->limit(30,0)->get();
				$r=$q->result();
				return $r;
			}
			function setasread()
			{
				$id=$_SESSION['id'];
				$data['is_read']=1;
				$this->db->where('for_id', $id)->update('notification', $data);
			}
			function addsome($is_app,$aid,$uid)
			{
				$qq=$this->db->select('*')->from('activities')->where('id',$aid)->get();
				$rr=$qq->result();
				foreach($rr as $rr1)
				{
					$temp=substr($rr1->activity_text,0,20).'...';
				}
				$qq=$this->db->select('*')->from('users')->where('id',$uid)->get();
				$r=$qq->result();

				foreach($r as $r1)
				{
					$tempn=$r1->firstname;
				}
				$t="your";
				if($is_app==1)
				{
					$data['text']="Admin <b class='success'>approved</b> your activity: <span class='actext'>".$temp."</span>";
				}
				else
				{
				
					$data['text']="Admin <b class='alert'>unapproved</b> your activity: <span class='actext'>".$temp."</span>";
				}
				$data['ac_id']=$aid;
				$data['from_id']=1;
				$data['for_id']=$uid;
				$data['is_read']=0;
				
				$this->db->insert('notification',$data);
			}
		function genreport()
		{

				$q=$this->db->select('*')->from('users')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$today=mdate('%Y-%m-%d', time()).' 00:00:00';
			$qq=$this->db->select('*')->from('activities')->where('user_id',$r1->id)->where('activity_date >=',$today)->order_by('activity_date','desc')->get();
			$r1->activity=$qq->result();
				}
				//$r['user']=$name;
			return $r;
		}
		function gendatereport($date)
		{
			$today=date('Y-d-m H:i:s', strtotime($date));
			$tomorrow=date('Y-d-m H:i:s', strtotime($date)+86400);
			$today=date('Y-m-d H:i:s', strtotime($date));
			$tomorrow=date('Y-m-d H:i:s', strtotime($date)+86400);
			$q=$this->db->select('*')->from('users')->get();
			$r=$q->result();
			foreach($r as $r1) {
				$qq=$this->db->select('*')->from('activities')->where('user_id',$r1->id)->where('activity_date >=', $today)->where('activity_date <=',$tomorrow)->order_by('id','desc')->get();
				$r1->activity=$qq->result();
				}
				//$r['user']=$name;
			return $r;
		}
		function userreport($startdate,$endate,$user)
		{
			$startdate=date('Y-d-m H:i:s', strtotime($startdate));
			$startdate=date('Y-m-d H:i:s', strtotime($startdate));
			$endate=date('Y-d-m H:i:s', strtotime($endate));
			$endate=date('Y-m-d H:i:s', strtotime($endate));
			echo $startdate;
			echo $endate;
			die;
			$q=$this->db->select('*')->from('activities')->where('user_id',$user)->where('activity_date >=', $startdate)->where('activity_date <=',$endate)->order_by('id','desc')->get();
			$r=$q->result();	
			$this->db->last_query();
			//var_dump($r);
			die;
			return $r;
		}
	}