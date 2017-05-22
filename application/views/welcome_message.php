<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<style type="text/css">
	.chat
	{
	    list-style: none;
	    margin: 0;
	    padding: 0;
	}

	.chat li
	{
	    margin-bottom: 10px;
	    padding-bottom: 5px;
	    border-bottom: 1px dotted #B3A9A9;
	}

	.chat li.left .chat-body
	{
	    margin-left: 60px;
	}

	.chat li.right .chat-body
	{
	    margin-right: 60px;
	}


	.chat li .chat-body p
	{
	    margin: 0;
	    color: #777777;
	}

	.panel .slidedown .glyphicon, .chat .glyphicon
	{
	    margin-right: 5px;
	}

	.panel-body
	{
	    overflow-y: scroll;
	    height: 250px;
	}

	::-webkit-scrollbar-track
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar
	{
	    width: 12px;
	    background-color: #F5F5F5;
	}

	::-webkit-scrollbar-thumb
	{
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
	    background-color: #555;
	}
</style>

<div class="container">
    <br/>
    <div class = "row text-center">
    	<h1>Simple Chat App</h1>
    </div>
    <hr/>
    <div class="row">
        <div class = "col-md-3 text-center">
        	<a href="<?php echo site_url('welcome/changeUser/1')?>" class = "btn btn-primary btn-lg" 
        	<?php if($activeUser == 2):?>
        		disabled
        	<?php endif; ?>
        	>USER 1</a>
        </div>
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
                <div id = "panel-body-1" class="panel-body" style="height:350px;">
                    <ul class="chat">

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
        <div class = "col-md-3 text-center">
        	<a href="<?php echo site_url('welcome/changeUser/2')?>" class = "btn btn-success btn-lg"
        	<?php if($activeUser == 1):?>
        		disabled
        	<?php endif; ?>
        	>USER 2</a>
        </div>
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
                     url: "<?php echo site_url('welcome/createMessage/'.$activeUser) ?>",
                     dataType: 'json',
                     data: {message: message},
                     success:function(data){
                        console.log(data);
                        var elem = document.getElementById('panel-body-1');
	  					elem.scrollTop = elem.scrollHeight;
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

    getMessages();
    setInterval(getMessages, 500);

    function getMessages()
    {
        // 1. get data database
        // 2. reappend everything
        // 3. refreshed

        $.ajax({
             type: "GET",
             url: "<?php echo site_url('welcome/getConversation/'.$activeUser) ?>",
             dataType: 'json',
             success:function(data){
                console.log(data['messages']);
                $(".panel-body .chat").html('');
                $(".panel-body .chat").append(data['messages']);
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

</script>