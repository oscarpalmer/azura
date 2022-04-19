<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use PHPUnit\Framework\TestCase;

use oscarpalmer\Azura\Strings;

mb_internal_encoding(Strings::ENCODING);

class StringsTest extends TestCase
{
    protected Strings $strings;

    public function setUp(): void
    {
        $this->strings = new Strings();
    }

    public function testEscape(): void
    {
        $this->assertSame('&lt;p&gt;An escaped tag&lt;/p&gt;', $this->strings->escape('<p>An escaped tag</p>'));
    }

    public function testJson(): void
    {
        $n = "\n";
        $t = "    ";
        $nt = "{$n}{$t}";

        $this->assertSame('null', $this->strings->json(null));
        $this->assertSame('[1,2,3,4,5]', $this->strings->json([1,2,3,4,5]));
        $this->assertSame("[{$nt}1,{$nt}2,{$nt}3,{$nt}4,{$nt}5{$n}]", $this->strings->json([1,2,3,4,5], true));

        $object = new \stdClass;

        $object->array = [1,2,3];
        $object->object = new \stdClass;
        $object->string = 'A string';

        $this->assertSame('{"array":[1,2,3],"object":{},"string":"A string"}', $this->strings->json($object));
        $this->assertSame("{{$nt}\"array\": [{$nt}{$t}1,{$nt}{$t}2,{$nt}{$t}3{$nt}],{$nt}\"object\": {},{$nt}\"string\": \"A string\"{$n}}", $this->strings->json($object, true));
    }

    public function testLength(): void
    {
        $this->assertSame(5, $this->strings->length('Azura'));
    }

    public function testToLower(): void
    {
        $this->assertSame('azura', $this->strings->toLower('Azura'));
    }

    public function testToUpper(): void
    {
        $this->assertSame('AZURA', $this->strings->toUpper('Azura'));
    }

    public function testTruncate(): void
    {
        $azura = 'Azura, the Queen of Dawn and Dusk';

        $this->assertSame($azura, $this->strings->truncate($azura, $this->strings->length($azura)));
        $this->assertSame('Azura, the Que&hellip;', $this->strings->truncate($azura, 15));
        $this->assertSame('Azura, the Quee', $this->strings->truncate($azura, 15, false));
    }
}
