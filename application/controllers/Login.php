<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('login') == true){
			redirect('welcome/index');
		}

		if (isset($_GET['code'])) {
			
			$this->googleplus->getAuthenticate();
			$this->session->set_userdata('login',true);
			$this->session->set_userdata('user_profile',$this->googleplus->getUserInfo());
			var_dump($this->session->userdata('user_profile'));
			redirect('login/saveUser');
			
		} 
			
		$contents['login_url'] = $this->googleplus->loginURL();
		$this->load->view('login',$contents);
		
	}
	
	public function saveUser()
	{
		$info = $contents['user_profile'] = $this->session->userdata('user_profile');

		$data['email']= $info['email'];
		$data['fullname']= $info['name'];
		$data['firstname']= $info['given_name'];
		$data['lastname']= $info['family_name'];
		$data['google_id'] = $info['id'];
		$data['gender']= isset($info['gender']) ? $info['gender'] : '';
		$data['dob']= false;
		$data['profile_image']= $info['picture'];
		$data['gpluslink'] = false;

		$this->load->model('m_user');
		$ins = $this->m_user->insert($data);
		$this->session->set_userdata('user_id', $ins);
		redirect('welcome/index');
	}

	public function profile($check = false){
		$this->load->model('m_user');
		$this->load->model('m_user_info');
		$this->load->model('m_user_payroll');
		$this->load->helper('date');

		if($this->session->userdata('login') != true){
			redirect('');
		}
		
		$timeLogs = $this->m_user->getUserTimeLogs($this->session->userdata('user_id'));
		$totalMonthSalary = $this->m_user->getMonthlySalary($this->session->userdata('user_id'));

		$salaryRate = $this->m_user_info->get($this->session->userdata('user_id'));

		$timeLog = $this->m_user->getlastLogStatus($this->session->userdata('user_id'));

		$contents['getHours'] = function($id)
		{
			return $this->m_user->getDailyHour($id);
		};


		$contents['breakHour'] = function($timeLogId){
			$totalDailyHour = $this->m_user->getDailyHour($timeLogId);
			$day_break = $this->m_user->getDailyBreak($timeLogId);

			if ($day_break->hours < 0)
			{
				$hoursActive = $totalDailyHour != null && $day_break ? $totalDailyHour->hours - 1 : 0;
			}else{
				$hoursActive = $totalDailyHour != null && $day_break ? $totalDailyHour->hours - $day_break->hours : 0;
			}

			return $hoursActive;
		};

		$info = $contents['user_profile'] = $this->session->userdata('user_profile');

		$contents['salaryRate'] = $salaryRate;
		$contents['timeLog'] = $timeLog;
		$contents['check'] = $check;
		$contents['time_logs'] = $timeLogs;
		$contents['totalMonthSalary'] = $totalMonthSalary;

		$this->load->view('profile',$contents);

	}

	public function addTimeLog($check)
	{
		$this->load->model('m_user');
		$this->load->helper('date');

		$status = 'morningin';
		$stat = 'morning_in_log';
		$timeLog = $this->m_user->getlastLogStatus($this->session->userdata('user_id'));

		if ($timeLog) {
			
			$diff = timespan(strtotime($timeLog->morning_in_log), strtotime(date('Y-m-d H:i:s')));

			$time_diff = round(abs(strtotime(date('Y-m-d H:i:s')) - strtotime($timeLog->morning_in_log)) / 60 / 60,2);

			if ($time_diff >= 12) {
				$status = 'morningin';
				$stat = 'morning_in_log';
			}elseif ($timeLog->status == 'morningin') {
				$status = 'morningout';
				$stat = 'morning_out_log';
			}elseif ($timeLog->status == 'morningout') {
				$status = 'noonin';
				$stat = 'noon_in_log';
			}elseif ($timeLog->status == 'noonin') {
				$status = 'noonout';
				$stat = 'noon_out_log';
				$this->computePayroll($this->session->userdata('user_id'), $timeLog->id);
			}

		}
		if ($check) {
			if ($check == 'ootd') {
				$date = date('Y-m-d H:i:s');
				$data['created_at'] = $date;
				$data['noon_out_log'] = $date;
				$data['status'] = 'noonout';
				$data['user_id'] = $this->session->userdata('user_id');
				$this->m_user->updateTimeLog($data, $timeLog->id);
			}else{
				$date = date('Y-m-d H:i:s');
				$data['created_at'] = $date;
				$data[$stat] = $date;
				$data['status'] = $status;
				$data['user_id'] = $this->session->userdata('user_id');
				if ($status == 'morningin') {
					$ins = $this->m_user->addTimeLog($data);	
				}else{
					$ins = $this->m_user->updateTimeLog($data, $timeLog->id);
				}
			}
		}
		if ($data['status'] == 'noonout') {
			$this->session->set_flashdata('messages', 'Check Out Successfull.  See you next time');
		}else{
			$this->session->set_flashdata('messages', 'Check '.$check.' Successfull');
		}

		redirect('login/profile');
	}

	public function computePayroll($user_id, $user_log_id)
	{
		$this->load->model('m_user_info');
		$this->load->model('m_user_time_log');
		$this->load->model('m_user_payroll');
		$this->load->model('m_user');

		$data['user_id'] = $user_id;
		$data['time_log_id'] = $user_log_id;
		$existLog = $this->m_user_payroll->get($user_log_id);
		$userRate = $existLog ? $existLog : $this->m_user_info->get($user_id);
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
		// night diff %total hrs rate * .20
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

		return true;
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
	
	public function logout(){
		
		$this->session->sess_destroy();
		$this->googleplus->revokeToken();
		redirect('');
		
	}
	
}
