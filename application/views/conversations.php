<?php if ($room) { ?>
<?php if ($messages) { ?>
<?php foreach($messages as $message) {?>
    <?php if ($message->user == $activeUser) { ?>
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
    <?php }else{ ?>

        <li class="right clearfix"><span class="chat-img pull-right">
            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
        </span>
            <div class="chat-body clearfix">
                <div class="header">
                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span><?php echo date('F d H:i',strtotime($message->created_at));?></small>
                    <strong class="pull-right primary-font">User <?php echo $message->user?></strong>
                </div>
                <p>
                    <?=$message->message?>
                </p>
            </div>
        </li>
    <?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>