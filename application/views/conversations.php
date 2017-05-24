<?php
  $room = $conversation[$roomId]['room'];
  $userIds = $conversation[$roomId]['room-users-user-id'];

  $messages = $getAllUserMessage($userIds);
?>

<?php if ($roomId) { ?>
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
<?php } ?>