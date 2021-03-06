<?php

use PHPUnit\Framework\TestCase;
use Console\Services\ParseService;

class ParseServiceTest extends TestCase
{
    public function testParse()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/input.jsonl', '', '');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/default-out.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testParseSaveToXml()
    {
        @unlink('default-out.xml');
        $parser = new ParseService();
        $parser->parse('./tests/data/input.jsonl', '', '', 'xml');
        $data = file_get_contents('default-out.xml');
        $checkData = file_get_contents('./tests/data/default-out.xml');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testParseSaveToJsonl()
    {
        @unlink('default-out.jsonl');
        $parser = new ParseService();
        $parser->parse('./tests/data/input.jsonl', '', '', 'jsonl');
        $data = file_get_contents('default-out.jsonl');
        $checkData = file_get_contents('./tests/data/default-out.jsonl');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testParseSortByFieldAsc()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/input.jsonl', 'customer_state', 'asc');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/sortAsc.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testParseSortByFieldDesc()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/input.jsonl', 'customer_state', 'desc');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/sortDesc.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testZeroItem()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/zeroItem.jsonl', '', '');
        $data = file_get_contents('out.csv');
        $this->assertEmpty($data);
    }

    public function testMultipleDiscount()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/multipleDiscount.jsonl', '', '');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/multipleDiscount.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals(
            str_replace(["\r\n", "\n"], "", $data),
            str_replace(["\r\n", "\n"], "", $checkData)
        );
    }

    public function testParseEmptyUrl()
    {
        $this->expectExceptionMessage('Filename cannot be empty');
        $this->expectError();
        $parser = new ParseService();
        $parser->parse('', '', '');
    }

    public function testParseInvalidUrl()
    {
        $this->expectExceptionMessage('failed to open stream: No such file or directory');
        $this->expectError();
        $parser = new ParseService();
        $parser->parse('some-invalid-path', '', '');
    }
}
