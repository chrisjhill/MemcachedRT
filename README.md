<img src="http://laboratory.chrisjhill.co.uk/memcachedrt/screen-small.png" align="right" />

Introducing MemcachedRT
======================

A tiny application that will monitor your Memcached server, providing real-time monitoring and up-to-the-second data in a glance-able format.

Features include:
-----------------

 * Easily configurable in just one config.ini file.
 * Live graph with actions p/s (white) and evictions p/s (red).
 * All WebSockets, no Ajax here, ma!
 * Glance-able colour coded statuses; green for "Good", orange for "Okay", red for "Eek".
 * Know your Get and Set proportion.
 * Discover if you are missing or evicting a lot of data.
 * Be alerted when you are running out of storage space.
 * Know the stability of your server with the live uptime status.
 * Details on item quantity, actions performed, and connection count.
 * Responsive design; plays nicely at any size and on your mobile device.
 * Know when a connection is lost to your server, and automatic recovery.
 * Only have Memcached installed locally? No problem, use the test-server.php script.
 * Released under the MIT licence.

Prerequisites
-------------

* A http://pusher.com account. They offer a free plan with 100,000 requests per day limit. There are 86,400 seconds in a day, so plenty :)

Installation guide
------------------

* Copy files to your Web server (path does not matter),
* Edit the Library/config.ini for your specific settings,
* Run the server.php in your terminal (php -q server.php),
* Navigation your browser to index.php,
* Watch as the graph will display real-time hits on your Memcached server.