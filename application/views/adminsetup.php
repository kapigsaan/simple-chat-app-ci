<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

    <div class="container">
      <h2>Setup user creds</h2>
      <p>Users</p>            
      <table class="table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->fullname?></td>
                    <td>
                    <a href = "<?php echo site_url('admin/setupUserCreds/'.encode_url($user->id)) ?>"><span class="glyphicon glyphicon-wrench"></span>&nbsp;Setup</a>
                    <a href = "<?php echo site_url('admin/viewUserLog/'.encode_url($user->id)) ?>"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;View Employee Log</a>
                    </td>
                  </tr>
            <?php endforeach ?>
        <?php endif ?>

        </tbody>
      </table>
    </div>



</body>
</html>