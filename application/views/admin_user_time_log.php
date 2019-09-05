<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugin/datetimepicker') ?>/jquery.datetimepicker.css"/ >
    <script src="<?php echo base_url('assets/plugin/datetimepicker') ?>/jquery.js"></script>
    <script src="<?php echo base_url('assets/plugin/datetimepicker') ?>/build/jquery.datetimepicker.full.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

    <style type="text/css">
      .fit{
        width: 150px !important;
      }
    </style>
</head>
<body>
    <a href = "<?php echo site_url('admin/setup') ?>" class = "btn btn-default">View All user logins</a>

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

    <div class="row">
    <div class="col-md-12">
      <div style="padding-left: 25px;">
        <h2><?php echo $user->fullname ?></h2>
        <p>Time log</p>            
      </div>
      
      <form method = "post" action = "<?php echo site_url('admin/viewUserLog/'.encode_url($user->id)) ?>">
        <div style="float: right;padding-right: 25px;">
          <input type="submit" class = "btn btn-default btn-lg" name="Submit" value = "Save Changes">
        </div>
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr class="text-center">
                      <td colspan="2">Morning</td>
                      <td colspan="2">Afternoon</td>
                      <td colspan="6">Other info</td>
                  </tr>
                  <tr>
                      <th class="fit">Time In</th>
                      <th class="fit">Time out</th>
                      <th class="fit">Time In</th>
                      <th class="fit">Time out</th>
                      <th>Monthly Salary</th>
                      <th>Late(min)</th>
                      <th>OT(min)</th>
                      <th>Night Diff(min)</th>
                      <th>Receive</th>
                      <th>Re compute</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th>Time In</th>
                      <th>Time out</th>
                      <th>Time In</th>
                      <th>Time out</th>
                      <th>Monthly Salary</th>
                      <th>Late(min)</th>
                      <th>OT(min)</th>
                      <th>Night Diff(min)</th>
                      <th>Receive</th>
                      <th>Re compute</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php foreach ($time_logs as $key => $v):?>
                  <tr>
                    <td>
                      <?php
                        $originalMornDate = $v->morning_in_log;
                        $new_morn_log = date("Y-M-d H:i", strtotime($originalMornDate));

                        $originalMornOutLog = $v->morning_out_log;
                        $new_morn_out_log = date("Y-M-d H:i", strtotime($originalMornOutLog));

                        $originalNoonInLog = $v->noon_in_log;
                        $new_noon_in_log = date("Y-M-d H:i", strtotime($originalNoonInLog));

                        $originalNoonOutLog = $v->noon_out_log;
                        $new_noon_out_log = date("Y-M-d H:i", strtotime($originalNoonOutLog));

                      ?>
                      <input type="hidden" name="id[]" value = "<?php echo $v->id?>">
                      <input type="text" name = "morning_in_log[]" class="input_time form-control" id="morning_in_log" value = "<?php echo $new_morn_log ?>">

                    </td>
                    <td>
                      <input type="text" name = "morning_out_log[]" class="input_time form-control" id="morning_out_log" value = "<?php echo $v->morning_out_log == '0000-00-00 00:00:00' ? '' : $new_morn_out_log ?>">

                    </td>
                    <td>
                      <input type="text" name = "noon_in_log[]" class="input_time form-control" id="noon_in_log" value = "<?php echo $v->noon_in_log == '0000-00-00 00:00:00' ? '' : $new_noon_in_log ?>">
                    </td>
                    <td>
                      <input type="text" name = "noon_out_log[]" class="input_time form-control" id="noon_out_log" value = "<?php echo $v->noon_out_log == '0000-00-00 00:00:00' ? '' : $new_noon_out_log ?>">
                    </td>
                    <td>
                      <?php echo $v->salary_rate ? number_format($v->salary_rate, 2) : '' ?>
                    </td>
                    <td>
                      <?php echo $v->late ? '-'.number_format($v->late, 2) : '' ?>
                    </td>
                    <td>
                      <?php echo $v->overtime ? number_format($v->overtime, 2) : '' ?>
                    </td>
                    <td>
                      <?php echo $v->night_diff ? number_format($v->night_diff, 2) : '' ?>
                    </td>
                    <td>
                      <?php echo $v->salary_receive ? 'P '.number_format($v->salary_receive, 2) : '' ?>
                    </td>
                    <td>
                      <a href = "<?php echo site_url('admin/recomputePayroll/'.$hashed_id.'/'.$v->id) ?>" class = "btn btn-success"><span class = "glyphicon glyphicon-refresh"></span></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>

        </form>

    </div>
    </div>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
          "order": [[ 0, "desc" ]]
      } );
    } );

    jQuery('.input_time').datetimepicker({
        format:'Y-M-d H:i',
        defaultTime:'08:00'
    });

</script>