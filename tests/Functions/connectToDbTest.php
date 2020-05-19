<?php
use PHPUnit\Framework\TestCase;

/**
 * Class connectToDbTest
 */


class connectToDbTest extends TestCase
{
    protected function setUp() : void {

    }

    protected function tearDown() : void {

    }

    public function testConnectToDB() {
        $connection = connectToDatabase();
        $this->assertEquals(true, $connection);

    }
}
