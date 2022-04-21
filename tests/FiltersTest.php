<?php declare(strict_types=1);

namespace oscarpalmer\Azura\Test;

use oscarpalmer\Azura\Azura;
use PHPUnit\Framework\TestCase;

use oscarpalmer\Azura\Filters;

mb_internal_encoding('UTF-8');

class FiltersTest extends TestCase
{
    protected Filters $filters;

    public function setUp(): void
    {
        $this->filters = new Filters(new Azura);
    }

    public function testCapitalize(): void
    {
        $this->assertSame('Hello world', $this->filters->capitalize('hello world'));
        $this->assertSame('H', $this->filters->capitalize('h'));
        $this->assertSame('', $this->filters->capitalize(''));
    }

    public function testEscape(): void
    {
        $this->assertSame('&lt;p&gt;An escaped tag&lt;/p&gt;', $this->filters->escape('<p>An escaped tag</p>'));
    }

    public function testJson(): void
    {
        $n = "\n";
        $t = "    ";
        $nt = "{$n}{$t}";

        $this->assertSame('null', $this->filters->json(null));
        $this->assertSame('[1,2,3,4,5]', $this->filters->json([1,2,3,4,5]));
        $this->assertSame("[{$nt}1,{$nt}2,{$nt}3,{$nt}4,{$nt}5{$n}]", $this->filters->json([1,2,3,4,5], true));

        $object = new \stdClass;

        $object->array = [1,2,3];
        $object->object = new \stdClass;
        $object->string = 'A string';

        $this->assertSame('{"array":[1,2,3],"object":{},"string":"A string"}', $this->filters->json($object));
        $this->assertSame("{{$nt}\"array\": [{$nt}{$t}1,{$nt}{$t}2,{$nt}{$t}3{$nt}],{$nt}\"object\": {},{$nt}\"string\": \"A string\"{$n}}", $this->filters->json($object, true));
    }

    public function testLength(): void
    {
        $this->assertSame(5, $this->filters->length('Azura'));
    }

    public function testLower(): void
    {
        $this->assertSame('azura', $this->filters->lower('Azura'));
    }

    public function testTitle(): void
    {
        $this->assertSame('Hello World', $this->filters->title('hello world'));
        $this->assertSame('H', $this->filters->title('h'));
        $this->assertSame('', $this->filters->title(''));
    }

    public function testTruncate(): void
    {
        $azura = 'Azura, the Queen of Dawn and Dusk';

        $this->assertSame($azura, $this->filters->truncate($azura, $this->filters->length($azura)));
        $this->assertSame('Azura, the Que&hellip;', $this->filters->truncate($azura, 15));
        $this->assertSame('Azura, the Quee', $this->filters->truncate($azura, 15, false));
        $this->assertSame('Azura, the Que___', $this->filters->truncate($azura, 15, '___'));
    }

    public function testUpper(): void
    {
        $this->assertSame('AZURA', $this->filters->upper('Azura'));
    }
}
