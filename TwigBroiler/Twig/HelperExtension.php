<?php

namespace TwigBrolier\Twig;

class HelperExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('full_url',      array($this, 'fullUrlFilter')),
			new \Twig_SimpleFilter('full_url_http', array($this, 'fullUrlFilterHTTP')),
			new \Twig_SimpleFilter('number_format', array($this, 'numberFormatFilter')),
			new \Twig_SimpleFilter('typo',          array($this, 'typoFilter')),
			new \Twig_SimpleFilter('shorten',       array($this, 'shortenFilter')),
		);
	}

	/**
	 * Shorten sentences to maximum number of words
	 * @param  string  $str      String to shorten
	 * @param  integer $maxChars Maximum number of characters
	 * @param  string  $replace  If $str is longer this string will be appended
	 * @return string            [description]
	 */
	public function shortenFilter($str, $maxChars = 160, $replace = '…')
	{
		if (!is_scalar($str)) {
			throw new \Exception('String expected in Twig fullUrlFilter');
		}
		if (mb_strlen($str) > $maxChars) {
			$str = trim(mb_ereg_replace('^(.{0,'.((int)$maxChars-2).'}\W)(.*)$','\1',$str)).$replace;
		}
		return $str;
	}

	/**
	 * Will generate a full URL from any partial URL
	 * @param  string  $string       [description]
	 * @param  string  $currentUrl   [description]
	 * @param  bool    $autoProtocol if set to false will set '//' as protocol. Otherwise will gues protocol from current URL
	 * @return string  [description]
	 */
	public function fullUrlFilter($string, $currentUrl = '', $autoProtocol = true)
	{
		if (!is_scalar($string)) {
			throw new \Exception('String expected in Twig fullUrlFilter');
		}
		$protocol = '//';
		if (!$autoProtocol) {
			if (!empty($_SERVER['HTTPS'])) {
				$protocol = 'https://';
			} elseif (!empty($_SERVER['REQUEST_SCHEME'])) {
				$protocol = $_SERVER['REQUEST_SCHEME'] . '://';
			} else {
				$protocol = 'http://';
			}
		}
		$string = (string)$string;
		if (!preg_match('#^([a-z]+\:)?//#i', $string)) {
			if (empty($currentUrl)) {
				$currentUrl =  !empty($_SERVER['HTTP_HOST'])
					? $protocol . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['SCRIPT_NAME']
					: $protocol . 'localhost/'
				;
			}
			if (preg_match('#^(.*?//[^/]+)/(.*)(/.*)?$#', $currentUrl, $matches)) {
				$domain   = $matches[1];
				$path     = $matches[2];
				$string = (strpos($string, '/') === 0)
					? $domain . $string
					: $domain . $path . '/' . $string
				;
			}
			$string = preg_replace('#/app.php#', '', $string);
		}
		return $string;
	}

	/**
	 * Will generate a full URL from any partial URL
	 * @param  string  $string     [description]
	 * @param  string  $currentUrl [description]
	 * @return string  [description]
	 */
	public function fullUrlFilterHTTP($string, $currentUrl = '')
	{
		return $this->fullUrlFilter($string, $currentUrl, false);
	}


	/**
	 * Convert certain typografical stuff into better typografical stuff
	 * See http://de.wikipedia.org/wiki/Anf%C3%BChrungszeichen
	 * @param  string  $str            [description]
	 * @param  boolean withHyphenation [description]
	 * @param  string  $langCode       According to ISO 639-1 2ALPHA, use {{ app.request.locale }}
	 * @return string                  [description]
	 */
	public function typoFilter ($str, $withHyphenation = true, $langCode = NULL)
	{
		if (!is_scalar($str)) {
			throw new \Exception('String expected in Twig fullUrlFilter');
		}
		if (empty($langCode)) {
			$langCode = 'de';
		}
		$str = trim($str);
		$str = str_replace('--', '—', $str);
		$str = str_replace('...', '…', $str);
		$str = str_replace('… …', '… ', $str);
		$str = str_replace('(C)', '©', $str);
		$str = str_replace('(R)', '®', $str);
		$str = str_replace('(TM)', '™', $str);
		$str = str_replace('(+-)', '±', $str);
		$str = str_replace('(1/4)', '¼', $str);
		$str = str_replace('(1/2)', '½', $str);
		$str = str_replace('(3/4)', '¾', $str);
		$str = preg_replace('#(\d)\s*-\s*(\d)#is','$1–$2',$str);
		$str = preg_replace('#(\s)-(\s)#is','$1–$2',$str);
		$str = preg_replace('#(\d\s*)(x|\*)(\s*\d)#is','$1×$3',$str);

		switch ($langCode) {
			case 'af': # Afrikaans
			case 'bg': # Bulgarian
			case 'cs': # Czech
			case 'de': # German
			case 'et': # Estonian
			case 'fi': # Finnish
			case 'hr': # Croatian
			case 'hu': # Hungarian
			case 'is': # Icelandic
			case 'ka': # Georgian
			case 'lt': # Lithuanian
			case 'lv': # Latvian
			case 'pl': # Polish
			case 'ro': # Romanian
			case 'sk': # Slovak
			case 'sl': # Slovenian
			case 'sr': # Serbian
				$str = preg_replace('#"(\S.*\S)"#is','„$1“',$str);
				$str = preg_replace("#'(\S.*\S)'#is",'‚$1‘',$str);
				break;
			case 'ar': # Arabic
			case 'be': # Belarusian
			case 'ca': # Catalan
			case 'el': # Modern Greek (1453-)
			case 'es': # Spanish
			case 'eu': # Basque
			case 'fr': # French
			case 'hy': # Armenian
			case 'it': # Italian
			case 'no': # Norwegian
			case 'pt': # Portuguese
			case 'ru': # Russian
			case 'sq': # Albanian
			case 'uk': # Ukrainian
				$str = preg_replace('#"(\S.*\S)"#is','«$1»',$str);
				$str = preg_replace("#'(\S.*\S)'#is",'‹$1›',$str);
				break;
			case 'da': # Danish
				$str = preg_replace('#"(\S.*\S)"#is','»$1«',$str);
				$str = preg_replace("#'(\S.*\S)'#is",'›$1‹',$str);
				break;
			default:
				$str = preg_replace('#"(\S.*\S)"#is','“$1”',$str);
				$str = preg_replace("#'(\S.*\S)'#is",'‘$1’',$str);
				break;
		}
		if ($withHyphenation) {
			switch ($langCode) {
				case 'de':
					$str = mb_ereg_replace('(\w)(lich|dorf|stadt|burg|berg|markt|straße|baden|tig|den)(\W)', '\1­\2\3', $str);
					$str = mb_ereg_replace('(\W)(ver|vor|zer|ab|aus|auf)(\w)', '\1\2­\3', $str);
					break;
				case 'en':
					$str = mb_ereg_replace('(\w)(town|ing|tion|ly)(\W)', '\1­\2\3', $str);
					$str = mb_ereg_replace('(\W)(per)(\w)', '\1\2­\3', $str);
					break;
			}
		}
		return $str;
	}

	/**
	 * Will pad a inter with '0' until it has a minimum length of $chars
	 * @param  int    $string [description]
	 * @return string         [description]
	 */
	public function numberFormatFilter($int, $chars = 2)
	{
		if (!is_scalar($int)) {
			throw new \Exception('Integer expected in Twig numberFormatFilter');
		}
		$int = (string)$int;
		if (mb_strlen($int) < $chars) {
			$int = sprintf('%1$0'.(int)$chars.'d', (int)$int);
		}
		return $int;
	}

	/**
	 * [getName description]
	 * @return string [description]
	 */
	public function getName()
	{
		return 'helper_extension';
	}
}