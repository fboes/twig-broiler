<?php

namespace TwigBrolier\Twig;

class JsExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('json_serialize', array($this, 'jsonSerialize')),
			new \Twig_SimpleFilter('js_variable',    array($this, 'jsVariable')),
		);
	}

	/**
	 * Will return JSON by using $this->jsonWalker
	 * @param  mixed $mixed [description]
	 * @return string        [description]
	 */
	public function jsonSerialize($mixed)
	{
		return json_encode($this->jsonWalker($mixed));
	}

	/**
	 * Will return a string safe to be used inside of Javascript, including quotes around it.
	 * @param  string $string [description]
	 * @return string         [description]
	 */
	public function jsVariable($string, $quotes = "'")
	{
		if (!is_scalar($string)) {
			throw new \Exception('String expected in Twig idFilter');
		}
		return $quotes . addcslashes($string, $quotes."\n\r") . $quotes;
	}

	/**
	 * [jsonWalker description]
	 * @param  [type] $mixed [description]
	 * @return [type]        [description]
	 */
	protected function jsonWalker ($mixed) {
		if (is_scalar($mixed)) {
			return $mixed;
		} elseif (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = $this->jsonWalker($value);
			}
			return $mixed;
		} elseif (is_object($mixed)) {
			return (method_exists($mixed, 'jsonSerialize')) ? $mixed->jsonSerialize() : $mixed;
		} else {
			return $mixed;
		}
	}

	public function getName()
	{
		return 'json_extension';
	}
}