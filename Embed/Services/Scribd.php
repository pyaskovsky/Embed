<?php
namespace Embed\Services;

use Embed\Url;
use Embed\Providers\OEmbed;

class Scribd extends Service {
	static public function create (Url $Url) {
		if (!$Url->match('http://www.scribd.com/doc/*')) {
			return false;
		}

		return new static(new OEmbed('http://www.scribd.com/services/oembed', $Url->getUrl()));
	}

	public function __construct (OEmbed $Provider) {
		parent::__construct($Provider);

		//Generate embed code
		if (!$this->Provider->isEmpty() && !$this->Provider->hasParameter('html')) {
			$embed_url = preg_replace('|^http://www\.scribd\.com/doc/([\d]+)/(.*)$|', 'http://www.scribd.com/embeds/$1/content', $Provider->getUrl());

			$Provider->setParameter('html', '<iframe src="'.$embed_url.'" scrolling="no" width="100%" height="600" frameborder="0"></iframe>');
		}
	}
}