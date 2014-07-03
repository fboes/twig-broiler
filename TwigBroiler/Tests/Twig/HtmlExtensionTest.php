<?php

namespace TwigBroiler\Tests\Twig;

use TwigBroiler\Twig\HtmlExtension;

class HtmlExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testSimple () {
        $twig = new HtmlExtension();
        $this->assertTrue(is_object($twig));
        $this->assertTrue(is_array($twig->getFilters()));
        $this->assertTrue(is_string($twig->getName()));
    }

    public function dataIdFilter ()
    {
        return array(
            array('',   ''),
            array('a',  'a'),
            array('ä',  'ae'),
        );
    }

    /**
     * @dataProvider dataIdFilter
     */
    public function testIdFilter ($string, $assertedReturn)
    {
        $twig = new HtmlExtension();

        $actualReturn = $twig->idFilter($string);

        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($actualReturn, $assertedReturn);
    }

}
