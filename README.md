MemcachedRealTime
=================

A real time graph to monitor hits-per-second on your Memcached server.

Prerequisites
-------------

* A http://pusher.com account. They offer a free plan with 100,000 requests per day limit. There are 86,400 seconds in a day, so plenty :)

Installation guide
------------------

* Copy files to your Web server (path does not matter),
* Edit the /Library/config.ini for your specific settings,
* Run the server.php as a server (php -q server.php),
* Navigation your browser to index.php,
* Watch as the graph will display real-time hits on your Memcached server.