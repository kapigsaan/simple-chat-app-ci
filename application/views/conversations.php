<?php
  $room = $conversation[$roomId]['room'];
  $userIds = $conversation[$roomId]['room-users-user-id'];

  $messages = $getAllUserMessage($userIds);
?>

<?php if ($roomId) { ?>
    <?php foreach ($messages as $message) : ?>
      <?php if ($loggedInUserId == $message->user): ?>
        <li class="right clearfix"><span class="chat-img pull-right">
            <img style = "height: 50px;" src="<?php echo $message->profile_image ?>" alt="User Avatar" class="img-circle" />
        </span>
            <div class="chat-body clearfix">
                <div class="header">
                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span><?php echo date('F d H:i',strtotime($message->created_at));?></small>
                    <strong class="pull-right primary-font"><?php echo $message->fullname ?></strong>
                </div>
                <p>
                    <?=$message->message?>
                </p>
            </div>
        </li>
      <?php else: ?>
        <li class="left clearfix"><span class="chat-img pull-left">
            <img style = "height: 50px;" src="<?php echo $message->profile_image ?>" alt="User Avatar" class="img-circle" />
        </span>
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font"><?php echo $message->fullname ?></strong> <small class="pull-right text-muted">
                        <span class="glyphicon glyphicon-time"></span><?php echo date('F d H:i',strtotime($message->created_at));?></small>
                </div>
                <p>
                    <?=$message->message?>
                </p>
            </div>
        </li>
      <?php endif ?>
    <?php endforeach; ?>
<?php } ?>