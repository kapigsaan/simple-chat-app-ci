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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class = "glyphicon glyphicon-user"> </span> Profile <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
                <a href="#" class="btn btn-default">
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
    <hr/>
    <div class="row">
        <div class = "col-md-3 text-left">
            <div>
                <a href="javascript:;" class="btn btn-default btn-md" id = "add-room">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Room
                </a>
                <div id = "add-room-input" hidden>
                    <form>
                        <input class = "form-control" type="text" name="room" placeholder="Room Name">
                        <div class="btn-group">
                            <input type="submit" class = " btn btn-default" name="Add" value = "Add">
                            <a href="javascript:;" id = "add-room-cancel" class = " btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <h2>Rooms</h2>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Room #1
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <p>test &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                    <p>test &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                    <p>test &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                  </div>
                </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Room #2
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    <p>test sdfdsf &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                  </div>
                </div>
            </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Room #3
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        <p>test &nbsp;<button type="button" class="btn btn-success btn-circle"></button></p>
                      </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
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
                    </div>
                </div>
                <div id = "panel-body-1" class="panel-body" style="height:350px;">
                    <ul class="chat">

                    </ul>

                </div>

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
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>63</td>
                        <td><a href="javascript:;" class = "btn btn-default"><span class = "glyphicon glyphicon-plus"></span>add</a></td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td><a href="javascript:;" class = "btn btn-default"><span class = "glyphicon glyphicon-plus"></span>add</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){

    	$('#panel-body-1').scrollTop($('#panel-body-1')[0].scrollHeight);

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
                        scroll();
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

    function scroll(){
    	var elem = document.getElementById('panel-body-1');
	  	elem.scrollTop = elem.scrollHeight;
    }

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

    //data tables

    $(document).ready(function() {
        $('#example').DataTable();
    } );

</script>