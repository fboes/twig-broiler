<?php

namespace TwigBroiler\Tests\Twig;

use TwigBroiler\Twig\JsExtension;

class JsExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testSimple () {
        $twig = new JsExtension();
        $this->assertTrue(is_object($twig));
        $this->assertTrue(is_array($twig->getFilters()));
        $this->assertTrue(is_string($twig->getName()));
    }

    public function dataJsonSerialize ()
    {
        return array(
            array('',   ''),
            array('',   ''),
            array('',   ''),
        );
    }

    /**
     * @dataProvider dataJsonSerialize
     */
    public function testJsonSerialize ($string, $assertedReturn)
    {
        $twig = new JsExtension();

        $actualReturn = $twig->jsonSerialize($string);

        $this->assertTrue(is_string($actualReturn));
        #$this->assertEquals($actualReturn, $assertedReturn);
    }

    public function dataJsVariable ()
    {
        return array(
            array('',   "''"),
            array('a',   "'a'"),
            array("''",   "'\'\''"),
        );
    }

    /**
     * @dataProvider dataJsVariable
     */
    public function testJsVariable ($string, $assertedReturn)
    {
        $twig = new JsExtension();

        $actualReturn = $twig->jsVariable($string);

        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($actualReturn, $assertedReturn);
    }
}
