<?php

namespace TwigBrolier\Twig;

class CsvExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('csv_field', array($this, 'csvField')),
		);
	}

	/**
	 * [csvFilter description]
	 * @param  mixed $mixed [description]
	 * @return string        [description]
	 */
	public function csvField($string, $delimiter = ';', $enclosure = '"')
	{
		$string = preg_replace('/('.preg_quote($enclosure).')/is', $enclosure.'$1', $string);
		return $enclosure . $string . $enclosure;
	}

	public function getName()
	{
		return 'csv_extension';
	}
}