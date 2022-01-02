<?php

use PHPUnit\Framework\TestCase;
use Console\Services\ParseService;

class ParseServiceTest extends TestCase
{
    public function testParse()
    {
        @unlink('default.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/default.jsonl');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/default.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals($data, $checkData);
    }

    public function testZeroItem()
    {
        @unlink('default.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/zeroItem.jsonl');
        $data = file_get_contents('out.csv');
        $this->assertEmpty($data);
    }

    public function testMultipleDiscount()
    {
        @unlink('default.csv');
        $parser = new ParseService();
        $parser->parse('./tests/data/multipleDiscount.jsonl');
        $data = file_get_contents('out.csv');
        $checkData = file_get_contents('./tests/data/multipleDiscount.csv');
        $this->assertNotEmpty($data);
        $this->assertEquals($data, $checkData);
    }

    public function testParseEmptyUrl()
    {
        $this->expectExceptionMessage('Filename cannot be empty');
        $this->expectError();
        $parser = new ParseService();
        $parser->parse('');
    }

    public function testParseInvalidUrl()
    {
        $this->expectExceptionMessage('failed to open stream: No such file or directory');
        $this->expectError();
        $parser = new ParseService();
        $parser->parse('some-invalid-path');
    }
}
