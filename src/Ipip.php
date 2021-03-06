<?php

namespace Zimutech;

class Ipip
{
	private $token;
	
	public function __construct(string $token)
	{
		if($this->token === null) {
			$this->token = $token;
		}
	}
	
	public function getRegionId(string $ip = null) : ?string
	{
		if($ip === null) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$url = 'http://ipapi.ipip.net/find?addr=' . $ip;
		$data = json_decode($this->request($url));
		
		if($data->ret === 'ok' && $data->data[0] === '中国') {
			return $data->data[9];
		} else {
			return '000000'; // 000000代表海外
		}
	}
	
	private function request(string $url) : string
	{
		$header = ['Token: ' . $this->token, 'User-Agent: Zimutech/1.0.0'];
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}