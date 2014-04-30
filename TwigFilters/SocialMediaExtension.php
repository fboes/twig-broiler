<?php

namespace TwigFilters;

class SocialMediaExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('sm_facebook',        array($this, 'facebookUrl')),
			new \Twig_SimpleFilter('sm_facebook_iframe', array($this, 'facebookIframe')),
			new \Twig_SimpleFilter('sm_twitter',         array($this, 'twitterUrl')),
			new \Twig_SimpleFilter('sm_twitter_iframe',  array($this, 'twitterIframe')),
			new \Twig_SimpleFilter('sm_gplus',           array($this, 'googlePlusUrl')),
			new \Twig_SimpleFilter('sm_gplus_iframe',    array($this, 'googlePlusIframe')),
			new \Twig_SimpleFilter('sm_mail',            array($this, 'emailUrl')),
		);
	}

	/**
	 * Return Facebook Share URL for this page
	 * @param  string $url         [description]
	 * @return string [description]
	 */
	public function facebookUrl ($url) {
		return 'http://www.facebook.com/sharer.php?u='.rawurlencode($url);
	}

	/**
	 * Return iFrame URL with Facebook functionality for this page
	 * @param  string $url     [description]
	 * @param  string $locale  like 'en_US'
	 * @return string          [description]
	 */
	public function facebookIframe ($url, $locale = 'en_US') {
		return 'http://www.facebook.com/plugins/like.php?locale='.rawurlencode($locale).'&href='.rawurlencode($url).'&send=false&layout=button_count&width=120&show_faces=false&action=recommend&colorscheme=light&font&height=21';
	}

	/**
	 * Return Twitter Tweet URL for this page
	 * @param  string $description  [description]
	 * @param  string $url          [description]
	 * @return string [description]
	 */
	public function twitterUrl ($url, $description) {
		return 'https://twitter.com/intent/tweet?original_referer='.rawurlencode($url).'&source=tweetbutton&text'.rawurlencode($description).'&url='.rawurlencode($url);
	}

	/**
	 * Return iFrame URL with Twitter functionality for this page
	 * @param  [type] $description  [description]
	 * @param  string $url          [description]
	 * @param  string $language     like 'en'
	 * @return string [description]
	 */
	public function twitterIframe ($url, $description, $language = 'en') {
		return 'http://platform.twitter.com/widgets/tweet_button.html?url='.rawurlencode($url).'&counturl='.rawurlencode($url).'&text='.rawurlencode($description).'&count=horizontal&lang='.rawurlencode($language);
	}

	/**
	 * Return Google Plus Share URL for this page
	 * @param  string $url  [description]
	 * @return string       [description]
	 */
	public function googlePlusUrl ($url) {
		return 'https://plus.google.com/share?url='.rawurlencode($url);
	}

	/**
	 * Return iFrame URL with Google Plus functionality for this page
	 * @param  string $url         [description]
	 * @param  string $language    like 'en'
	 * @param  string $domain      [description]
	 * @return string [description]
	 */
	public function googlePlusIframe ($url, $language = 'en', $domain = NULL) {
		if (empty($domain)) {
			$domain = $this->getDomain($url);
		}
		return 'https://plusone.google.com/_/+1/fastbutton?url='.rawurlencode($url).'&size=medium&count=true&hl='.rawurlencode($language).'&jsh=m%3B%2F_%2Fapps-static%2F_%2Fjs%2Fgapi%2F__features__%2Frt%3Dj%2Fver%3DZRN-6HhYiow.de.%2Fsv%3D1%2Fam%3D!It_EKMXP3lKIo3Dfjw%2Fd%3D1%2F#id=I1_1331298342130&parent='.rawurlencode($domain).'&rpctoken=309731857&_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart';
	}

	/**
	 * Return URL to share this page via mail.
	 * @param  string $subject [description]
	 * @param  string $body    [description]
	 * @return string          [description]
	 */
	public function emailUrl ($subject, $body) {
		return 'mailto:?subject='.rawurlencode($subject).'&body='.rawurlencode($body);
	}


	protected function getDomain () {
		return preg_replace('#^[a-zA-z]+://([^/]+).*$#','$1',$this->url);
	}

	public function getName()
	{
		return 'social_media_extension';
	}
}