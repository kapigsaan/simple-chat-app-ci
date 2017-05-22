<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <link rel="stylesheet" type="text/css" href="<?php base_url();?>assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?php base_url();?>assets/css/bootstrap.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<a href = "<?php echo site_url()?>">user swtch</a>
<div class="container">
    <br/>
    <hr/>
    <br/>
    <div class="row">
        <div class = "col-md-3"></div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
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
                        <?php if ($messages) { ?>
                            <?php echo $activeUser ?>
                            <?php foreach($messages as $message) {?>
                                <?php if ($message->user == $activeUser) { ?>
                                    <li class="left clearfix"><span class="chat-img pull-left">
                                        <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                                    </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font">User 1</strong> <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                                            </div>
                                            <p>
                                                <?=$message->message?>
                                                <?=$message->id?>
                                            </p>
                                        </div>
                                    </li>
                                <?php }else{ ?>

                                    <li class="right clearfix"><span class="chat-img pull-right">
                                        <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                                    </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>13 mins ago</small>
                                                <strong class="pull-right primary-font">User 2</strong>
                                            </div>
                                            <p>
                                                <?=$message->message?>
                                                <?=$message->id?>
                                            </p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>

                </div>
                <div class="panel-footer">
                        <div class="input-group">
                            <form>
                                <input id="btn-input" type="text" class="message form-control input-sm" name = "message" placeholder="Type your message here..."/>

                                <span class="input-group-btn">
                                    <input class = "btn btn-warning btn-sm sendMessage" id="btn-chat" type="submit" name="Send" value="Send" />
                                </span>

                            </form>

                        </div>
                    
                </div>
            </div>
        </div>
        <div class = "col-md-3"></div>
    </div>
</div>



</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $(".sendMessage").on('click', function(e){
            e.preventDefault();
            var message = $(".message").val();
            var html = '<li class="left clearfix"><span class="chat-img pull-left"><img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">User</strong> <small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>12 mins ago</small></div><p>'+message+'.</p></div></li>';

            if (message != '')
            {
                $(".panel-body .chat").append(html);
                $(".message").val('');

                 $.ajax({
                     type: "POST",
                     url: "index.php/welcome/createMessage",
                     dataType: 'json',
                     data: {message: message},
                     success:function(data){
                        console.log(data);
                     },
                     error: function(xhr, status, errorThrown){
                        console.log(errorThrown);
                        console.log(status);
                        console.log(xhr);
                       console.log(arguments);
                       alert('request failed');
                    }
                });

            }
        });
    });
</script>