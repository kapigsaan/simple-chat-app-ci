<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CodeIgniter Simple Chat App</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
	<style type="text/css">
	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }
	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}
	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}
	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
	<h1>CodeIgniter Simple Chat App</h1>

	<div class="container">
      <br/>
      <?php if ($this->session->flashdata('errors')): ?>
        <div class = "alert alert-danger">
          <?php 
            echo $this->session->flashdata('errors'); 
           ?>
        </div>
      <?php endif ?>
      <?php if ($this->session->flashdata('messages')): ?>
        <div class = "alert alert-success">
          <?php 
            echo $this->session->flashdata('messages'); 
           ?>
        </div>
      <?php endif ?>
    </div>
    
	<div class = "container">
		<div class="col-md-4">
			<p>My Profile</p>
			<table>
				<tr>
					<td>ID</td>
					<td>:</td>
					<td><?php echo @$user_profile['id'];?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td>:</td>
					<td><?php echo @$user_profile['name'];?></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td>:</td>
					<td><?php echo @$user_profile['given_name'];?></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td>:</td>
					<td><?php echo @$user_profile['family_name'];?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>:</td>
					<td><?php echo @$user_profile['email'];?></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>:</td>
					<td><?php echo @$user_profile['gender'];?></td>
				</tr>
				<tr>
					<td>Photo</td>
					<td>:</td>
					<td><img src="<?php echo $user_profile['picture'];?>" width="200"></td>
				</tr>
			</table>
			
			<p><a href="<?php echo site_url('welcome');?>">Back to Home</a></p>
		</div>
		<input type="hidden" name="" id = "is-checkedin" value="<?php echo $check?>">
		<div class="col-md-8 text-right">
			<?php if ($timeLog): ?>
				<?php if ($timeLog->status == 'morningin' || $timeLog->status == 'noonin'): ?>
					<a href="<?php echo site_url('login/addTimeLog/out')?>" class = "btn btn-default btn-lg" id = "checkedout">Check Out</a>
				<?php elseif($timeLog->status == 'morningout' || $timeLog->status == 'noonout'): ?>
					<a href="<?php echo site_url('login/addTimeLog/in')?>" class = "btn btn-default btn-lg" id = "checkedin">Check in</a>
				<?php endif ?>
			<?php else: ?>
				<a href="<?php echo site_url('login/addTimeLog/in')?>" class = "btn btn-default btn-lg" id = "checkedin">Check in</a>
			<?php endif ?>
			<?php if ($timeLog && $timeLog->status != 'noonout'): ?>
				<a href="<?php echo site_url('login/addTimeLog/ootd')?>" class = "btn btn-default btn-lg" id = "checkedin">Out for the Day</a>
			<?php endif ?>
			<ul id = "log">
			</ul>

			<table id="example" class="table table-striped table-bordered " cellspacing="0" width="100%">
                <thead>
                	<tr class="text-center">
                		<td ></td>
                        <td colspan="2">1st Half (<?php echo date('h:i a',strtotime($salaryRate?$salaryRate->work_start:''))?>)</td>
                        <td colspan="2">2nd Half (<?php echo date('h:i a',strtotime($salaryRate?$salaryRate->work_end:''))?>)</td>
                        <td >Hours</td>
                        <td >Salary</td>
                    </tr>
                    <tr >
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time out</th>
                        <th>Time In</th>
                        <th>Time out</th>
                        <th>( 8 hours )</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="text-center">
                        <th></th>
                        <th>Time In</th>
                        <th>Time out</th>
                        <th>Time In</th>
                        <th>Time out</th>
                        <th>Hours</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                	<?php foreach ($time_logs as $key => $v):?>
                		<?php 
                			$hours = $getHours($v->id);

                		?>
                		<tr class = "text-left">
                			<td data-order="<?php echo $v->morning_in_log?>"><?php echo date('F d, Y',strtotime($v->morning_in_log)); ?></td>
                			<td><?php echo date('h:i a',strtotime($v->morning_in_log)); ?></td>
                			<td><?php echo $v->morning_out_log == '0000-00-00 00:00:00' ? '' : date('h:i a',strtotime($v->morning_out_log)); ?></td>
                			<td><?php echo $v->noon_in_log == '0000-00-00 00:00:00' ? '' : date('h:i a',strtotime($v->noon_in_log)) ?></td>
                			<td><?php echo $v->noon_out_log == '0000-00-00 00:00:00' ? '' : date('h:i a',strtotime($v->noon_out_log)); ?></td>
                			<td>
	                			<?php 
	                			if ($v->noon_out_log != '0000-00-00 00:00:00') {
	                				$brhour = $breakHour($v->id);
	                				if ($brhour > 0) {
	                					echo round($brhour, 2);
	                				}
	                				// echo(round($hours->hours,2));
	                			}

	                			?>
                			</td>
                			<td>
	                			<?php echo $v->salary_receive ? 'P '.number_format($v->salary_receive, 2) : '' ?>
                			</td>
	                    </tr>
                	<?php endforeach; ?>
                </tbody>
            </table>

		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class="col-md-12">
				<h1 class="text-center">Monthly Salary Report</h1>
				<table id="example2" class="table table-striped table-bordered " cellspacing="0" width="100%">
					<tr>
						<th>Year</th>
						<th>Month</th>
						<th>Total Late (PHP)</th>
						<th>Toal Overtime (PHP)</th>
						<th>Total Night Diff (PHP)</th>
						<th>Total Salary (PHP)</th>
					</tr>
					<?php foreach ($totalMonthSalary as $key => $v):?>
						<tr>
							<td><?php echo $v->y; ?></td>
							<?php 
								$dateObj   = DateTime::createFromFormat('!m', $v->m);
								$monthName = $dateObj->format('F')
							?>
							<td><?php echo $monthName; ?></td>
							<td>P <?php echo number_format($v->late, 2); ?></td>
							<td>P <?php echo number_format($v->overtime, 2); ?></td>
							<td>P <?php echo number_format($v->night_diff, 2); ?></td>
							<td>P <?php echo number_format($v->payment, 2); ?></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        $('#example').DataTable( {
        	"order": [[ 0, "desc" ]]
    	} );

    	$('#example2').DataTable( {
        	"order": [[ 0, "desc" ]]
    	} );
    } );


	$(document).ready(function(){
		var check = $('#is-checkedin').val();
		// if (check == 'in') {
		// 	$('#checkedout').hide();
		// }else{
		// 	$('#checkedin').hide();
		// }
		$('#checkedin').on('click', function(){
			$('#checkedin').hide();
			$('#checkedout').show();
		});
		$('#checkedout').on('click', function(){
			$('#checkedin').show();
			$('#checkedout').hide();
		});
	});

</script>

</body>
</html>
