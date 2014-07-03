<?php

namespace TwigBroiler\Tests\Twig;

use TwigBroiler\Twig\HelperExtension;

class HelperExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testSimple () {
        $twig = new HelperExtension();
        $this->assertTrue(is_object($twig));
        $this->assertTrue(is_array($twig->getFilters()));
        $this->assertTrue(is_string($twig->getName()));
    }

    public function dataFullUrl ()
    {
        return array(
            array('http://example.com',  'http://example.com'),
            array('https://example.com',  'https://example.com'),
            array('ftp://example.com',  'ftp://example.com'),
            array('//example.com',  '//example.com'),
            array('/example.com',  '//localhost/example.com'),
            array('example.com',  '//localhost/example.com'),
        );
    }

    /**
     * @dataProvider dataFullUrl
     */
    public function testFullUrl ($string, $assertedReturn)
    {
        $twig = new HelperExtension();

        $actualReturn = $twig->fullUrlFilter($string);
        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($assertedReturn, $actualReturn);
    }


    public function dataNumberFormat ()
    {
        return array(
            array('1',  '01'),
            array(1,    '01'),
            array(11,   '11'),
            array(111,  '111'),
        );
    }

    /**
     * @dataProvider dataNumberFormat
     */
    public function testNumberFormat ($string, $assertedReturn)
    {
        $twig = new HelperExtension();

        $actualReturn = $twig->numberFormatFilter($string);
        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($assertedReturn, $actualReturn);
    }


    public function datatypoFilter ()
    {
        return array(
            array('123-124', '123–124'),
            array('123 - 124', '123–124'),
            array('Ich weiß ja nicht...', 'Ich weiß ja nicht…'),
            array('Sumpfhuhn(TM) oder so ähnlich', 'Sumpfhuhn™ oder so ähnlich'),
            array('Und da sagt der doch: "Ich würde das anders machen".', 'Und da sagt der doch: „Ich würde das anders machen“.'),
        );
    }

    /**
     * @dataProvider datatypoFilter
     */
    public function testtypoFilter ($string, $assertedReturn)
    {
        $twig = new HelperExtension();

        $actualReturn = $twig->typoFilter($string);

        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($actualReturn, $assertedReturn);
    }
}
