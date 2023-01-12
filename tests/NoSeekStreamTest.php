<?php

namespace ImpreseeGuzzleHttp\Tests\Psr7;

use ImpreseeGuzzleHttp\Psr7\NoSeekStream;

/**
 * @covers ImpreseeGuzzleHttp\Psr7\NoSeekStream
 * @covers ImpreseeGuzzleHttp\Psr7\StreamDecoratorTrait
 */
class NoSeekStreamTest extends BaseTest
{
    public function testCannotSeek()
    {
        $s = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->setMethods(['isSeekable', 'seek'])
            ->getMockForAbstractClass();
        $s->expects(self::never())->method('seek');
        $s->expects(self::never())->method('isSeekable');
        $wrapped = new NoSeekStream($s);
        self::assertFalse($wrapped->isSeekable());

        $this->expectExceptionGuzzle('RuntimeException', 'Cannot seek a NoSeekStream');

        $wrapped->seek(2);
    }

    public function testToStringDoesNotSeek()
    {
        $s = \ImpreseeGuzzleHttp\Psr7\Utils::streamFor('foo');
        $s->seek(1);
        $wrapped = new NoSeekStream($s);
        self::assertSame('oo', (string) $wrapped);

        $wrapped->close();
    }
}
