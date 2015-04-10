# UrlShortener
Old 2012 URL Shortener Project

This repository contains the code of an URL shortener I wrote in 2012, introduced with this blog post: https://tsarstva.bg/sh/url-shortener.

Keeping it here mainly for historical purposes.

To build the application, first execute these SQL queries:

CREATE TABLE `links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `link` varchar(255) NOT NULL UNIQUE,
  `url` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE utf8_bin;

and 

CREATE TABLE `visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vip` varchar(16) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `lid` int(10) unsigned DEFAULT NULL,
  `when` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY `lid` REFERENCES links(`id`)
  ON DELETE CASCADE
 ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE utf8_bin;
 
 and then copy and modify the files in the repo to suit your tastes.
