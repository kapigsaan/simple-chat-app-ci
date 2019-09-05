<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	$config['googleplus']['application_name'] = 'chat app';
	$config['googleplus']['client_id']        = 'clientId';
	$config['googleplus']['client_secret']    = 'clientSecret';
	$config['googleplus']['redirect_uri']     = 'http://localhost/chat-app/';
	$config['googleplus']['api_key']          = 'API_KEY';
	$config['googleplus']['scopes']           = array("email", "profile");
