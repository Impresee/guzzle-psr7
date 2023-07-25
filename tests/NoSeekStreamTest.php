<?php

declare(strict_types=1);

namespace ImpreseeGuzzleHttp\Tests\Psr7;

use ImpreseeGuzzleHttp\Psr7\NoSeekStream;
use PHPUnit\Framework\TestCase;
use Impresee\Psr\Http\Message\StreamInterface;

/**
 * @covers ImpreseeGuzzleHttp\Psr7\NoSeekStream
 * @covers ImpreseeGuzzleHttp\Psr7\StreamDecoratorTrait
 */
class NoSeekStreamTest extends TestCase
{
    public function testCannotSeek(): void
    {
        $s = $this->createMock(StreamInterface::class);
        $s->expects(self::never())->method('seek');
        $s->expects(self::never())->method('isSeekable');
        $wrapped = new NoSeekStream($s);
        self::assertFalse($wrapped->isSeekable());
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cannot seek a NoSeekStream');
        $wrapped->seek(2);
    }

    public function testToStringDoesNotSeek(): void
    {
        $s = \ImpreseeGuzzleHttp\Psr7\Utils::streamFor('foo');
        $s->seek(1);
        $wrapped = new NoSeekStream($s);
        self::assertSame('oo', (string) $wrapped);

        $wrapped->close();
    }
}
