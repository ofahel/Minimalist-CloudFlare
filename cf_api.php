<?php

class CloudFlareAPI
{
	private $email;
	private $auth_key;
	private $zone;

	//Class Constructor, store (email, auth_key and zone) on instantiation
	function __construct($email, $auth_key, $zone)
	{
		$this->email = $email;
		$this->auth_key = $auth_key;
		$this->zone = $zone;
	}

	//Function to set a new Zone
	function changeZone($zone)
	{
		$this->zone = $zone;
	}

	//Function that wrap CURL
	function CURL($api, $fields, $mode = "post")
	{

		$ch = curl_init();

		//Setup cURL data
		curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/' . $this->zone . '/' . $api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($mode == "post" || $mode == "put") {
			if ($mode == "post")
				curl_setopt($ch, CURLOPT_POST, 1);
			else
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

			curl_setopt($ch, CURLOPT_POSTFIELDS, (gettype($fields) == 'array') ? json_encode($fields) : $fields);
		} elseif ($mode == "delete") {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		}

		//CloudFlare API Headers
		$headers = array();
		$headers[] = 'X-Auth-Email: ' . $this->email;
		$headers[] = 'X-Auth-Key: ' . $this->auth_key;
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		//Execute cURL
		$result = curl_exec($ch);

		//Ternary return, when cURL execute success, return response
		return ((curl_errno($ch)) ? false : json_decode($result, true));
	}

	//Function to create new sub domain
	function createRecord($params)
	{
		//Build API Params
		$params = array(
			"type" => $params['type'],
			"name" => $params['name'],
			"content" => $params['content'],
			"ttl" => (isset($params['ttl'])) ? $params['ttl'] : 120,
			"priority" => (isset($params['priority'])) ? $params['priority'] : 10,
			"proxied" => (isset($params['proxied'])) ? $params['proxied'] : true
		);

		//Comunicte to CloudFlare API
		$result = $this->CURL('dns_records', $params);

		//Return JSON Object when success, false on fail (based on cURL execute)
		return (($result) ? $result : false);
	}

	function listRecords($filters = false)
	{
		$url_params = '';
		if ($filters) {
			if (isset($filters['type']))
				$url_params .= "&type=" . $filters['type'];

			if (isset($filters['name']))
				$url_params .= "&name=" . $filters['name'];

			if (isset($filters['proxied']))
				$url_params .= "&proxied=" . $filters['proxied'];

			if (isset($filters['page']))
				$url_params .= "&page=" . $filters['page'];

			if (isset($filters['order']))
				$url_params .= "&order=" . $filters['order'];

			if (isset($filters['content']))
				$url_params .= "&content=" . $filters['content'];
		}

		return $this->CURL('dns_records?per_page=100&direction=desc&match=all' . $url_params, "", "get");
	}

	function updateRecord($record_id, $params)
	{
		//Build API Params
		$params = array(
			"type" => $params['type'],
			"name" => $params['name'],
			"content" => $params['content'],
			"ttl" => (isset($params['ttl'])) ? $params['ttl'] : 120,
			"proxied" => (isset($params['proxied'])) ? $params['proxied'] : true
		);

		//Comunicte to CloudFlare API
		$result = $this->CURL('dns_records/' . $record_id, $params, "put");

		//Return JSON Object when success, false on fail (based on cURL execute)
		return (($result) ? $result : false);
	}

	function deleteRecord($record_id)
	{
		return $this->CURL('dns_records/' . $record_id, "", "delete");
	}
}
