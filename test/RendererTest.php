<?php


declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RendererTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {

        die('EXIT '.__FILE__.'@'.__LINE__);
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        die('EXIT '.__FILE__.'@'.__LINE__);
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        die('EXIT '.__FILE__.'@'.__LINE__);
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
}
