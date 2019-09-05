<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <a href = "<?php echo site_url('admin/setup') ?>" class = "btn btn-default">View All user logins</a>

    <div class="container">
      <h2>Conversations</h2>
      <p>Show all</p>            
      <table class="table">
        <thead>
          <tr>
            <th>Room Name</th>
            <th>Room Owner</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($conversations as $conversation) { ?>
                <tr>
                    <td><?php echo $conversation->name?></td>
                    <td><?php echo $conversation->fullname?></td>
                    <td><a href = "<?php echo site_url('admin/viewConversation/'.$conversation->id) ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                  </tr>
            <?php } ?>

        </tbody>
      </table>
    </div>



</body>
</html>