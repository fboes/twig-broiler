<?php

namespace TwigBroiler\Tests\Twig;

use TwigBroiler\Twig\CsvExtension;

class CsvExtensionTest extends \PHPUnit_Framework_TestCase {

    public function testSimple ()
    {
        $twig = new CsvExtension();
        $this->assertTrue(is_object($twig));
        $this->assertTrue(is_array($twig->getFilters()));
        $this->assertTrue(is_string($twig->getName()));
    }

    public function dataCsvField ()
    {
        return array(
            array('',    ';','"', '""'),
            array('a',   ';','"', '"a"'),
            array('"a"', ';','"', '"""a"""'),
            array('a;b', ';','"', '"a;b"'),
        );
    }

    /**
     * @dataProvider dataCsvField
     */
    public function testCsvField ($string, $delimiter, $enclosure, $assertedReturn)
    {
        $twig = new CsvExtension();

        $actualReturn = $twig->csvField($string, $delimiter, $enclosure);

        $this->assertTrue(is_string($actualReturn));
        $this->assertEquals($actualReturn, $assertedReturn);
    }
}
