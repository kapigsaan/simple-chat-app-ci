<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <a href = "<?php echo site_url('admin/setup') ?>" class = "btn btn-default">Go back</a>
    <div class="container">
      <h2><?php echo $user->fullname ?></h2>

      <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-6">
        <form action ="<?php echo site_url('admin/setupUserCreds/'.encode_url($user->id)) ?>" method = "POST">
            <div class="form-group">
              <label for="salary">Rate(monthly): </label>
              <input type="number" name = "salary" class="form-control" id="salary" value = "<?php echo $user_info ? $user_info->salary_rate : ''?>">

            </div>
            <div class="form-group">
              <label for="work_start">Work start</label>
              <?php
                $hour = array(
                  "08:00" => "08:00 AM",
                  "09:00" => "09:00 AM",
                  "10:00" => "10:00 AM",
                  "11:00" => "11:00 AM",
                  "12:00" => "12:00 PM",
                  "13:00" => "01:00 PM",
                  "14:00" => "02:00 PM",
                  "15:00" => "03:00 PM",
                  "16:00" => "04:00 PM",
                  "17:00" => "05:00 PM",
                  "18:00" => "06:00 PM",
                  "19:00" => "07:00 PM",
                  "20:00" => "08:00 PM",
                  "21:00" => "09:00 PM",
                  "22:00" => "10:00 PM",
                  "23:00" => "11:00 PM",
                  "00:00" => "12:00 MN",
                  "01:00" => "1:00 AM",
                  "02:00" => "2:00 AM",
                  "03:00" => "3:00 AM",
                  "04:00" => "4:00 AM",
                  "05:00" => "5:00 AM",
                  "06:00" => "6:00 AM",
                  "07:00" => "7:00 AM",
              );
                if ($user_info) {
                  $exp_start = explode(':',$user_info->work_start);
                  $current_exp_start = $exp_start[0].':'.$exp_start[1];

                  $exp_end = explode(':', $user_info->work_end);
                  $current_exp_end = $exp_end[0].':'.$exp_end[1];
                }
                
              ?>
              <?php echo form_dropdown('work_start', $hour, $user_info ? $current_exp_start : '') ?>
            </div>
            <div class="form-group">
              <label for="work_end">Work end</label>
              <?php echo form_dropdown('work_end', $hour, $user_info ? $current_exp_end : '') ?>
            </div>
            <input type="submit" class = "btn btn-default" name="Submit" value = "Save Changes">
          </form>

        </div>
        <div class = "col-md-3"></div>
      </div>
      

    </div>



</body>
</html>