-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2015 at 02:20 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bren_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `eval_test`
--

CREATE TABLE IF NOT EXISTS `eval_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `eval_test`
--

INSERT INTO `eval_test` (`id`, `code`) VALUES
(2, '<?php\r\n	$name = "Brendon";\r\n	echo "Hello ".$name."<br/>";\r\n?>\r\nSome Html<br/> <b>DERP</b> followed by php code\r\n<?php\r\n	$derp = 4 * 4 * 4;\r\n	echo $derp;\r\n?>');

-- --------------------------------------------------------

--
-- Table structure for table `module_layouts`
--

CREATE TABLE IF NOT EXISTS `module_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(155) NOT NULL,
  `number_of_containers` int(11) NOT NULL,
  `default_container` int(11) NOT NULL,
  `brief_description` varchar(255) NOT NULL,
  `html` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `module_layouts`
--

INSERT INTO `module_layouts` (`id`, `name`, `number_of_containers`, `default_container`, `brief_description`, `html`, `image`, `order`) VALUES
(1, 'Default', 1, 1, 'Default one column page', '<div class="page" id="page_one_column">\r\n  <div id="column1" class="column" style="width: 100%">{column_1}</div>\r\n</div>', '/images/layout_1.png', 1),
(3, 'Two Column Layout', 2, 1, 'A Two Column Layout', '<div class="page" id="page_two_column">\r\n  <div id="column1" class="column" style="width: 48%; float: left;">{column_1}</div>\r\n  <div id="column2"  class="column" style="width: 48%; float: right;">{column_2}</div>\r\n</div>', '/images/layout_2.png', 1),
(4, 'Two column wide right', 2, 1, 'Two Columns with wide right column', '<div class="page" id="page_two_column_wide_right">\r\n  <div id="column1" class="column" style="width: 28%; float: left;">{column_1}</div>\r\n  <div id="column2" class="column" style="width: 68%; float: right;">{column_2}</div>\r\n</div>', '/images/layout_2_right.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `module_menu`
--

CREATE TABLE IF NOT EXISTS `module_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(55) NOT NULL,
  `menu_description` varchar(255) NOT NULL,
  `menu_orientation` int(1) NOT NULL DEFAULT '1',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module_menu`
--

INSERT INTO `module_menu` (`id`, `menu_name`, `menu_description`, `menu_orientation`, `last_update`) VALUES
(1, 'Main Menu', 'Main Menu of the site', 1, '2012-02-29 00:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `module_menu_links`
--

CREATE TABLE IF NOT EXISTS `module_menu_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `link_name` varchar(55) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `new_window` int(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `module_menu_links`
--

INSERT INTO `module_menu_links` (`id`, `menu_id`, `parent_id`, `link_name`, `link_url`, `new_window`, `order`) VALUES
(1, 1, 1, 'Home', '/', 0, 0),
(2, 1, 1, 'Useful Links', '/links', 0, 0),
(4, 1, 1, 'Coding', '#', 0, 0),
(6, 1, 1, 'About Me', '/about', 0, 0),
(7, 1, 6, 'Resume', 'resume', 0, 2),
(9, 1, 1, 'Other', '#', 0, 0),
(10, 1, 9, 'Fringe', 'fringe', 0, 0),
(57, 1, 4, 'Regular Expressions', '/regex', 0, 0),
(58, 1, 4, 'Using Eval PHP', '/evaltest', 0, 0),
(59, 1, 4, 'Location and G Maps', '/geomap', 0, 0),
(60, 1, 6, 'Cover Letter', '/cover', 0, 0),
(62, 1, 9, 'Admin', '/admin', 1, 10),
(66, 1, 9, 'Sticky Note', '/sticky', 0, 0),
(67, 1, 4, 'Jquery Snippets', '/jquery', 0, 0),
(68, 1, 4, 'Javascript vs JQuery', '/javascript', 0, 0),
(69, 1, 4, 'CSS Selectors', '/csselectors', 0, 0),
(70, 1, 4, 'SQLite and Offline Storage', '/sqlite', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `module_object_fields`
--

CREATE TABLE IF NOT EXISTS `module_object_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(55) NOT NULL,
  `field_type` varchar(55) NOT NULL,
  `field_validator_id` int(11) NOT NULL DEFAULT '-1',
  `requires_validator` binary(1) NOT NULL,
  `object_parent` int(11) NOT NULL,
  `field_sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_object_template`
--

CREATE TABLE IF NOT EXISTS `module_object_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_name` varchar(55) NOT NULL,
  `object_owner` int(11) NOT NULL,
  `order_by` int(11) NOT NULL,
  `inherits_object_fields` int(11) NOT NULL,
  `object_num_fields` int(11) NOT NULL,
  `object_template` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `url_hash` varchar(150) NOT NULL,
  `url_index` varchar(55) NOT NULL,
  `update_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_title` varchar(255) NOT NULL,
  `page_description` varchar(255) NOT NULL,
  `page_keywords` varchar(255) NOT NULL,
  `page_views` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `parent_id`, `url_hash`, `url_index`, `update_creation`, `page_title`, `page_description`, `page_keywords`, `page_views`) VALUES
(4, 0, '44c5b763d21e9a3ed8cad56977bfd75c', 'regex', '2012-04-15 21:20:30', 'Regular Expressions', 'This is a brief description.', 'regular expression, regex', 4),
(5, 0, 'e889b1ca9624a9fbe23c4f062d7e5f01', 'geomap', '2012-04-15 19:00:02', 'Google Map - Geo Location', 'Google Map test', 'Google, Google Maps, Geolocation, location, gps, html', 2),
(7, 0, 'c2adf6ecc220f2711801d6e466340183', 'notfound', '2012-04-15 21:12:41', 'Page Not Found', 'This is the not found page', 'Not Found, 404', 1),
(8, 0, 'd223e1439188e478349d52476506c22e', 'jquery', '2012-04-15 21:20:49', 'jQuery Fun', 'Some JQuery Fun Stuff', 'jQuery, JavaScript, Fun, JQuery UI', 4),
(9, 0, 'de9b9ed78d7e2e1dceeffee780e2f919', 'javascript', '2012-05-03 22:16:49', 'JavaScript', 'java Script', '', 0),
(10, 0, '258b42921ba4685c9f3ec397cc26dd6c', 'csselectors', '2012-05-09 04:40:58', 'CSS Selectors', 'A page about CSS', 'CSS', 0),
(12, 0, '786d348e95448121dc5b7387e22e4fff', 'sqlite', '2012-05-13 04:20:22', 'Local Storage and SQLite', 'SQLite, Offline Storage', 'SQLite, Offline Storage', 0),
(13, 0, '5f17dd871dacc61834234a9cd5aa375d', 'herpderp', '2013-03-08 16:49:05', 'Herp Derp', 'Her', 'Derp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages_content_layout`
--

CREATE TABLE IF NOT EXISTS `pages_content_layout` (
  `page_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_content_layout`
--

INSERT INTO `pages_content_layout` (`page_id`, `content_id`, `column_id`, `order`) VALUES
(5, 1, 7, 0),
(4, 1, 4, 0),
(7, 1, 9, 0),
(8, 1, 14, 0),
(8, 1, 20, 1),
(8, 1, 23, 2),
(8, 1, 22, 3),
(8, 1, 24, 4),
(8, 1, 25, 5),
(8, 1, 27, 6),
(9, 1, 28, 0),
(9, 1, 29, 1),
(10, 1, 30, 2),
(12, 1, 32, 2),
(13, 1, 33, 0),
(13, 1, 4, 1),
(13, 1, 23, 2),
(13, 2, 33, 0),
(13, 2, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages_layout`
--

CREATE TABLE IF NOT EXISTS `pages_layout` (
  `page_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_layout`
--

INSERT INTO `pages_layout` (`page_id`, `layout_id`) VALUES
(5, 1),
(4, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(12, 1),
(13, 4);

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

CREATE TABLE IF NOT EXISTS `page_content` (
  `page_content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_Description` varchar(255) NOT NULL,
  `content_type` varchar(55) NOT NULL,
  `page_source` longtext NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`page_content_id`, `content_id`, `content_Description`, `content_type`, `page_source`, `last_update`) VALUES
(1, 1, 'Content for Test from DB page', 'text', '<h1>Page from database!</h1>\r\n<p>Save appears to work...</p>', '2012-03-26 04:07:37'),
(4, 4, 'Content block for Regex Page', 'text', '<p>[a-zA-Z] <br /><br />The ^ metacharacter - (also called a caret), when it is the first character after the left square bracket, indicates that any other cases specified inside the square brackets are not to be matched.<br />^ metacharacter occurs in any position inside square brackets&nbsp; has its literal meaning (unless it is the first character after a [)<br /><br />Negated Character Classes - &ldquo;Match a character that is not in the range<br />ex: [^A-F] <br /><br />The $ metacharacter provides complementary functionality<br />in that it specifies matches in a sequence of characters that immediately precede the end of a line or<br /><br />^$ (blank lines)<br /><br />Because the $ metacharacter in a regular expression pattern indicates the end-of-line (or end-of-string)<br />position, you cannot use that metacharacter to match the dollar currency symbol in a document. To<br />match the dollar sign in a string, you must use the \\$ escape sequence.<br /><br />\\ --&gt; indicates metacharacter - A metacharacter<br />can be a single character or a pair of characters (the first is typically a backslash) that has a meaning other than the literal characters it contains.<br />\\d&nbsp;&nbsp; --&gt; numeric ([0-9] numeric digit 0 through 9, inclusive<br />\\D&nbsp;&nbsp; --&gt; any digit which is NOT numeric (include alphabetic characters (both English-language and non&ndash;English-language alphabetic characters) and whitespace characters such as space characters.)<br /><br />? --&gt; which means zero or one lowercase example: colou?r (0 or 1 u)<br />The * operator refers to zero or more occurrences of the pattern to which it is related<br />The + operator means &ldquo;Match one or more occurrences of the chunk that precedes me.&rdquo;<br /><br />Quantifier Definition<br />? 0 or 1 occurrences<br />* 0 or more occurrences<br />+ 1 or more occurrences<br /><br />{n} you can use a curly-brace syntax to specify an exact number of occurrences. ex: [0-9]{3} (3 digits)<br /><br />The {n,m} Syntax - allows you to specify that a minimum of n occurrences can be matched (specifiedby the first numeric digit after the opening curly brace) and that a maximum of m occurrences<br />{n,} min of n, followed by unlimited<br /><br />The Period (.) Metacharacter - It can match any alphabetic character, whether lowercase or uppercase, as well as any numeric digit and symbols; punctuation<br /><br />Matching a Literal Period - \\. - To match a period in a target document, you must escape the period using a backslash:<br /><br />The \\w Metacharacter - metacharacter matches only characters in the English alphabet, plus numeric digits and the underscore character (does not match symbols; punctuation)&nbsp; =&gt; [A-Za-z0-9_]<br />The \\W Metacharacter - matches any character other than ASCII alphabetic characters, numeric digits, or the underscore character.<br /><br />example: can postal code: \\w\\d\\w ?\\d\\w\\d or: [A-Z][0-9][A-Z] ?[0-9][A-Z][0-9] or [A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]<br /><br />The \\s Metacharacter - least specific of the metacharacters that can match any single whitespace character. The \\s metacharacter can match a space character, a tab character, or a newline character<br />The \\S Metacharacter - matches any character that is not a whitespace character. Characters from languages other than English will also match the \\S metacharacter. <br /><br />The \\t Metacharacter - metacharacter matches a tab character.<br />The \\n Metacharacter - matches a newline character<br /><br />the \\b Metacharacter - Inside a character class it represents a backspace character.<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; - Outside a character class the \\b metacharacter signifies a word boundary;<br />&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; <br />Inside a character class the $ character simply matches itself.<br />Outside a character class the $ metacharacter matches a position rather than a character, as is discussed<br /><br />Selecting Literal Square Brackets use: \\[ or \\]<br /><br />\\\\ selects a single backslash<br />\\. to match a period.<br /><br />ip address:<br />^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$<br /><br /><br />Positive Integers --- ^\\d+$<br />Negative Integers --- ^-\\d+$<br />Integer --- ^-{0,1}\\d+$<br />Positive Number --- ^\\d*\\.{0,1}\\d+$<br />Negative Number --- ^-\\d*\\.{0,1}\\d+$<br />Positive Number or Negative Number - ^-{0,1}\\d*\\.{0,1}\\d+$<br />Phone number --- ^\\+?[\\d\\s]{3,}$<br />Phone with code --- ^\\+?[\\d\\s]+\\(?[\\d\\s]{10,}$<br />Year 1900-2099 --- ^(19|20)[\\d]{2,2}$<br />Date (dd mm yyyy, d/m/yyyy, etc.) --- ^([1-9]|0[1-9]|[12][0-9]|3[01])\\D([1-9]|0[1-9]|1[012])\\D(19[0-9][0-9]|20[0-9][0-9])$<br />email --- ^[\\_]*([a-z0-9]+(\\.|\\_*)?)+@([a-z][a-z0-9\\-]+(\\.|\\-*\\.))+[a-z]{2,6}$<br /><br /><br />Match characters A through Z but not B through D.<br />You can express that in Java by combining character classes, as follows:<br />[A-Z&amp;&amp;[^B-D]] <br /><br /><br /><br />Use the ^ metacharacter, which matches the position at the beginning of a string or a line<br />? Use the $ metacharacter, which matches the position at the end of a string or a line<br />? Use the \\&lt; and \\&gt; metacharacters to match the beginning and end of a word, respectively<br />? Use the \\b metacharacter, which matches a word boundary (which can occur at the beginning<br />of a word or at the end of a word)<br /><br /><br /><br />The \\&lt; Syntax <br /><br />The \\&lt; metacharacter identifies a word-boundary position occurring at the beginning of a word. It is<br />preceded by a character that is not an alphabetic character (for example, a space character) or is a<br />beginning-of-line position.<br /><br />The \\&gt;Syntax<br />The \\&gt; metacharacter signifies a word boundary that occurs at the end of a sequence of word characters.<br />In other words, it matches a word boundary that occurs at the end of a word.<br /><br /><br />The \\b Syntax<br />The \\b metacharacter can match a word boundary at either the beginning or end of a word<br /><br />The \\B Metacharacter<br />The \\B metacharacter is the opposite of the \\b metacharacter. The \\B metacharacter matches a position<br />that is not a word boundary.<br /><br />Parentheses inside regular expression patterns are used to group characters and remember<br />matched text.<br /><br />\\(&nbsp; \\) literal brackets<br />| = or (Doctor|Dr)\\&gt;.<br /><br /><br />Metacharacter Meaning<br />(?: ... ) Non-capturing grouping<br />(?= ... ) Positive lookahead<br />(?! ... ) Negative lookahead<br />(?&lt;= ... ) Positive lookbehind<br />(?&lt;! ... ) Negative lookbehind</p>', '2012-02-28 03:48:20'),
(6, 4, 'JS for Regex Page', 'js', '/*No Javascript here*/', '2012-02-28 03:47:53'),
(7, 5, 'Map Script', 'html', '<div id="Map" style="width: 100%; height: 600px;"> </div>\r\n<script type="text/javascript">\r\n$(function(){\r\n    function success(position) {\r\n      \r\n        var LAT = position.coords.latitude;\r\n        var LONG = position.coords.longitude;\r\n		$(''#Map'').append(''<p>Current Latitude: '' + LAT + ''<br/>Current Logitude: '' + LONG +''<br/><br/>Note* This may not display your exact location, but just your city. Works better on mobile devices</p>'');\r\n\r\n\r\n        var map  = ''<iframe style="width: 100%; height: 600px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.ca/maps?source=s_d&saddr='' + LAT +'',+'' + LONG +''&daddr=147+Wyndham+Street+N+,+Suite+206,+Guelph,+On,+N1H+4E9&ie=UTF8&t=h&output=embed"></iframe>'';\r\n        \r\n        $(''#Map'').append(map);\r\n        \r\n    }\r\n\r\n    function error(){\r\n        /*Error Code*/\r\n    }\r\n\r\n    function MakeMap(){\r\n        if (navigator.geolocation) {\r\n            navigator.geolocation.getCurrentPosition(success, error);\r\n        } else {\r\n\r\n		}\r\n    }\r\n\r\n    MakeMap();\r\n});\r\n</script>\r\n<div class="clear" style="padding-top:10px; clear:both">\r\n<h1>Code to Generate above </h1>\r\n<p>&lt;div id="Map" style="width: 100%; height: 600px;"&gt; &lt;/div&gt;<br />&lt;script type="text/javascript"&gt;<br />$(function(){<br />function success(position) {</p>\r\n<p>var LAT = position.coords.latitude;<br />var LONG = position.coords.longitude;<br />$(''#Map'').append(''&lt;p&gt;Current Latitude: '' + LAT + ''&lt;br/&gt;Current Logitude: '' + LONG +''&lt;br/&gt;&lt;br/&gt;Note* This may not display your exact location, but just your city. Works better on mobile devices&lt;/p&gt;'');</p>\r\n<p>var map = ''&lt;iframe style="width: 100%; height: 600px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.ca/maps?source=s_d&amp;saddr='' + LAT +'',+'' + LONG +''&amp;daddr=<b>**YOUR_DESTINATION_HERE**</b>&amp;ie=UTF8&amp;t=h&amp;output=embed"&gt;&lt;/iframe&gt;'';</p>\r\n<p>$(''#Map'').append(map);</p>\r\n<p>}</p>\r\n<p>function error(){<br />/*Error Code*/<br />}</p>\r\n<p>function MakeMap(){<br />if (navigator.geolocation) {<br />navigator.geolocation.getCurrentPosition(success, error);<br />} else {</p>\r\n<p>}<br />}</p>\r\n<p>MakeMap();<br />});<br />&lt;/script&gt;</p>\r\n<p><b>Note**</b> the destination should look like this: 147+Wyndham+Street+N+,+Suite+206,+Guelph,+On,+N1H+4E9</p>\r\n</div>', '2012-03-27 04:08:44'),
(9, 7, 'Page Not Found text', 'text', '<h2 style="text-align: center; margin: 20px 0px;">Sorry, the page you requested could not be found...</h2>', '2012-03-28 02:12:55'),
(11, 0, 'New Css', 'css', '/*New CsS test*/\r\n.newItem{\r\n  \r\nfont-weight: bold;	\r\n  \r\n}', '2012-03-28 02:03:28'),
(13, 0, 'Random Div', 'html', '<div>HTML</div>', '2012-03-27 02:07:02'),
(14, 8, 'jQuery Fun text', 'text', '<p><strong>An example of a simple jquery plugin</strong></p>', '2012-05-03 02:08:50'),
(15, 0, 'Jquery Fun', 'code', ' <script type="text/javascript">\r\n	$(function(){\r\n        $(''#AddModule'').click(function(event){\r\n            event.preventDefault();\r\n            if( !$(''#module_editor'').length ){\r\n                $(''#pageWrapper'').append(''<div id="module_editor"><iframe width="700" height="500"></iframe></div>'');\r\n            }\r\n            $(''#module_editor iframe'').attr(''src'' , "/admin/module_manage_module.php?type=" + $(''#addType'').val() + "&modId=-1&action=new" );\r\n            $(''#module_editor'').dialog({modal:false, title : "Add " + $(''#addType'').val() + " Module" , width: 800, height: 600, show: "blind", hide: "blind" }).bind(''dialogclose'', function(event){ closeIframe() }); \r\n        });\r\n    });\r\n\r\n   function closeIframe()/*used to close the iframe from within the iframe*/\r\n    {\r\n        $(''#module_editor'').dialog(''close'').remove();\r\n        return false;\r\n    }\r\n</script>\r\n   \r\n/*Use this event for the close button within the loaded page*/\r\n<a onclick="window.parent.closeIframe();" href="#">Close</a>', '2012-03-28 04:59:37'),
(17, 9, 'testtwo text', 'text', '', '2012-03-29 02:40:26'),
(20, 0, 'Sample Template for Jquery Plugin', 'code', '<script type="text/javascript">\r\n(function($){	  \r\n$.fn.fnName = function(options) // sure to set the function name\r\n	{	\r\n		\r\n		//set defaults for your function\r\n		var defaults = {\r\n		   height: "300",\r\n		   width: "300",\r\n		   \r\n		};\r\n		  \r\n		var options = $.extend(defaults, options);\r\n		//If there are one or more elements, return them  \r\n		return this.each(function(index) {\r\n			\r\n			\r\n		});// endeach function\r\n		  \r\n	};//end function sliderize\r\n})(jQuery);//end function decleration\r\n</script>', '2012-05-03 23:12:08'),
(22, 0, 'My Jquery image Resize (Scale) plugin', 'code', '(function($){\r\n$.fn.imgResize = function(options) \r\n{	\r\n	//function by Brendon Irwin | 2011 | http://bren1818.blogspot.com/ | bren1818@gmail.com\r\n	//Last update: May 24th 2011\r\n	\r\n	//set defaults\r\n	var defaults = {\r\n	   height: "300",\r\n	   width: "300",\r\n	   loadingImage: "images/loading.gif",\r\n	   failImage: "images/fail.png",\r\n	   autoCenterImage: "true"\r\n	};\r\n	  \r\n	var options = $.extend(defaults, options);\r\n	//If there are one or more elements, return them  \r\n	return this.each(function() {\r\n		$(this).wrap(''<div class="loader" style="height: '' + options.height + ''; width: '' + options.width +''; overflow: hidden; position: relative; background-image: url('' + options.loadingImage + ''); background-position: center; background-repeat: no-repeat; "/>'');	\r\n		$(this).css({''display'':''none''});\r\n		//load the image\r\n		$(this).load(function(){\r\n			$(this).css({''display'':''none''});\r\n			$(this).css({''background-image'' : ''url('' + options.loadingImage + '')'', ''background-position'' : ''center'', ''background-repeat'' : ''no-repeat''});\r\n		},function(){\r\n			//load complete, begin scaling\r\n			var maxWidth = options.width; 					// Max width for the image \r\n			var maxHeight = options.height;     			// Max height for the image\r\n			var ratio = 0;  								// Used for aspect ratio\r\n			var width = $(this).width();    				// Current image width\r\n			var height = $(this).height();  				// Current image height\r\n			\r\n			// Check if the current width is larger than the max\r\n			if(width > maxWidth){\r\n				ratio = maxWidth / width;   				// get ratio for scaling image\r\n				$(this).css("width", maxWidth); 			// Set new width\r\n				$(this).css("height", height * ratio);   	// Scale height based on ratio\r\n				height = height * ratio;    				// Reset height to match scaled image\r\n				width = width * ratio;    					// Reset width to match scaled image\r\n			}\r\n			\r\n			// Check if current height is larger than max\r\n			if(height > maxHeight){\r\n				ratio = maxHeight / height; 			// get ratio for scaling image\r\n				$(this).css("height", maxHeight);  		// Set new height\r\n				$(this).css("width", width * ratio);     // Scale width based on ratio\r\n				width = width * ratio;    				// Reset width to match scaled image\r\n			}\r\n			\r\n			if(height == maxHeight)\r\n			{\r\n				$(this).css("top", "0px");\r\n			}\r\n			\r\n			if(options.autoCenterImage == "true")\r\n			{\r\n				$(this).css(''position'', ''absolute'');\r\n				//center left\r\n				if( width  <= options.width){\r\n					var lef= ( (options.width- parseInt(width) ) / 2 ) + ''px''; \r\n					$(this).css(''left'', lef);\r\n				}else{\r\n					$(this).css(''left'', ''0px'');\r\n				}\r\n				\r\n				//center top\r\n				if( height < options.height) {\r\n					var top = ( (options.height - parseInt(height) ) / 2 ) + ''px'';  \r\n					$(this).css(''top'', top );\r\n				}\r\n				\r\n				if(height == options.height){\r\n					$(this).css(''top'', ''0px'' );\r\n				}	\r\n			}else{ //No Auto-Centering\r\n				var w, h;\r\n				h = $(this).height() + ''px'';\r\n				w = $(this).width() + ''px'';\r\n				$(this).parent().css(''height'' , h );//, $(this).width() + ''px'' });\r\n				$(this).parent().css(''width'' , w );\r\n			}\r\n			\r\n			//Fade image in\r\n			$(this).fadeIn(5000, function() { \r\n				$(this).css({''display'':''block''});\r\n				$(this).parent().css({''background-image'' : ''url(none)''});\r\n			});//end fadeIn function\r\n			\r\n		});// end load function\r\n\r\n		$(this).error(function() {\r\n			$(this).attr(''src'' , options.failImage);\r\n			$(this).load(function(){ $(this).css({''display'':''none''}); },function(){\r\n				//fade image in\r\n				$(this).fadeIn(5000, function() {\r\n					$(this).css({''display'':''block''});\r\n					$(this).css({''background-image'' : ''url(none)''});\r\n				});//end fadeIn\r\n			});//end load\r\n		});//end error\r\n\r\n	});// endeach function\r\n	  \r\n};//end function resize\r\n})(jQuery);//end function decleration', '2012-05-03 03:43:27'),
(23, 0, 'Image Resize Plugin', 'text', '<p>Here is an example of a plugin I authored to resize (Scale Images)</p>', '2012-05-03 03:49:33'),
(24, 0, 'Another Example (My Fader Plugin)', 'text', '<p>Here is another example of a custom plugin (My image Carousel Fader Plugin)</p>', '2012-05-03 04:15:00'),
(25, 0, 'jQuery Fader', 'code', '/*Go to the Next Slide*/\r\nfunction nextSlide(selector, speed){	\r\n	\r\n	disableButtons(selector);\r\n	if( $(''#'' + selector + '' .currentSlide'').hasClass(''lastSlide'') )\r\n	{\r\n		$(''#'' + selector + '' .currentSlide'').fadeOut(parseInt(speed), function() {\r\n    		$(this).removeClass(''currentSlide'');\r\n			$(this).css(''z-index'', 1);\r\n  		});\r\n		\r\n		$(''#'' + selector + '' .firstSlide'').fadeIn(parseInt(speed), function() {\r\n			$(this).addClass(''currentSlide'');\r\n			$(this).css(''z-index'', 10);\r\n			\r\n			\r\n      	});\r\n	  \r\n	}else{\r\n\r\n		var slideIndex = getCurrentSlide(selector);\r\n		$(''#'' + selector + '' .currentSlide'').fadeOut(parseInt(speed), function() {\r\n    		$(this).removeClass(''currentSlide'');\r\n			$(this).css(''z-index'', 1);\r\n  		});\r\n		\r\n		$(''#'' + selector + '' .slide_'' + (slideIndex + 1) ).fadeIn(parseInt(speed), function() {\r\n			$(this).addClass(''currentSlide'');\r\n			$(this).css(''z-index'', 10);\r\n			\r\n			enableButtons(selector);\r\n			\r\n      	});\r\n	}\r\n}\r\n/*Go to the Previous Slide*/\r\nfunction prevSlide (selector, speed){\r\n\r\n	disableButtons(selector);\r\n	if( $(''#'' + selector + '' .currentSlide'').hasClass(''firstSlide'') )\r\n	{\r\n		//fade out current slide, fade in next\r\n		$(''#'' + selector + '' .currentSlide'').fadeOut(parseInt(speed), function() {\r\n			$(this).removeClass(''currentSlide'');\r\n			$(this).css(''z-index'', 1);\r\n		});\r\n		\r\n		$(''#'' + selector + '' .lastSlide'').fadeIn(parseInt(speed), function() {\r\n			$(this).addClass(''currentSlide'');\r\n			$(this).css(''z-index'', 10);\r\n			\r\n			enableButtons(selector);			\r\n		});\r\n	  \r\n	}else{\r\n		//fade out slide\r\n		var slideIndex = getCurrentSlide(selector);\r\n		$(''#'' + selector + '' .currentSlide'').fadeOut(parseInt(speed), function() {\r\n			$(this).removeClass(''currentSlide'');\r\n			$(this).css(''z-index'', 1);\r\n		});\r\n		\r\n		$(''#'' + selector + '' .slide_'' + (slideIndex -1) ).fadeIn(parseInt(speed), function() {\r\n			$(this).addClass(''currentSlide'');\r\n			$(this).css(''z-index'', 10);\r\n			\r\n 			enableButtons(selector);\r\n			\r\n		});\r\n	}\r\n}\r\n\r\nfunction goToSlide(selector, slide, speed){\r\n \r\n	\r\n	if( $(''#'' + selector + '' .currentSlide'').hasClass(''slide_'' + slide) ){\r\n		//no need to shift\r\n	}else{\r\n		disableButtons(selector);\r\n		$(''#'' + selector + '' .currentSlide'').fadeOut(parseInt(speed), function() {\r\n			$(this).removeClass(''currentSlide'');\r\n			$(this).css(''z-index'', 1);\r\n		});\r\n		\r\n		$(''#'' + selector + '' .slide_'' + slide ).fadeIn(parseInt(speed), function() {\r\n			$(this).addClass(''currentSlide'');\r\n			$(this).css(''z-index'', 10);\r\n			 enableButtons(selector);\r\n		});\r\n		\r\n	}\r\n}\r\n\r\nfunction disableButtons(selector){\r\n	$(''#'' + selector).parent().find(''.gotoBtn'').each(function(index){\r\n		$(this).attr("disabled", true);\r\n	});\r\n	\r\n	$(''#'' + selector).parent().find(''.controlBox button'').each(function(index){\r\n		$(this).attr("disabled", true);\r\n	});\r\n	\r\n}\r\n\r\nfunction enableButtons(selector){\r\n	$(''#'' + selector).parent().find(''.gotoBtn'').each(function(index){\r\n		$(this).attr("disabled", false);\r\n	});\r\n	\r\n	$(''#'' + selector).parent().find(''.controlBox button'').each(function(index){\r\n		$(this).attr("disabled", false);\r\n	});\r\n}\r\n\r\nfunction getSlideNum(selector){\r\n	return $(''#'' + selector + '' .currentSlide'').length;\r\n}\r\n\r\nfunction getCurrentSlide(selector){\r\n	return $(''#'' + selector + '' .currentSlide'').index();\r\n}\r\n\r\n(function($){	  \r\n$.fn.fader = function(options) // sure to set the function name\r\n	{	\r\n		 //function by Brendon Irwin | 2011 | http://bren1818.blogspot.com/ | bren1818@gmail.com\r\n		 //Last update: May 24th 2011\r\n		var defaults = {\r\n		   height: "300",\r\n		   width: "300",\r\n		   speed: "5000",\r\n		   showControls: false,\r\n		   buttonControlforEach: false,\r\n		   autoScroll: true\r\n		};\r\n		  \r\n		var options = $.extend(defaults, options);\r\n		//If there are one or more elements, return them  \r\n		return this.each(function(index) {\r\n			var selector = "";\r\n			if( $(this).find(''ul'').attr(''id'') == undefined ){\r\n				if( $(this).attr(''id'') != ""){\r\n					$(this).find(''ul'').attr(''id'', ''faderbox_'' +  $(this).attr(''id'') + index);\r\n					selector = ''faderbox_'' +  $(this).attr(''id'') + index;\r\n				}else{\r\n					$(this).find(''ul'').attr(''id'', ''faderbox_'' + index);\r\n					selector = ''faderbox_'' +  index;\r\n				}\r\n			}else{\r\n				selector = 	$(this).find(''ul'').attr(''id'');\r\n			}\r\n			$(''#'' + selector).css({''height'' : options.height + ''px'', ''width'' : options.width + ''px'', ''padding'' : ''0px'', ''margin'': ''0px'', ''position'':''relative''});\r\n			\r\n			$(''#'' + selector).wrap(''<div id="container'' + selector + ''" class="fadeBoxContainer"/>'');\r\n			$(''#'' + selector).parent().css({''height'' : options.height + ''px'', ''width'' : options.width + ''px'', ''position'' : ''relative''});\r\n			if( options.showControls == true ){\r\n					$(''#container'' + selector).append(''<div class="controlBox"/>'');\r\n			}\r\n			\r\n			if( options.buttonControlforEach == true ){\r\n					$(''#container'' + selector).append(''<div class="buttoncontrolBox"/>'');\r\n			}\r\n			\r\n			$(''#'' + selector).css({''list-style-type'' : ''none''});\r\n			$(''#'' + selector).addClass(''imageFader'');\r\n			$(''#'' + selector + '' li:first'').addClass(''firstSlide'');\r\n			$(''#'' + selector + '' li:last'').addClass(''lastSlide'');\r\n			\r\n			$(''#'' + selector + '' li'').each(function(index){\r\n				$(this).css({''height'' : options.height + ''px'', ''width'' : options.width + ''px'', ''overflow'' : ''hidden''});\r\n				$(this).addClass(''imageFaderSlide'');\r\n				$(this).addClass(''slide_'' + index);\r\n				if(index != 0){\r\n					$(this).css({''display'' : ''none'', ''position'' : ''absolute'', ''z-index'' : ''1''});\r\n				}else{\r\n					$(this).addClass(''currentSlide'');\r\n				}\r\n				\r\n				if( options.buttonControlforEach == true )\r\n				{\r\n					$(''#container'' + selector + '' .buttoncontrolBox'').append(''<button class="gotoBtn goto'' + index +''">'' + index + ''</button>'');\r\n					$(''#container'' + selector + '' .buttoncontrolBox .goto'' + index).click(function(){\r\n						goToSlide( selector.toString(), index.toString(), parseInt(options.speed).toString() );\r\n					});\r\n				}\r\n			});//end each li\r\n			\r\n			if( options.showControls == true ){\r\n					$(''#container'' + selector + '' .controlBox'').append(''<button class="prevButton">Prev</button>'');\r\n					$(''#container'' + selector + '' .controlBox'').append(''<button class="nextButton">Next</button>'');\r\n					\r\n					$(''#container'' + selector + '' .controlBox .nextButton'').click(function(){\r\n						nextSlide( selector.toString(), parseInt(options.speed).toString() );\r\n					});\r\n					\r\n					$(''#container'' + selector + '' .controlBox .prevButton'').click(function(){\r\n						prevSlide( selector.toString(), parseInt(options.speed).toString() );\r\n					});\r\n			}\r\n			\r\n			\r\n			if(options.autoScroll == true){\r\n				window.setInterval( "nextSlide(''" + selector.toString() +"'', ''" + parseInt(options.speed).toString() +"'' )", parseInt(options.speed) );\r\n			}\r\n		});// endeach function\r\n	};//end function sliderize\r\n})(jQuery);//end function decleration', '2012-05-03 04:15:38'),
(27, 0, 'How to use Fader', 'code', '<html>\r\n<head>\r\n	<title>Bren''s image Plugin Test</title>\r\n	<script src="jquery-1.6.1.min.js"></script>\r\n	<script src="jquery.fader.js"></script>\r\n</head>\r\n<body>\r\n	<h1>\r\n		This is Brendon''s Image fader Javascript jQuery function.\r\n	</h1>\r\n    <style>\r\n	.imageFaderSlide{\r\n		position: absolute;	\r\n	}\r\n	.fadeBoxContainer{\r\n		position: relative;	\r\n	}\r\n	\r\n	#test, #test2, #test3, #test4{\r\n		width: 200px;\r\n		height: 100px;\r\n		margin-bottom: 80px;\r\n		display: block;\r\n		clear:both;	\r\n	}\r\n	\r\n	</style>\r\n	<script>\r\n	$(function(){\r\n		$(''.sampleImage'').css({ ''width'': ''200px'', ''height'': ''100px''});\r\n		$(''#test'').fader({ width: 200, height: 100, speed: "3000", showControls: true, autoScroll: true });\r\n		$(''#test2'').fader({ width: 200, height: 100, speed: "7000", showControls: true, autoScroll: false, buttonControlforEach: true });\r\n		$(''#test3'').fader({ width: 200, height: 100, speed: "5000", showControls: false, autoScroll: false, buttonControlforEach: true });\r\n		$(''#test4'').fader({ width: 200, height: 100, speed: "1000", showControls: false, autoScroll: true, buttonControlforEach: false });\r\n	});\r\n	</script>\r\n	\r\n    <h2>Fader with controls and auto scrolling</h2>\r\n	<div id="test">\r\n    <ul id="someId">\r\n    	<li><img class="sampleImage" src="http://www.foxy-shop.com/wp-content/uploads/2011/02/HamsterREX_468x3621.jpg"/></li>\r\n        <li><img class="sampleImage" src="http://www.picgifs.com/avatars/animals/hamster/avatars-hamster-598063.jpg"/></li>\r\n		<li><img class="sampleImage" src="http://images.tribe.net/tribe/upload/photo/27c/dff/27cdff26-a7bd-45d5-9f74-d71726ddee47"/></li>\r\n    </ul>\r\n	</div>\r\n    \r\n    <h2>Fader with controls, controls for each slide, and no auto scrolling</h2>\r\n    <div id="test2">\r\n    <ul>\r\n    	<li><img class="sampleImage" src="http://www.foxy-shop.com/wp-content/uploads/2011/02/HamsterREX_468x3621.jpg"/></li>\r\n        <li><img class="sampleImage" src="http://www.picgifs.com/avatars/animals/hamster/avatars-hamster-598063.jpg"/></li>\r\n		<li><img class="sampleImage" src="http://images.tribe.net/tribe/upload/photo/27c/dff/27cdff26-a7bd-45d5-9f74-d71726ddee47"/></li>\r\n    </ul>\r\n	</div>\r\n    \r\n    <h2>Fader with controls for each slide, and no auto scrolling</h2>\r\n    <div id="test3">\r\n    <ul>\r\n    	<li><img class="sampleImage" src="http://www.foxy-shop.com/wp-content/uploads/2011/02/HamsterREX_468x3621.jpg"/></li>\r\n        <li><img class="sampleImage" src="http://www.picgifs.com/avatars/animals/hamster/avatars-hamster-598063.jpg"/></li>\r\n		<li><img class="sampleImage" src="http://images.tribe.net/tribe/upload/photo/27c/dff/27cdff26-a7bd-45d5-9f74-d71726ddee47"/></li>\r\n    </ul>\r\n	</div>\r\n    \r\n    <h2>Fader with no controls, and auto scrolling</h2>\r\n    <div id="test4">\r\n    <ul>\r\n    	<li><img class="sampleImage" src="http://www.foxy-shop.com/wp-content/uploads/2011/02/HamsterREX_468x3621.jpg"/></li>\r\n        <li><img class="sampleImage" src="http://www.picgifs.com/avatars/animals/hamster/avatars-hamster-598063.jpg"/></li>\r\n		<li><img class="sampleImage" src="http://images.tribe.net/tribe/upload/photo/27c/dff/27cdff26-a7bd-45d5-9f74-d71726ddee47"/></li>\r\n    </ul>\r\n	</div>\r\n</body>\r\n</html>', '2012-05-03 04:20:35'),
(28, 9, 'JavaScript text', 'text', '<p>As many of you know, JQuery is awesome. If you dont know what JQuery is, you should definately check it out. I wont go much into jQuery for this page, but I am going to show how to accomplish some of the same tasks in javascript vs jQuery so you can compare the two.</p>', '2012-05-03 22:16:49'),
(29, 0, 'Javasccript Information', 'text', '<h2>Get an element by its id</h2>\r\n<p><strong>JavaScript</strong></p>\r\n<p>document.getElementById(''<strong>ElementID</strong>'')</p>\r\n<p>&nbsp;</p>\r\n<p><strong>JQuery</strong></p>\r\n<p>$(''#<strong>ElementID</strong>'')</p>\r\n<p>&nbsp;</p>\r\n<h2>Get element<span style="text-decoration: underline;">s</span>&nbsp;by their class</h2>\r\n<p><strong>JavaScript</strong></p>\r\n<p>function getElementsByClassName(classname, node) {</p>\r\n<p>if(!node) node = document.getElementsByTagName("body")[0]; //so we go through the whole html document</p>\r\n<p>var a = []; //declare the array for our elements</p>\r\n<p>var re = new RegExp(''\\\\b'' + classname + ''\\\\b''); //regular expression for the class name of the object</p>\r\n<p>var els = node.getElementsByTagName("*"); //get all of the elements</p>\r\n<p>for(var i=0,j=els.length; iif(re.test(els[i].className))a.push(els[i]); //go through all theelements and add it to an array</p>\r\n<p>return a;</p>\r\n<p>}</p>\r\n<p>&nbsp;</p>\r\n<p>a related function would be the ".getElementsByTagName(''<strong>element</strong>'');" - You''duse it like: document.getElementbyId("<strong>SomeDiv</strong>").getElementsByTagName("<strong>p</strong>"); --&gt; This would return all p''s in a div with the id of SomeDiv</p>\r\n<p>&nbsp;</p>\r\n<p><strong>JQuery</strong></p>\r\n<p>$(''.<strong>ElementClass</strong>'') -- returns a collection of items of that class</p>\r\n<p>$(''<strong>Element</strong>'') -- returns a collection of elements of that type</p>\r\n<p>&nbsp;</p>\r\n<h2>Get an element''s attribute</h2>\r\n<p><strong>JavaScript</strong></p>\r\n<p>//get</p>\r\n<p>var attr = document.getElementById(''<strong>ElementID</strong>'').getAttribute(''<strong>desired Attribute</strong>'');</p>\r\n<p>//set</p>\r\n<p>document.getElementById(''<strong>ElementID</strong>'').setAttribute(''<strong>desired Attribute</strong>'', ''newValue'');</p>\r\n<p>&nbsp;</p>\r\n<p><strong>JQuery</strong></p>\r\n<p>//get</p>\r\n<p>var attr = $(''<strong>element</strong>'').attr(''<strong>desired Attribute</strong>'')</p>\r\n<p>//set</p>\r\n<p>$(''<strong>element</strong>'').attr(''<strong>desired Attribute</strong>'', ''newValue'');</p>', '2012-05-03 23:10:28'),
(30, 10, 'CSS Selectors text', 'text', '<table>\r\n<tbody>\r\n<tr>\r\n<td><strong>Selector</strong></td>\r\n<td><strong>Meaning</strong></td>\r\n</tr>\r\n<tr>\r\n<td>*</td>\r\n<td>&nbsp;all elements</td>\r\n</tr>\r\n<tr>\r\n<td>div</td>\r\n<td>elements within div&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>div *</td>\r\n<td>all elements within div&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>div span</td>\r\n<td>span elements within div&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>dv, span</td>\r\n<td>div and span&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>div &gt; span</td>\r\n<td>div with child span&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>div + span&nbsp;</td>\r\n<td>span preceeded by div&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>.class&nbsp;</td>\r\n<td>elements with class&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;div.class</td>\r\n<td>divs with class&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>#itemid&nbsp;</td>\r\n<td>element with id of itemid&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>input[type=""]</td>\r\n<td>input with type of&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>a[attr]&nbsp;</td>\r\n<td>&nbsp;a with attribute attr</td>\r\n</tr>\r\n<tr>\r\n<td>a[attr=''x'']&nbsp;</td>\r\n<td>&nbsp;a when attr</td>\r\n</tr>\r\n<tr>\r\n<td>a[class~=''x'']&nbsp;</td>\r\n<td>a when class is a list containing &nbsp;x&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>a[lang|=''en'']&nbsp;</td>\r\n<td>a when lang begins "en"&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Pseudo-Selectors/Classes</p>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<td><strong>Selector</strong></td>\r\n<td><strong>Meaning</strong></td>\r\n</tr>\r\n<tr>\r\n<td>:first-child</td>\r\n<td>First child element</td>\r\n</tr>\r\n<tr>\r\n<td>:hover</td>\r\n<td>&nbsp;when mousing over element</td>\r\n</tr>\r\n<tr>\r\n<td>:active</td>\r\n<td>active element&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>:focus</td>\r\n<td>focussed element&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>:visited</td>\r\n<td>(can be used with :link) for styling visited/unvisited links&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>:before</td>\r\n<td>&nbsp;Before element</td>\r\n</tr>\r\n<tr>\r\n<td>:after</td>\r\n<td>After element&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2012-05-09 05:00:33'),
(32, 12, 'Local Storage and SQLite text', 'text', '<h1>Offline Storage</h1>\r\n<p>Using "<strong>window.localStorage</strong>" we can save data to local storage.</p>\r\n<p>Example: (assuming we have a inputbox/text area with the id: "inputData"</p>\r\n<p>window.<strong>localStorage</strong>.<strong>setItem</strong>(''textFieldValue'', document.getElementById(''inputData'').value);</p>\r\n<p>This would save our "inputData" to a local storage variable called ''textFieldValue''.</p>\r\n<p>We could retrieve this data and put it back into the text field like so:</p>\r\n<p>document.getElementById(''inputData'').value = window.localStorage.getItem(''textFieldValue'');</p>\r\n<p>The nice thing about this, is the value will be save if the page is refreshed, or the browser is closed/re-opened.</p>\r\n<hr />\r\n<h3>Local Storage databases!</h3>\r\n<p>SQL built into a page? Say What?! Cross browser support too?! Holy Smokes!</p>\r\n<p>So how does this work? well like this:</p>\r\n<p>Step 1: check if the page can support a database like so: <br /> try{<br /> &nbsp;&nbsp;&nbsp;if( !window.openDatabase){<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;window.alert("Your browser doesn''t support databases :(");<br /> &nbsp;&nbsp;&nbsp;}else{<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Our create code here..</strong><br /> &nbsp;&nbsp;&nbsp;}<br /> }catch(e){<br /> &nbsp;&nbsp;&nbsp;console.log("Some Error occurred :" + e);<br /> &nbsp;&nbsp;&nbsp;return;<br /> }</p>\r\n<p><strong>Note</strong>, the try/catch block must be in a function. In my example, I use the function name <strong>SQLiteTest()</strong></p>\r\n<p>So far pretty easy, we can detect if the local database is supported, and log an error (assuming the browser supports console.log :P), but what about creating the thing?</p>\r\n<p>Well, in the "<strong>Our code here</strong>" section we do something like this:</p>\r\n<p><strong>OurDb</strong> = openDatabase("OurDB", "1.0", "DB Display Name", 500000); //Short name, version, Display name, max db size in bytes</p>\r\n<p>doOperations(); //a function we can make to do stuff! like create tables.<br /><br />So what kind of operations would we do? How about creating a table?</p>\r\n<p>To create a table, we have to do a "transaction" on "<strong>OurDb</strong>" as we defined above. To do that, we do something like this:<br /><br /> <strong>OurDb.transaction(function(transaction)</strong>{<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("<strong>Our SQL Code here</strong>", [], nullDataHandler, errorHandler);<br /> });</p>\r\n<p>As you can see, we are using two functions: <strong>nullDataHandler</strong> and <strong>errorHandler</strong>... make them like such:</p>\r\n<p>function <strong>nullDataHandler()</strong>{<br /> &nbsp;&nbsp;&nbsp;console.log("Success, SQL Query OK");<br /> }</p>\r\n<p>function <strong>errorHandler(transaction, error)</strong>{<br /> &nbsp;&nbsp;&nbsp;if (error.code==1){<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// DB Table exists!<br /> &nbsp;&nbsp;&nbsp;} else {<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;console.log(''Error: '' + error.code);<br /> &nbsp;&nbsp;&nbsp;}<br /> &nbsp;&nbsp;&nbsp;return false;<br /> }</p>\r\n<p>For our SQL Code, we could write something like this:<br /> CREATE TABLE IF NOT EXISTS person_info(id INTEGER NOT NULL PRIMARY KEY, fname TEXT NOT NULL,lname TEXT NOT NULL,age INTEGER);</p>\r\n<p>Now, we should add some data Like so:<br /> OurDb.transaction(function(transaction){<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("INSERT INTO person_info(id, fname, lname, age) VALUES (?, ?, ?, ?)", [1, ''Bren'', ''Irwin'', 23]); <br /> });</p>\r\n<p>OurDb.transaction(function(transaction){<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("INSERT INTO person_info(id, fname, lname, age) VALUES (?, ?, ?, ?)", [2, ''David'', ''Irwin'', 21]); <br /> });</p>\r\n<p><strong>Great!</strong> we have a table, we have some data, now how about we do something with it?</p>\r\n<p><img src="../images/SQLLiteDB.png" alt="" /></p>\r\n<p>How about a <strong>Select Statement</strong>?</p>\r\n<p>Well, the SELECT is going to look alot like our other queries, here is an example:<br /> OurDb.transaction(function (transaction) {<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("SELECT * FROM person_info;", [], <strong>SQLSelectHandler</strong>, <strong>errorHandler</strong>);<br /> });<br /><br /> So as you can see, we''re using the typical transaction.executeSql function, however, in the data handler, we''ve specified a new function, the SQLSelectHandler, which we''ll have to setup.</p>\r\n<p>For this Example, I''ll keep it very simple and simply write results to the console. Here is the sample <strong>SQLSelectHandler</strong> code:<br /> <br /> function SQLSelectHandler(transaction, results){ &nbsp;&nbsp;&nbsp;for (var r=0; r &lt; results.rows.length; r++){ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;console.log( results.rows.item(r)[''fname''] + " " + results.rows.item(r)[''lname'']); &nbsp;&nbsp;&nbsp;} }</p>\r\n<p>Looking at the Console, we see this:<br /> &nbsp;&nbsp;&nbsp;Success, SQL Query OK<br /> &nbsp;&nbsp;&nbsp;Bren Irwin<br /> &nbsp;&nbsp;&nbsp;David Irwin<br /> <br /><br />We could do something much more complex, but lets keep it simple for the example.</p>\r\n<p>Awesome, so we''ve created a table, put some data in there, and even selected it, now how about modifying the data? Well thats simple too! How about we modify my "age" from 23 to 24 since it''s my birthday soon. Here''s how:<br /> <br /> OurDb.transaction(function (transaction) {<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("UPDATE person_info SET age=? WHERE fname = ''Bren''", [24]); });</p>\r\n<p>And thats it, another simple Query!</p>\r\n<p>If we wanted to Delete the DB for whatever reason that can be done easily too, like so:</p>\r\n<p>OurDb.transaction(function (transaction) {<br /> &nbsp;&nbsp;&nbsp;transaction.executeSql("DROP TABLE person_info;", [], nullDataHandler, errorHandler); <br /> });</p>\r\n<p>View the Demo here - (use developer tools to look at DB and see console for output): <a href="../SQLiteTest.html" target="_blank">Demo</a></p>', '2012-05-13 04:20:22'),
(33, 13, 'Herp Derp text', 'text', '<p>this is a herp</p>\r\n<p>this is a derp</p>', '2013-03-08 16:49:05'),
(34, 14, 'awesome text', 'text', '<p>this is awesome</p>', '2013-03-16 01:41:36'),
(35, 14, 'awesome js', 'js', 'window.alert("Im awesome");', '2013-03-16 01:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `page_content_types`
--

CREATE TABLE IF NOT EXISTS `page_content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `page_content_types`
--

INSERT INTO `page_content_types` (`id`, `type`, `Description`) VALUES
(1, 'text', 'Standard wysiwyg editor'),
(2, 'js', 'Javascript module (embedded in script tag, jquery included)'),
(3, 'css', 'css module (embedded in <style> tags)'),
(4, 'html', 'html block'),
(5, 'code', 'Generic box for displaying code');

-- --------------------------------------------------------

--
-- Table structure for table `stickynote`
--

CREATE TABLE IF NOT EXISTS `stickynote` (
  `id` int(1) NOT NULL,
  `Note_Text` longtext NOT NULL,
  `Last_Update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stickynote`
--

INSERT INTO `stickynote` (`id`, `Note_Text`, `Last_Update`) VALUES
(1, 'sticky%2520note%250A', '2014-03-21 01:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_file_thumbs`
--

CREATE TABLE IF NOT EXISTS `uploaded_file_thumbs` (
  `thumb_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(55) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_login`) VALUES
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2015-01-13 01:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_tracking`
--

CREATE TABLE IF NOT EXISTS `user_tracking` (
  `log_Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(55) NOT NULL,
  `current_Page` varchar(255) NOT NULL,
  `page_Referrer` varchar(255) NOT NULL,
  `next_Page` varchar(255) NOT NULL,
  `page_Entry` bigint(20) NOT NULL,
  `page_Exit` bigint(20) NOT NULL,
  `Page_Time` bigint(20) NOT NULL,
  PRIMARY KEY (`log_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
