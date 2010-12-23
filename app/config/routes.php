<?php

  // this is the routes file

	Router::connect('/', array('controller' => 'pages', 'action' => 'welcome'));
	
	Router::connect('/_:page', array('controller' => 'pages', 'action' => 'display'));
	
	Router::connect('/404', array('controller'=>'pages', 'action'=>'notfound'));
	
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	
	Router::connect('/admin', array('controller' => 'users', 'action' => 'admin_landing'));
	
	Router::connect('/mdx_member', array('controller' => 'members', 'action' => 'member_landing'));
	
	Router::connect('/mdx_client', array('controller' => 'clients', 'action' => 'clients_landing'));
	
	
