<?php
include dirname(__FILE__) . '/Library/Config.class.php';

// Run a quick 1000 set, get, and delete requests to Memcached
$memcached = new Memcached();
$memcached->addServer(Config::get('host'), Config::get('portMemcached'));

for ($i = 0; $i <= 1000; $i++) {
	$memcached->set("var-{$i}", 'Foo');
	$memcached->get("var-{$i}");
	$memcached->delete("var-{$i}");
}