# Designer News PHP API

## About

A simple php wrapper for the Designer News API. Thats it.


## Requirements

* PHP 5.2.x or higher
* cURL
* A valid Designer News Access Token


## oAuth 2
This library assumes that you have already acquired a valid Access Token using your preferred oAuth library.

>Please note that as of this writing, the Designer News API only supports ClientCredentials and Password Grant Types.

## Getting Started
You can either download the latest version from the repo, or alternatively install it as a dependency with Composer.

### Installing with Composer
```json
{
    "require": {
        "ghosh/designernews-php-api": "1.*"
    }
}
```

Then run `composer.phar install` from your command line in your application root folder.

### Instantiating the class
```php
$config = array(
	"accessToken"  => "YOUR_ACCESS_TOKEN"
);

try
{
	$DN = new DesignerNews($config);
}
catch (Exception $e)
{
	echo $e->getMessage();
}
```


This creates a new instance of the Designer News API class and assigns it to the `$DN` handle. Its recommended to wrap this in a `try`/`catch` block to handle any errors that may arise.

### Configuration Options
* `accessToken` *Required* - This is the access token which would be provided to you by your oauth library
* `apiVersionSegment` *Optional* - The current api version. Will default to `v1`
* `userAgent` *Optional* - The user agent for the application. Designer News recommends setting it to your email address so that you can be contacted if any misuse of data is detected. Defaults to `designer-news-api-php-wrapper`

## Available Methods

The wrapper includes convenient methods used to perform HTTP requests on behalf of the authenticated user. Below you will find a list of all available methods.

### User
```php
$DN->me();
```

### Stories
```php
$DN->getStory($id);
$DN->upvoteStory($id);
$DN->commentOnStory($id, $comment);
$DN->getTopStories();
$DN->getRecentStories();
$DN->searchForStory($queryString);
```

### Comments
```php
$DN->getComment($id);
$DN->upvoteComment($id);
$DN->replyToComment($id, $reply);
```

### MOTD (Message of the day)
```php
$DN->getMOTD();
$DN->upvoteMOTD();
$DN->downvoteMOTD();
```


## Response Type
All responses from the Designer News API PHP Wrapper are returned as PHP objects.

## Road Map

In the near future I hope to add the following functionality to the wrapper:

* ~~Composer Support~~ (Added in v1.0)
* More detailed exception handling
* Built in oath client

## Feedback and Bugs

Feel free to open a [new issue](https://github.com/Ghosh/DesignerNews-PHP-API/issues) here on github for any bug you may have come across or a feature which you would like added. Pull requests are most welcomed.

## History
##### Designer News 1.0 - 21/02/2014
* `release` - Initial Public Release
* `feature` - Added Packagist support

##### Designer News 0.5 - 20/02/2014
* `release` - Public Beta Release
