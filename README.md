# Designer News PHP API

## About

A simple php wrapper for the Designer News API.


## Requirements

* PHP 5.2.x or higher
* cURL
* A valid Designer News Access Token

## Getting Started

This library assumes that you have already acquired a valid Access Token using  your preferred oAuth library.

>Please note that as of this writing, the Designer News API only supports ClientCredentials and Password Grant Types.

### Instantiating the class

	<?php
	    require_once ‘src/DesignerNews.php’;

		$config = array(
			"accessToken"  => “YOUR_ACCESS_TOKEN”
		);

		try {
			$DN = new DesignerNews($config);
		} catch(Exception $e){
			echo $e->getMessage();
		}

	?>

This creates a new instance of the Designer News API class and assigns it to the `$DN` handle. Its recommended to wrap this in a `try`/`catch` block to handle any errors that may arise.

### Configuration Options
* `accessToken` *Required* - This is the access token which would be provided to you by your oauth library
* `apiVersionSegment` *Optional* - The current api version. Will default to `v1`
* `userAgent` *Optional* - The user agent for the application. Designer News recommends setting it to your email address so that you can be contacted if any misuse of data is detected. Defaults to `designer-news-api-php-wrapper`

## Available Methods

The wrapper includes convenient methods used to perform HTTP requests on behalf of the authenticated user. Below you will find a list of all available methods along with a short description.

### User
	$DN->me();

### Stories
	$DN->getStory($id);
	$DN->upvoteStory($id);
	$DN->commentOnStory($id, $comment);
	$DN->getTopStories();
	$DN->getRecentStories();
	$DN->searchForStory($queryString);

### Comments
	$DN->getComment($id);
	$DN->upvoteComment($id);
	$DN->replyToComment($id, $reply);

### MOTD (Message of the day)
	$DN->getMOTD();
	$DN->upvoteMOTD();
	$DN->downvoteMOTD();


## Response Type
All responses from the Designer News API PHP Wrapper are returned as PHP objects, so you can act on properties directly.

## Road Map

In the future I hope to add the following functionality to the wrapper:

* Better support for exceptions
* Built in oath client

## Feedback and Bugs

Feel free to open a [new issue](https://github.com/Ghosh/DesignerNews-PHP-API/issues) here on github for any bug you may have come across or a feature which you would like added.

## History

##### Designer News 1.0 - 20/11/2011
* `release` - Initial Release

## License
Copyright (c) 2014 Indrashish Ghosh

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.