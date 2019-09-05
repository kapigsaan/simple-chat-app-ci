<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to Chat App</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
         $(document).ready(function(){
            $('#add-room').on('click', function(){
                $('#add-room-input').show();
                $('#add-room').hide();
            });
            $('#add-room-cancel').on('click', function(){
                $('#add-room-input').hide();
                $('#add-room').show();
            });
        });
    </script>
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
    .btn-circle {
      width: 10px;
      height: 10px;
      text-align: center;
      padding: 3px 0;
      font-size: 8px;
      line-height: 1.428571429;
      border-radius: 50px;
      float: right;
    }
    #radioBtn .notActive{
        /*color: #3276b1;*/
        background-color: #fff;
    }
</style>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        Simple Chat App
      </a>

    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class = "glyphicon glyphicon-user"> </span>  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
                <a href="<?php echo site_url('login/profile')?>" >
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile
                </a>
                <a href="<?php echo site_url('login/logout')?>" >
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout
                </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    

  </div>
</nav>

<div class="container">
	<?php 
		$roomOwner = $checkIfRoomOwner($loggedInUserId);
		$roomMember = $checkIfRoomMember($loggedInUserId);
	?>
    <hr/>
    <div class="row">
        <div class = "col-md-3 text-left">
            <div>
                <a href="javascript:;" class="btn btn-default btn-md" id = "add-room">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Room
                </a>
                <div class="panel-group" id = "add-room-input" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">Add Room</div>
                        <div class="panel-body">
                            <form action ="<?php echo site_url('welcome/addRoom')?>" method = "POST">
                                <input class = "form-control" type="text" name="room-name" placeholder="Room Name" required="required"><br/>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div id="radioBtn" class="btn-group">
                                            <a class="btn btn-default btn-sm active" data-toggle="happy" data-title="public">Public</a>
                                            <a class="btn btn-default btn-sm notActive" data-toggle="happy" data-title="private">Private</a>
                                        </div>
                                        <input type="hidden" name="happy" id="happy" value="public">
                                    </div>
                                </div><br/>
                                <input type="submit" class = "btn btn-default" name="Add" value = "Add">
                                <a href="javascript:;" id = "add-room-cancel" class = " btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Rooms</h2>
            
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <?php if ($rooms): ?>
                    <?php foreach ($rooms as $key => $v) :?>
                        <?php 
                            $room = $v['room'];
                            $member = $v['room-members'];
                            $isMember = $checkIfMemberInRoom($room->status, $room->id);
                        ?>
                        <?php if ($isMember): ?>
                            <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="heading<?php echo $room->id?>">
                                <h4 class="panel-title">
                                  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $room->id?>" aria-expanded="false" aria-controls="collapse<?php echo $room->id?>">
                                    <?php echo $room->name ?> - (<?php echo $room->status?>)
                                  </a>

                                  <a href = "<?php echo site_url('welcome/index/'.encode_url($room->id)) ?>" style = "float: right">
                                      <span class = "glyphicon glyphicon-share-alt"></span>
                                  </a>
                                </h4>
                              </div>
                              <div id="collapse<?php echo $room->id?>" class="panel-collapse collapse 
                                  <?php if ($activeRoomId == $room->id): ?>
                                      in
                                  <?php endif ?>" role="tabpanel" aria-labelledby="heading<?php echo $room->id?>">
                                <div class="panel-body">
                                  <?php if ($member): ?>
                                      <?php foreach ($member as $y => $e):?>
                                          <div class="btn-group pull-left">
                                          <?php if ($e->userId != $room->owner ): ?>
                                          	<?php if ($loggedInUserId == $room->owner): ?>
	                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                                                <span class="glyphicon glyphicon-chevron-down"></span>
	                                            </button>
	                                            <ul class="dropdown-menu slidedown">
	                                                <li>
	                                                    <a href="<?php echo site_url('welcome/kickMember/'.$e->userId.'/'.$room->id)?>" >
	                                                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	                                                      	Kick Member
	                                                    </a>
	                                                </li>
	                                            </ul>
	                                            <?php elseif ($loggedInUserId == $e->userId): ?>
	                                            	<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                                                <span class="glyphicon glyphicon-chevron-down"></span>
	                                            </button>
	                                            <ul class="dropdown-menu slidedown">
	                                                <li>
	                                                    <a href="<?php echo site_url('welcome/kickMember/'.$e->userId.'/'.$room->id)?>" >
	                                                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	                                                      	Leave Room
	                                                    </a>
	                                                </li>
	                                            </ul>
	                                          <?php endif ?>
                                          <?php endif ?>
                                      </div>
                                      <p>&nbsp;&nbsp;<?php echo $e->fullname ?> &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                                      <?php endforeach; ?>
                                  <?php endif ?>
                                </div>
                              </div>
                          </div>
                        <?php endif ?>
                    <?php endforeach; ?>
                <?php endif ?>

            </div>

            <!-- <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                          Private
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <p>&nbsp;&nbsp; Test 1 &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                      </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Public
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <p>&nbsp;&nbsp; Test 1 &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                      </div>
                    </div>
                </div>
            </div> -->


        </div>
        <div class="col-md-9">
            <div class="panel panel-default" <?php if (!$activeRoom) { echo 'hidden';} ?> >
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> <?php if ($activeRoom) { echo $activeRoom->name; } ?>
                    <div class="btn-group pull-right">
                    	<?php if ($roomOwner): ?>
                    		<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                            <span class="glyphicon glyphicon-chevron-down"></span>
	                        </button>
	                        <ul class="dropdown-menu slidedown">
	                            <li>
	                                <a href="#" data-toggle="modal" data-target=".bs-example-modal-md" >
	                                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add member
	                                </a>
	                            </li>
	                        </ul>
                    	<?php endif ?>
                    </div>
                </div>
                <div id = "panel-body-1" class="panel-body" style="height:350px;">
                    <ul class="chat">

                    </ul>

                </div>

                <?php if ($roomMember): ?>
                	<div class="panel-footer">
	                    <div class="">
	                        <form>
	                            <div class="input-group">
	                               <input id="btn-input" type="text" class="message form-control" name = "message" placeholder="Type your message here..."/>
	                               <span class="input-group-btn">
	                                    <input class = "btn btn-default btn-md sendMessage" id="btn-chat" type="submit" name="Send" value="Send" />
	                               </span>
	                            </div>
	                        </form>
	                    </div>
	                </div>
                <?php endif ?>
            </div>
        </div>

			<!-- <a href="<?php echo site_url('welcome/changeUser/1')?>" class = "btn btn-success btn-lg" 
        	<?php if($activeUser == 2):?>
        		disabled
        	<?php endif; ?>
        	>USER 1</a><br/>
        	<a href="<?php echo site_url('welcome/changeUser/2')?>" class = "btn btn-success btn-lg"
        	<?php if($activeUser == 1):?>
        		disabled
        	<?php endif; ?>
        	>USER 2</a><br/> -->
    </div>
</div>


<!-- modal -->

<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="gridSystemModalLabel">User Lists</h3>
      </div>
      <div class="modal-body">
        <div class="row">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>username</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($availableUser as $user) : ?>
                        <tr>
                            <td><?php echo $user->fullname ?> </td>
                            <td><a href="<?php echo site_url('user/addUserToRoom/'.$user->id).'/'.$activeRoomId ?>" class = "btn btn-default"><span class = "glyphicon glyphicon-plus"></span>add</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        getMessages();
        setInterval(getMessages, 2000);

    function getMessages()
    {
        // 1. get data database
        // 2. reappend everything
        // 3. refreshed

        $.ajax({
             type: "GET",
             url: "<?php echo site_url('welcome/getConversation/'.$activeRoomId) ?>",
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
               // alert('request failed');
            }
        });
        
    }
    });
</script>
<script type="text/javascript">
    $(".sendMessage").on('click', function(e){
            e.preventDefault();
            var message = $(".message").val();
            var html = '<li class="right clearfix"><span class="chat-img pull-right"><img style = "height:50px;" src="<?php echo $picture ?>" alt="User Avatar" class="img-circle" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font"><?php echo $fullname ?></strong> <small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>Just Now</small></div><p>'+message+'.</p></div></li>';

            if (message != '')
            {
                $(".panel-body .chat").append(html);
                $(".message").val('');

                 $.ajax({
                     type: "POST",
                     url: "<?php echo site_url('welcome/createMessage/'.$activeRoomId) ?>",
                     dataType: 'json',
                     data: {message: message},
                     success:function(data){
                        console.log(data);
                        scroll();
                     },
                     error: function(xhr, status, errorThrown){
                        console.log(errorThrown);
                        console.log(status);
                        console.log(xhr);
                       console.log(arguments);
                       // location.reload();
                    }
                });

            }
        });
</script>
<script type="text/javascript">
    $(document).ready(function(){

    	$('#panel-body-1').scrollTop($('#panel-body-1')[0].scrollHeight);


    });

    function scroll(){
    	var elem = document.getElementById('panel-body-1');
	  	elem.scrollTop = elem.scrollHeight;
    }


    //data tables

    $(document).ready(function() {
        $('#example').DataTable();
    } );


</script>
<script type="text/javascript">
    $('#radioBtn a').on('click', function(){
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#'+tog).prop('value', sel);
        
        $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    })
</script>