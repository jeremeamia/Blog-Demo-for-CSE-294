<?php require 'markdown/markdown.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Markdown Web Service User Guide</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div class="wrapper">
<?php ob_start('Markdown'); ?>

# Markdown Web Service
## User Guide v0.1.0 by Jeremy Lindblom

***

### Introduction

The Markdown web service allows users to send content that has been written with Markdown syntax they want to have converted to HTML. Also, they can send HTML content to the service that they would like to be converted back into Markdown syntax. The web service uses two third-party libraries to perform these tasks. This service is for educational purposes only, and should only be used by ASU students in the CSE 294 LAMP development class.

### Information About Markdown

Markdown is:
> &ldquo;&hellip;a text-to-HTML conversion tool for web writers. Markdown allows you to write using an easy-to-read, easy-to-write plain text format, then convert it to structurally valid XHTML (or HTML).&rdquo;

To read more about Markdown and the Markdown syntax please visit [the Markdown website](http://daringfireball.net/projects/markdown/).

Also, please visit the websites for [Markdown PHP](http://michelf.com/projects/php-markdown/) and [Markdownify PHP](http://milianw.de/projects/markdownify/) to find out more about the third-party libraries used by this service.

### How to Use

#### The Request

This service requires arguments to be passed in via POST, so [the cURL library](http://php.net/manual/en/book.curl.php) is a good candidate to use for accessing the service. The request should be made to [http://webdevilaz.com/markdown_service/api.php](). The service requires 3 arguments to be passed in as part of the request:

* __user__ &ndash; This should be an md5 hash of your asu email address. You must make sure you have been added to the access list by emailing Jeremy Lindblom.
* __operation__ &ndash; This should either be set to "markdown" (Markdown &rarr; HTML) or "markdownify" (HTML &rarr; Markdown).
* __content__ &ndash; This should be a block of text that is either in Markdown or HTML form (depending on the operation).

##### Example cURL Request:

	$args = array(
		'user'		=> md5('firstname.lastname@asu.edu'),
		'operation'	=> 'markdown',
		'content'	=> $content
	);
	$curl = curl_init('http://webdevilaz.com/markdown_service/api.php');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_POST, TRUE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($args));
	$results = json_decode(curl_exec($curl), TRUE);
	curl_close($curl);

#### The Response

The response will be sent a JSON string. PHP's json_decode function is a very easy way to parse this result into an array. If you would like more information about JSON you should [search for it](http://lmgtfy.com/?q=JSON). The response will contain five items:

* __status__ &ndash; This will either be "success" or "error".
* __message__ &ndash; If there was an error, this will contain the error message.
* __result__ &ndash; This will contain your content after the service has either done Markdown or Markdownify. This will be empty if there was an error.
* __benchmark__ &ndash; This will contain the ammount of time the service took to perform its action.
* __timestamp__ &ndash; This will contain the time at which the service was run.

The following is a sample response in JSON format:

	{
		"status":		"error",
		"message":		"This service only accepts post requests.",
		"result":		"",
		"benchmark":	"116.92 ms",
		"timestamp":	"2010-02-03 18:28:22"
	}

### Final Thoughts

Good luck. Please contact Jeremy Lindblom if you have any trouble.

***

&copy;2010 Jeremy Lindblom

<?php ob_end_flush(); ?>
		</div>
	</body>
</html>

