<?php

class RegisterAjax
{

  /**
   * Private class vars
   *
   * @var $nonce string
   * @var $post array
   */
  private $nonce, $post, $errors;

  /**
   * Constructor
   */
  function __construct()
  {
    $this->load();
    $this->setErrors();
  }

  /**
   * Loads our hooks/filters/actions
   *
   * @return void
   */
  private function load()
  {
    add_action('wp_ajax_register', array(&$this, 'register'));
    add_action('wp_ajax_nopriv_register', array(&$this, 'register'));
  }

  /**
   * Sets our class array of errors
   *
   * @return void
   */
  private function setErrors()
  {
    $this->errors = (object) array(
      'nonce'   => 'Nonce check cannot fail.',
      'spam'    => 'Failed spam check.',
      'fields'  => 'Not all required fields were submitted.',
      'no-post' => 'No post was made.',
      'email'   => 'Your email is not valid',
      'error'   => 'Something went wrong, please try again',
      'success' => 'Post completed successfully.',
    );
  }

  /**
   * Loads on the add_action for admin_ajaax, acts a controller for the post
   *
   * @return exit(json)
   */
  public function register()
  {
    $this->nonce = isset($_POST['nonce']) ? $_POST['nonce'] : false;
    $this->post  = isset($_POST['post']) ? $this->setPostData($_POST['post']) : false;

    if(wp_verify_nonce($this->nonce, 'register') !== false) {

      $response = $this->postEndpoint('form', 'jetstashForm', 'https://api.jetstash.com/v1/form/submit');

      if(!$response->success) {
        $this->ajaxResponse('error', $this->errors->error, $this->post, $response);
      } else {
        // $this->postGJForms();
        $this->postEndpoint('form_tools_form_id', 'gjForm', 'https://gjforms.com/process.php');
        $this->ajaxResponse('success', $this->errors->success, $this->post, $response);
      }

    } else {
      $this->ajaxResponse('error', $this->errors->nonce);
    }
  }

  /**
   * Sets our post data to the class var
   *
   * @param string
   *
   * @return array
   */
  private function setPostData($post)
  {
    parse_str($post, $data);

    // Just a little spam trap with a hidden field
    if(isset($data['email_2'])) {
      if(!empty($data["email_2"])) {
        $this->ajaxResponse('error', $this->errors->spam);
      }
      unset($data['email_2']);
    }

    // Test our email address for validity
    if(isset($data['email'])) {
      if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->ajaxResponse('error', $this->errors->email);
      }
    }

    return $data;
  }

  /**
   * Posts to an endpoint
   *
   * @return object
   */
  private function postEndpoint($formIDKey, $formIDValue, $endpoint)
  {
    $data = $this->post;
    $data[$formIDKey] = $data[$formIDValue];

    // Make sure we aren't sending any nested arrays as field data
    foreach($data as $key=>&$value) {
      if(is_array($value)) {
        $value = implode(",", $value);
      }
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:6.0.2) Gecko/20100101 Firefox/6.0.2");
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, FALSE);
    $result = curl_exec($curl);

    curl_close($curl);
    return json_decode($result);
  }

  /**
   * Sends the ajax response
   *
   * @param string, string, string, string
   *
   * @return exit(array)
   */
  private function ajaxResponse($status, $message, $data = null, $response = null)
  {
    $response = array(
      'status'   => $status,
      'message'  => $message,
      'data'     => $data,
      'response' => $response
    );
    $output = json_encode($response);
    exit($output);
  }

}

new RegisterAjax();
