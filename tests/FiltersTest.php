<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use oscarpalmer\Azura\Azura;
use PHPUnit\Framework\TestCase;

use oscarpalmer\Azura\Filters\Filter;

mb_internal_encoding('UTF-8');

class FiltersTest extends TestCase
{
    protected Filter $filter;

    public function setUp(): void
    {
        $this->filter = new Filter(new Azura);
    }

    public function testCapitalize(): void
    {
        $this->assertSame('Hello world', $this->filter->capitalize('hello world'));
        $this->assertSame('H', $this->filter->capitalize('h'));
        $this->assertSame('', $this->filter->capitalize(''));
    }

    public function testEscape(): void
    {
        $this->assertSame('&lt;p&gt;An escaped tag&lt;/p&gt;', $this->filter->escape('<p>An escaped tag</p>'));
    }

    public function testJson(): void
    {
        $n = "\n";
        $t = "    ";
        $nt = "{$n}{$t}";

        $this->assertSame('null', $this->filter->json(null));
        $this->assertSame('[1,2,3,4,5]', $this->filter->json([1,2,3,4,5]));
        $this->assertSame("[{$nt}1,{$nt}2,{$nt}3,{$nt}4,{$nt}5{$n}]", $this->filter->json([1,2,3,4,5], true));

        $object = new \stdClass;

        $object->array = [1,2,3];
        $object->object = new \stdClass;
        $object->string = 'A string';

        $this->assertSame('{"array":[1,2,3],"object":{},"string":"A string"}', $this->filter->json($object));
        $this->assertSame("{{$nt}\"array\": [{$nt}{$t}1,{$nt}{$t}2,{$nt}{$t}3{$nt}],{$nt}\"object\": {},{$nt}\"string\": \"A string\"{$n}}", $this->filter->json($object, true));
    }

    public function testLength(): void
    {
        $this->assertSame(5, $this->filter->length('Azura'));
    }

    public function testLower(): void
    {
        $this->assertSame('azura', $this->filter->lower('Azura'));
    }

    public function testTitle(): void
    {
        $this->assertSame('Hello World', $this->filter->title('hello world'));
        $this->assertSame('H', $this->filter->title('h'));
        $this->assertSame('', $this->filter->title(''));
    }

    public function testTruncate(): void
    {
        $azura = 'Azura, the Queen of Dawn and Dusk';

        $this->assertSame($azura, $this->filter->truncate($azura, $this->filter->length($azura)));
        $this->assertSame('Azura, the Que&hellip;', $this->filter->truncate($azura, 15));
        $this->assertSame('Azura, the Quee', $this->filter->truncate($azura, 15, false));
        $this->assertSame('Azura, the Que___', $this->filter->truncate($azura, 15, '___'));
    }

    public function testUpper(): void
    {
        $this->assertSame('AZURA', $this->filter->upper('Azura'));
    }
}
