<?php

namespace App\Http\Middleware;
/**
 * Copyright JBA Network, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * See http://www.mynewsletterbuilder.com/api/
 * $Id: MnbApi.class.php 67103 2011-07-17 14:02:55Z jasonbar $
 */

// =(
define('_MNB_MAGIC_QUOTES', ini_get("magic_quotes_runtime"));

class MnbApi
{
	public $version = '1.0.2';
	public $build   = '$Rev: 67103 $';
	public $errno   = '';
	public $errstr  = '';

	/**
	 * The API Key used to validate the request
	 */
	protected $api_key = '';

	/**
	 * API Host URL target
	 */
	protected $api_host = 'api.mynewsletterbuilder.com';

	/**
	 * Server request timeout [300]
	 */
	protected $timeout = 300;

	/**
	 * Use a secure connection (SSL/TLS) [TRUE]
	 */
	protected $secure = FALSE;

	/**
	 * Error codes
	 */
	public static $E_CONNECT = 1;
	public static $E_RESPONSE = 2;
	public static $E_TIMEOUT = 3;
	public static $E_UNKNOWN = 4;

	/**
	 * __construct()
	 * @param string $api_key An API Key to authenticate the request with.
	 * @param boolean $secure Optional, force secure connection
	 */
	public function __construct($api_key, $secure = FALSE)
	{
		$this->api_key = $api_key;
		$this->secure = (bool)$secure;
	}

	public function __destruct() {}

	public function SetTimeout($secs = 300)
	{
		$secs = (int)$secs;

		if ($secs > 0)
			$this->timeout = $secs;

		return TRUE;
	}

	public function GetTimeout()
	{
		return $this->timeout;
	}

	public function hasError()
	{
		return !empty($this->errno);
	}

	public function getErrorCode()
	{
		return $this->errno;
	}

	public function getErrorMessage()
	{
		return $this->errstr;
	}

	public function UseSecure($secure = FALSE)
	{
		if ($secure === TRUE)
			$this->secure = TRUE;
		else
			$this->secure = FALSE;
	}

    public function Campaigns($filters = array())
    {
		$params = array(
			'filters' => $filters
		);

		return $this->Execute('Campaigns', $params);
	}

	public function CampaignDetails($id)
	{
		$params = array(
			'id' => $id
		);

		return $this->Execute('CampaignDetails', $params);
	}

	public function CampaignCreate($name, $subject, $from, $reply, $html, $text = '', $link_tracking = TRUE, $gat = FALSE)
	{
		$params = array(
			'name' => $name,
			'subject' => $subject,
			'from' => $from,
			'reply' => $reply,
			'html' => $html,
			'text' => $text,
			'link_tracking' => $link_tracking,
			'gat' => $gat
		);

		return $this->Execute('CampaignCreate', $params);
	}

	public function CampaignUpdate($id, $details)
	{
		$params = array(
			'id' => $id,
			'details' => $details
		);

		return $this->Execute('CampaignUpdate', $params);
	}

	public function CampaignCopy($id, $name)
	{
		$params = array(
			'id' => $id,
			'name' => $name
		);

		return $this->Execute('CampaignCopy', $params);
	}

	public function CampaignDelete($id)
	{
		$params = array(
			'id' => $id
		);

		return $this->Execute('CampaignDelete', $params);
	}

	public function CampaignSchedule($id, $when, $lists, $smart = FALSE, $confirmed = FALSE)
	{
		$params = array(
			'id' => $id,
			'when' => $when,
			'lists' => $lists,
			'smart' => $smart,
			'confirmed' => $confirmed
		);

		return $this->Execute('CampaignSchedule', $params);
	}

	public function CampaignStats($id)
	{
		$params = array(
			'id' => $id
		);

		return $this->Execute('CampaignStats', $params);
	}

	public function CampaignRecipients($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignRecipients', $params);
	}

	public function CampaignOpens($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignOpens', $params);
	}

	public function CampaignSubscribes($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignSubscribes', $params);
	}

	public function CampaignUnsubscribes($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignUnsubscribes', $params);
	}

	public function CampaignBounces($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignBounces', $params);
	}

	public function CampaignComplaints($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignComplaints', $params);
	}

	public function CampaignUrls($id)
	{
		$params = array(
			'id' => $id
		);

		return $this->Execute('CampaignUrls', $params);
	}

	public function CampaignClicks($id, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignClicks', $params);
	}

	public function CampaignClickDetails($id, $url_id = 0, $page = 0, $limit = 1000)
	{
		$params = array(
			'id' => $id,
			'url_id' => $url_id,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('CampaignClickDetails', $params);
	}

	public function Lists()
	{
		return $this->Execute('Lists', array());
	}

	public function ListDetails($id)
	{
		$params = array(
			'id' => $id
		);

		return $this->Execute('ListDetails', $params);
	}

	public function ListCreate($name, $description = '', $visible = FALSE, $default = FALSE)
	{
		$params = array(
			'name' => $name,
			'description' => $description,
			'visible' => $visible,
			'default' => $default
		);

		return $this->Execute('ListCreate', $params);
	}

	public function ListUpdate($id, $name = '', $deails)
	{
		$params = array(
			'id' => $id,
			'details' => $details
		);

		return $this->Execute('ListUpdate', $params);
	}

	public function ListDelete($id, $delete_subs = FALSE)
	{
		$params = array(
			'id' => $id,
			'delete_subs' => $delete_subs
		);

		return $this->Execute('ListDelete', $params);
	}

	public function Subscribers($statuses, $lists, $page = 0, $limit = 1000)
	{
		$params = array(
			'statuses' => $statuses,
			'lists' => $lists,
			'page' => $page,
			'limit' => $limit
		);

		return $this->Execute('Subscribers', $params);
	}

	public function SubscriberDetails($id_or_email)
	{
		$params = array(
			'id_or_email' => $id_or_email
		);

		return $this->Execute('SubscriberDetails', $params);
	}

	public function SubscriberUpdate($id_or_email, $details, $lists)
	{
		$params = array(
			'id_or_email' => $id_or_email,
			'details' => $details,
			'lists' => $lists
		);

		return $this->Execute('SubscriberUpdate', $params);
	}

	public function Subscribe($details, $lists, $skip_opt_in = FALSE, $update_existing = TRUE)
	{
		$params = array(
			'details' => $details,
			'lists' => $lists,
			'skip_opt_in' => $skip_opt_in,
			'update_existing' => $update_existing
		);

		return $this->Execute('Subscribe', $params);
	}

	public function SubscribeBatch($subscribers, $lists, $skip_opt_in = FALSE, $update_existing = TRUE)
	{
		$params = array(
			'subscribers' => $subscribers,
			'lists' => $lists,
			'skip_opt_in' => $skip_opt_in,
			'update_existing' => $update_existing
		);

		return $this->Execute('SubscribeBatch', $params);
	}

	public function SubscriberUnsubscribe($id_or_email)
	{
		$params = array(
			'id_or_email' => $id_or_email
		);

		return $this->Execute('SubscriberUnsubscribe', $params);
	}

	public function SubscriberUnsubscribeBatch($ids_or_emails)
	{
		$params = array(
			'ids_or_emails' => $ids_or_emails
		);

		return $this->Execute('SubscriberUnsubscribeBatch', $params);
	}

	public function SubscriberDelete($id_or_email)
	{
		$params = array(
			'id_or_email' => $id_or_email
		);

		return $this->Execute('SubscriberDelete', $params);
	}

	public function SubscriberDeleteBatch($ids_or_emails)
	{
		$params = array(
			'ids_or_emails' => $ids_or_emails
		);

		return $this->Execute('SubscriberDeleteBatch', $params);
	}

	public function AccountDetails()
	{
		$params = array();

		return $this->Execute('AccountDetails', $params);
	}

	public function AccountKeys($username, $password, $disabled = FALSE)
	{
		$params = array(
			'username' => $username,
			'password' => $password,
			'disabled' => $disabled
		);

		return $this->Execute('AccountKeys', $params);
	}

	public function AccountKeyCreate($username, $password)
	{
		$params = array(
			'username' => $username,
			'password' => $password
		);

		return $this->Execute('AccountKeyCreate', $params);
	}

	public function AccountKeyEnable($username, $password, $id_or_key)
	{
		$params = array(
			'username' => $username,
			'password' => $password,
			'id_or_key' => $id_or_key
		);

		return $this->Execute('AccountKeyEnable', $params);
	}

	public function AccountKeyDisable($username, $password, $id_or_key)
	{
		$params = array(
			'username' => $username,
			'password' => $password,
			'id_or_key' => $id_or_key
		);

		return $this->Execute('AccountKeyDisable', $params);
	}

	/**
	 * Test server response
	 * @param string String to echo
	 * @return string
	 */
	public function HelloWorld($val = "Hello, World!")
	{
		$params = array('val' => $val);

		return $this->Execute('HelloWorld', $params);
	}

	/**
	 * Connect to remote server and handle response.
	 * @param string $method Action to invoke
	 * @param mixed $params Parameters required for $method
	 * @return mixed Server response, FALSE on error.
	 */
	protected function Execute($method, $params = array())
	{
		$this->errno = '';
		$this->errstr = '';
		$params['api_key'] = $this->api_key;
		$query_data = http_build_query($params);

		$request = "POST /" . $this->version . "/" . $method . "/php HTTP/1.1\r\n"
				 . "Host: " . $this->api_host . "\r\n"
				 . "User-Agent: MNB_API PHP " . $this->version . "/" . $this->build . "\r\n"
				 . "Content-type: application/x-www-form-urlencoded; charset=\"utf-8\"\r\n"
				 . "Content-length: " . strlen($query_data) . "\r\n"
				 . "Connection: close\r\n\r\n"
				 . $query_data;

		//if ($this->secure)
			//$sp = fsockopen('ssl://' . $this->api_host, 443, $errno, $errstr, 30);
		//else
			$sp = fsockopen($this->api_host, 80, $errno, $errstr, 30);

		if (!$sp)
		{
			$this->errno = self::$E_CONNECT;
			$this->errstr = "Failed connecting. Error: $errno, $errstr";

			return FALSE;
		}

		stream_set_timeout($sp, $this->timeout);
		fwrite($sp, $request);

		$response = '';

		while (!feof($sp))
			$response .= fread($sp, 8192);

		$meta = stream_get_meta_data($sp);

		if ($meta['timed_out'])
		{
			$this->errno = self::$E_TIMEOUT;
			$this->errstr = "The socket timed out. Try a larger timeout? (current: $this->timeout)";

			return FALSE;
		}

		if (_MNB_MAGIC_QUOTES)
			$response = stripslashes($response);

		$response = explode("\r\n\r\n", $response, 2);
		$data = unserialize($response[1]);

		if ($data === FALSE)
		{
			$data = array(
				'errno' => self::$E_RESPONSE,
				'errstr' => 'Unexpected response, received: ' . $response[1]
			);
		}

		// An error from the server will match this format.
		if (is_array($data) && isset($data['errstr']))
		{
			$this->errno = $data['errno'];
			$this->errstr = $data['errstr'];

			return FALSE;
		}

		return $data;
	}
}
