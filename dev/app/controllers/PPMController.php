<?php

class PPMController extends \BaseController {

	public function display() {
		$r = new HttpRequest('http://d.livescore.in/x/feed/f_1_0_0_en_4?=', HttpRequest::METH_GET);

		$r->setHeaders(array('Cookie' => '__gads=ID=70bd36e9c953ec03:T=1397766055:S=ALNI_MZmbvyZKuq3kcX3nRxp2w2uJvGBkA; __utma=94122624.1486631050.1392756190.1398087923.1398087925.17; __utmz=94122624.1398087923.16.15.utmcsr=betexplorer.com|utmccn=(referral)|utmcmd=referral|utmcct=/livescore.php')); 
		
		return $r->send();

		$response = gzinflate(substr($response, 10)); 



		// return View::make('ppm');
	}

}
