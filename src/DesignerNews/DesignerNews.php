<?php

/**
 * Designer News API PHP Class
 * API Documentation: http://developers.news.layervault.com/
 * Class Documentation: https://github.com/ghosh/PHP-DesignerNews-API
 *
 * @author Indrashish Ghosh
 * @since 25.02.2014
 * @copyright Indrashish Ghosh - 2014
 * @version 1.0
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace DesignerNews;

class DesignerNews
{

  /**
   * Access token returned by the service provider after a successful authentication.
   *
   * @var string
   * @access private
   */
  private $_accesstoken;


  /**
   * The api version segment to use. Defaults to v1.
   *
   * @var string
   * @access private
   */
  private $_apiVersionSegment  = "v1";


  /**
   * The api endpoint to use
   *
   * @var string
   * @access private
   */
  private $_apiEndpoint = "https://api-news.layervault.com";


  /**
   * HTTP user agent
   *
   * @var string
   * @access private
   */
  private $_userAgent  = "designer-news-api-php-wrapper";



  /**
   * Class constructor
   *
   * @param array  $config  Designer News API configuration data
   *
   * @return void
   * @throws Exception
   *
   * @access public
   */
  public function __construct($config)
  {
    if (empty($config['accessToken']))
    {
        throw new Exception("Error: __construct() - Configuration data is missing.");
    }

    $this->_accessToken  = $config['accessToken'];

    if (isset($config['apiVersionSegment'])){
      $this->_accessToken = $config['apiVersionSegment'];
    }

    if (isset($config['userAgent'])){
      $this->_accessToken = $config['userAgent'];
    }
  }


  /**
   * Returns details for the authorized user.
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function getUser()
  {
    return $this->_makeRequest('/me', 'GET');
  }


  /**
   * Returns details for a story specified by ID.
   *
   * @param  integer $id
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_ValidateID()
   */
  public function getStory($id)
  {
    $id = self::_validateID($id);
    return $this->_makeRequest(sprintf('/stories/%d', $id), 'GET');
  }



  /**
   * Returns a list of the top most stories.
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function getTopStories()
  {
    return $this->_makeRequest('/stories', 'GET');
  }


  /**
   * Returns a list of the most recent stories.
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function getRecentStories()
  {
    return $this->_makeRequest('/stories/recent', 'GET');
  }



  /**
   * Upvotes specified story and returns updated details.
   *
   * @param  integer $id
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_ValidateID()
   */
  public function upvoteStory($id)
  {
      $id = self::_validateID($id);
      return $this->_makeRequest(sprintf('/stories/%d/upvote', $id), 'POST');
  }


  /**
   * Comments on a particular story and returns it.
   *
   * @param  integer $id
   * @param  string $comment
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_formatComment()
   * @see DesignerNews::_ValidateID()
   */
  public function commentOnStory($id, $comment)
  {
      $id = self::_validateID($id);
      $comment = self::_formatComment($comment);

      return $this->_makeRequest(sprintf('/stories/%d/reply', $id), 'POST', null, $comment);
  }


  /**
   * Returns a set of results for a search query.
   *
   * @param  string $comment
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function searchForStory($queryString)
  {
    $params = array( "query" => $queryString );

    return $this->_makeRequest('/stories/search', 'GET', $params);
  }


  /**
   * Returns details for a comment specified by ID.
   *
   * @return object
   * @param integer $id
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_ValidateID()
   */
  public function getComment($id)
  {
      $id = self::_validateID($id);
      return $this->_makeRequest(sprintf('/comments/%d', $id), 'GET');
  }



  /**
   * Upvotes the specified comment and returns updated details.
   *
   * @return object
   * @param integer $id
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_ValidateID()
   */
  public function upvoteComment($id)
  {
      $id = self::_validateID($id);
      return $this->_makeRequest(sprintf('/comments/%d/upvote', $id), 'POST');
  }



  /**
   * Replies to a comment and returns it.
   *
   * @param  integer $id
   * @param  string $comment
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   * @see DesignerNews::_formatComment()
   * @see DesignerNews::_ValidateID()
   */
  public function replyToComment($id, $comment)
  {
      $id = self::_validateID($id);
      $comment = self::_formatComment($comment);

      return $this->_makeRequest(sprintf('/comments/%d/reply', $id), 'POST', null, $comment);
  }



  /**
   * Returns information for the current MOTD (message of the day).
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function getMOTD()
  {
    return $this->_makeRequest('/motd', 'GET');
  }


  /**
   * Upvotes the MOTD and returns updated details.
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function upvoteMOTD()
  {
    return $this->_makeRequest('/motd/upvote', 'POST');
  }


  /**
   * Downvotes the MOTD and returns updated details.
   *
   * @return object
   *
   * @access public
   * @see DesignerNews::_makeRequest()
   */
  public function downvoteMOTD()
  {
    return $this->_makeRequest('/motd/downvote', 'POST');
  }


  /**
   * Validates passed param to be numeric
   *
   * @param integer $id
   * @return integer $id
   * @throws Exception
   *
   * @access private
   */
  private static function _validateID($id)
  {
    if( !is_numeric($id) ) {
      throw new Exception('Error: The passed id is not an integer');
    }
    return $id;
  }


  /**
   * URL Encodes comment string
   *
   * @param string $comment
   * @return string $comment
   *
   * @access private
   */
  private static function _formatComment($comment)
  {
      $postData = array( 'comment[body]' => urlencode($comment) );

      $fields_string = null;
      foreach($postData as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }

      return rtrim($fields_string, '&');
  }

  /**
   * Modifies curl headers depending on call and makes a HTTP request.
   *
   * @param  string $path
   * @param  string $method
   * @param  array  $params
   * @param  array  $postData
   *
   * @return object
   * @throws Exception
   */
  protected function _makeRequest($path, $method = 'GET', $params = null, $postData = null)
  {

    $curl = curl_init();

    $url = $this->_apiEndpoint;
    $url .= "/api/";
    $url .= $this->_apiVersionSegment;
    $url .= $path;

    if (is_array($params)) {
        $url .= '?' . http_build_query($params, null, '&');
    }

    $curlHeader = array (
        "Accept: application/json",
        "Authorization: Bearer ".$this->_accessToken
    );

    if ($method == 'POST')
    {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        if($postData) { curl_setopt($curl, CURLOPT_POSTFIELDS, $postData); }
    }

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_VERBOSE        => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_URL            => $url,
        CURLOPT_HTTPHEADER     => $curlHeader,
        CURLOPT_USERAGENT      => $this->_userAgent,
    ));

    $result = curl_exec($curl);

    if ($result === false)
    {
        throw new Exception(curl_error($curl), curl_errno($curl));
    }

    $result = json_decode($result);

    return $result;
  }


}

?>
