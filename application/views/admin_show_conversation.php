<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome to CodeIgniter</title>

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
<?php
  $room = $conversation[$roomId]['room'];
  $userIds = $conversation[$roomId]['room-users-user-id'];

  $messages = $getAllUserMessage($userIds);
?>

  <br/>
  <hr/>
  <br/>
    <div class="row">
      <div class = "col-md-3"><a href = "<?php echo site_url('admin/home') ?>" class = "btn btn-default">Go Back</a></div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span><?php echo $room->name ?>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </button>
                        <ul class="dropdown-menu slidedown">
                        </ul>
                    </div>
                </div>
                <div class="panel-body" style="height:500px;">
                    <ul class="chat">

                        <?php foreach ($messages as $message) : ?>
                          <li class="left clearfix"><span class="chat-img pull-left">
                              <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                          </span>
                              <div class="chat-body clearfix">
                                  <div class="header">
                                      <strong class="primary-font">User <?php echo $message->user?></strong> <small class="pull-right text-muted">
                                          <span class="glyphicon glyphicon-time"></span><?php echo date('F d H:i',strtotime($message->created_at));?></small>
                                  </div>
                                  <p>
                                      <?=$message->message?>
                                  </p>
                              </div>
                          </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
        <div class = "col-md-3"></div>
    </div>
</div>



</body>
</html>