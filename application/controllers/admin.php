<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_chat_room');
		$this->load->model('m_chat');
		$this->load->library('encrypt');
		$this->load->model('m_user');
		$this->load->model('m_user_payroll');
		$this->load->model('m_user_info');
		$this->load->model('m_user_time_log');
		$this->load->helper('date');
	}

	public function home()
	{
		$data['conversations'] = $this->m_chat_room->getAll();
		
		$this->load->view('adminhome', $data);

	}

	public function setup()
	{
		$data['users'] = $this->m_user->getAllUser();
		$this->load->view('adminsetup', $data);
	}

	public function setupUserCreds($user_id)
	{
		$user_id = decode_url($user_id);
		$data['user'] = $this->m_user->getUser($user_id);
		$data['user_info'] = $this->m_user_info->get($user_id);

		if ($this->input->post()){

			$ins['user_id'] = $user_id;
			$ins['salary_rate'] = $this->input->post('salary');
			
			$work_start = $this->input->post('work_start');
			$start_timestamp = strtotime($work_start);
			$start_date = date("Y-m-d H:i:s", $start_timestamp);
			$ins['work_start'] = $start_date;

			$work_end = $this->input->post('work_end');
			$end_timestamp = strtotime($work_end);
			$end_date = date("Y-m-d H:i:s", $end_timestamp);
			$ins['work_end'] = $end_date;
			
			if ($data['user_info']) {
				$this->m_user_info->update($ins);
			}else{
				$this->m_user_info->insert($ins);
			}

			redirect(current_url());
		}

		$this->load->view('admin_user_setup', $data);
	}

	public function viewUserLog($user_id)
	{
		$this->load->library('session');
		$data['hashed_id'] = $user_id;
		$user_id = decode_url($user_id);
		$data['time_logs'] = $this->m_user->getUserTimeLogs($user_id);
		$data['user'] = $this->m_user->getUser($user_id);

		if ($this->input->post())
		{
			$updateArray = array();
			$id = $this->input->post('id');
			$morning_in_log = $this->input->post('morning_in_log');
			$morning_out_log = $this->input->post('morning_out_log');
			$noon_in_log = $this->input->post('noon_in_log');
			$noon_out_log = $this->input->post('noon_out_log');

			for($x = 0; $x < sizeof($id); $x++){
				if ($morning_in_log[$x] == '' || $morning_out_log[$x] == '' || $noon_in_log[$x] == '' || $noon_out_log[$x] == '') {
					$this->session->set_flashdata('errors', 'There are empty Value/s');

					redirect(current_url());
				}
				if ($morning_out_log[$x] < $morning_in_log[$x]) {
				   	$this->session->set_flashdata('errors', 'Morning Time out cannot be earlier than Morning Time in');

					redirect(current_url());
			    }elseif ($noon_in_log[$x] < $morning_out_log[$x]) {
			    	$this->session->set_flashdata('errors', 'Afternoon Time in cannot be earlier than Morning Time Out');

					redirect(current_url());
			    }elseif ($noon_out_log[$x] < $noon_in_log[$x]) {
			    	$this->session->set_flashdata('errors', 'Afternoon Time out cannot be earlier than Afternoon Time in');

					redirect(current_url());
			    }
			    

			    $updateArray[] = array(
			        'id'=>$id[$x],
			        'morning_in_log' => $morning_in_log[$x] == '' ? '0000-00-00 00:00:00' : date("Y-m-d H:i", strtotime($morning_in_log[$x])),
			        'morning_out_log' => $morning_out_log[$x] == '' ? '0000-00-00 00:00:00' : date("Y-m-d H:i", strtotime($morning_out_log[$x])),
			        'noon_in_log' => $noon_in_log[$x] == '' ? '0000-00-00 00:00:00' : date("Y-m-d H:i", strtotime($noon_in_log[$x])),
			        'noon_out_log' => $noon_out_log[$x] == '' ? '0000-00-00 00:00:00' : date("Y-m-d H:i", strtotime($noon_out_log[$x])),
			    );
			}  

			$this->m_user_time_log->update_user_logs($updateArray);

			$this->session->set_flashdata('messages', 'Saving Successfull');
			redirect(current_url());
		}

		$this->load->view('admin_user_time_log', $data);
	}

	public function recomputePayroll($user_id, $user_log_id)
	{
		$data['user_id'] = decode_url($user_id);
		$data['time_log_id'] = $user_log_id;
		$existLog = $this->m_user_payroll->get($user_log_id);
		$userRate = $existLog ? $existLog : $this->m_user_info->get(decode_url($user_id));
		$timelog = $this->m_user_time_log->get($user_log_id);
		$totalDailyHour = $this->m_user->getDailyHour($user_log_id);
		$day_break = $this->m_user->getDailyBreak($user_log_id);

		if ($day_break->hours < 1)
		{
			$hoursActive = $totalDailyHour != null && $day_break ? $totalDailyHour->hours - 1 : 0;
			$breakHours = $totalDailyHour != null && $day_break ? 1 : 0;
		}else{
			$hoursActive = $totalDailyHour != null && $day_break ? $totalDailyHour->hours - $day_break->hours : 0;
			$breakHours = $totalDailyHour != null && $day_break ? $day_break->hours : 0;
		}

		$data['salary_rate'] = $userRate ? $userRate->salary_rate : false;

		$datestring = '%Y';
		$time = time();
		$year = mdate($datestring, $time);
		$datestring = '%m';
		$time = time();
		$month = mdate($datestring, $time);

		$totalWorkingDays = getMonthTotalWorkingDays($year, $month, array(0, 6));
		$userDaily = $userRate ? $userRate->salary_rate/$totalWorkingDays : 0;
		$userHourly = $userDaily/8;
		$lateMin = 8-$hoursActive < 0 ? 0 : 8-$hoursActive;
		$otMin = 8-$hoursActive < 0 ? abs(8-$hoursActive): 0;

		$lateRate = $lateMin * $userHourly;
		$data['late'] = $lateRate > $userDaily ? 0 : $lateRate;
		$data['overtime'] = $otMin * $userHourly;
		$fnight_diff = $this->getNightDifference(strtotime($timelog->morning_in_log), strtotime($timelog->morning_out_log));
		$snight_diff = $this->getNightDifference(strtotime($timelog->noon_in_log), strtotime($timelog->noon_out_log));
		$anight_diff = $this->getNightDifference(strtotime($timelog->morning_in_log), strtotime($timelog->noon_out_log));

		if ($fnight_diff + $snight_diff == $anight_diff) {
			$night_diff = $fnight_diff + $snight_diff;			
		}else{
			$night_diff = $anight_diff - $breakHours;
		}

		$data['night_diff'] = $night_diff == 0 ? 0: ($night_diff) * ($userHourly * .20);
		$salary = $userDaily - $data['late'] + $data['overtime'] + $data['night_diff'];
		$data['salary_receive'] = $lateRate < $userDaily ? $salary > 0 ? $salary : 0 : 0;

		$this->m_user_payroll->recompute($user_log_id, $data);

		$this->session->set_flashdata('messages', 'Recompute Successfull');
		redirect(site_url('admin/viewUserLog/'.$user_id));
	}

	public function getNightDifference($start_work,$end_work)
	{

	    $start_night = mktime('22','00','00',date('m',$start_work),date('d',$start_work),date('Y',$start_work));
	    $end_night   = mktime('06','00','00',date('m',$start_work),date('d',$start_work) + 1,date('Y',$start_work));

	    if($start_work >= $start_night && $start_work <= $end_night)
	    {
	        if($end_work >= $end_night)
	        {
	            return ($end_night - $start_work) / 3600;
	        }
	        else
	        {
	            return ($end_work - $start_work) / 3600;
	        }
	    }
	    elseif($end_work >= $start_night && $end_work <= $end_night)
	    {
	        if($start_work <= $start_night)
	        {
	            return ($end_work - $start_night) / 3600;
	        }
	        else
	        {
	            return ($end_work - $start_work) / 3600;
	        }
	    }
	    else
	    {
	        if($start_work < $start_night && $end_work > $end_night)
	        {
	            return ($end_night - $start_night) / 3600;
	        }
	        return 0;
	    }
	}

	public function viewConversation($conversation_id)
	{
		$conversation_id = decode_url($conversation_id);
		$data['conversation'] = $this->m_chat_room->getRoomWithConversation($conversation_id);
		
		$data['roomId'] = $conversation_id;
 		$data['getAllUserMessage'] = function($users)use($conversation_id){
 			return $this->m_chat->getAllRoomMessagesByUsers($conversation_id, $users);
 		};

 		$data['loggedInUserId'] = $this->session->userdata('user_id');

		$this->load->view('admin_show_conversation', $data);
	}
}
