<?php

namespace TwigBroiler\Tests\Twig;

use TwigBroiler\Twig\SocialMediaExtension;

class SocialMediaExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testSimple () {
        $twig = new SocialMediaExtension();
        $this->assertTrue(is_object($twig));
        $this->assertTrue(is_array($twig->getFilters()));
        $this->assertTrue(is_string($twig->getName()));
    }

    public function dataIdFilter ()
    {
        return array(
            array('http://example.com',  '#example#'),
        );
    }

    /**
     * @dataProvider dataIdFilter
     */
    public function testLinks ($string, $assertedReturn)
    {
        $twig = new SocialMediaExtension();

        $actualReturn = $twig->facebookUrl($string);
        $this->assertTrue(is_string($actualReturn));
        $this->assertTrue(1 === preg_match($assertedReturn, $actualReturn));

        $actualReturn = $twig->facebookIframe($string);
        $this->assertTrue(is_string($actualReturn));
        $this->assertTrue(1 === preg_match($assertedReturn, $actualReturn));

        $actualReturn = $twig->googlePlusUrl($string);
        $this->assertTrue(is_string($actualReturn));
        $this->assertTrue(1 === preg_match($assertedReturn, $actualReturn));
    }
}
