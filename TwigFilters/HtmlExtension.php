<?php

namespace TwigFilters;

class HtmlExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('id',     array($this, 'idFilter')),
			new \Twig_SimpleFilter('plural', array($this, 'pluralFilter')),
		);
	}

	/**
	 * Will return a string safe to be used as HTML IDs and Classnames
	 * @param  mixed $mixed [description]
	 * @return string        [description]
	 */
	public function idFilter($string)
	{
		if (!is_scalar($string)) {
			throw new \Exception('String expected in Twig idFilter');
		}
		return $this->asciify(mb_strtolower((string)$string, 'UTF-8'));
	}

	/**
	 * Remove any character from string not being a-z, 0-9, _, -
	 *
	 * @param   string
	 * @return  string
	 */
	protected function asciify ($str) {
		if (!preg_match('#^[a-z0-9_\-\.]+$#s', $str)) {
			$str = str_replace(
				array('ä', 'Ä', 'æ', 'ö', 'Ö', 'ü', 'Ü', 'ß'),
				array('ae','AE','ae','oe','OE','ue','UE','ss'),
				$str
			);
			$str = str_replace(array('á','à','â'), 'a', $str);
			$str = str_replace(array('Á','À','Â'), 'A', $str);
			$str = str_replace(array('é','è','ê','ë'), 'e', $str);
			$str = str_replace(array('É','È','Ê'), 'E', $str);
			$str = str_replace(array('ó','ò','ô'), 'o', $str);
			$str = str_replace(array('Ó','Ò','Ô'), 'O', $str);
			$str = str_replace(array('ú','ù','û'), 'u', $str);
			$str = str_replace(array('Ú','Ù','Û'), 'U', $str);
			$str = preg_replace(
				array('#([^a-z0-9_\-])#is', '#(_)_+#', '#[^a-z0-9]+$#i', '#^[^a-z0-9]+#i'),
				array('_', '_', '', ''),
				$str
			);
		}
		return $str;
	}

	/**
	 * Return string depending on integer requiring a plural or singular form
	 * @param  integer $int      [description]
	 * @param  string  $singular [description]
	 * @param  string  $plural   [description]
	 * @return string            [description]
	 */
	public function pluralFilter ($int, $singular, $plural) {
		$int = (float)$int;
		return $int . ' ' . (($int === 1.0) ? $singular : $plural);
	}

	public function getName()
	{
		return 'html_extension';
	}
}