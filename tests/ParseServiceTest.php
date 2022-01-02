<?php

use PHPUnit\Framework\TestCase;
use Console\Services\ParseService;

class ParseServiceTest extends TestCase
{
    public function testParse()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/default.jsonl', '', '', '');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/default.csv');
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
        $parser->parse('./tests/data/default.jsonl', 'customer_state', 'asc', '');
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
        $parser->parse('./tests/data/default.jsonl', 'customer_state', 'desc', '');
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
        $parser->parse('./tests/data/zeroItem.jsonl', '', '', '');
        $data = file_get_contents('out.csv');
        $this->assertEmpty($data);
    }

    public function testMultipleDiscount()
    {
        @unlink('out.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/multipleDiscount.jsonl', '', '', '');
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
        $parser->parse('', '', '', '');
    }

    public function testParseInvalidUrl()
    {
        $this->expectExceptionMessage('failed to open stream: No such file or directory');
        $this->expectError();
        $parser = new ParseService();
        $parser->parse('some-invalid-path', '', '', '');
    }
}
