
# google-login-ci3 with chat App

Installation

Clone or download project

rename folder to  'app-chat'

create database   'chat_app'

run migrations :ex

http://localhost/chat-app/index.php/migration/7
or
http://localhost/chat-app/migration/7


Google Login with Codeigniter 3

change
on application->config->googleplus.php with your key and configuration

how to get configurations
https://medium.com/@pablo127/google-api-authentication-with-oauth-2-on-the-example-of-gmail-a103c897fd98

```
$config['googleplus']['application_name'] = '';
$config['googleplus']['client_id']        = '';
$config['googleplus']['client_secret']    = '';
$config['googleplus']['redirect_uri']     = '';
$config['googleplus']['api_key']          = '';
$config['googleplus']['scopes']           = array();
```

the $config['googleplus']['redirect_uri']     = ''; is callback url for authenticate user info..in my case i put authenticate in Welcome controller and index function..so for example my redirect uri is :
```
$config['googleplus']['redirect_uri']     = 'http://localhost/my_directory/';
```

## Tutorial based on
> http://www.9lessons.info/2012/09/login-with-google-account-oauth.html


then you're good to go!..



