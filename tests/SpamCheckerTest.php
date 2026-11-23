<?php
// Original example available on https://symfony.com/doc/8.1/the-fast-track/en/17-tests.html uses
// the class Symfony\AI\Platform\Test\InMemoryPlatform which has been removed on symfony/ai-platform v0.15.0
// in the example I use MockPlatformFactory with the example suggested by Claude.ai
//To test, run: symfony php bin/phpunit tests/SpamCheckerTest.php

namespace App\Tests;

use App\Entity\Comment;
use App\SpamChecker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Agent\Agent;
//use Symfony\AI\Platform\Exception\RuntimeException;
//use Symfony\AI\Platform\Test\InMemoryPlatform;
use Symfony\AI\Platform\Test\MockPlatformFactory;


class SpamCheckerTest extends TestCase
{
//    public function testSomething(): void
//    {
//        $this->assertTrue(true);
//    }
    #[DataProvider('provideAnswers')]
    public function testSpamScore(string $answer, int $expectedScore): void
    {
        $platform = MockPlatformFactory::createPlatform($answer);
        $checker = new SpamChecker(new Agent($platform, 'gpt-5-mini'));

        $comment = new Comment();
        $comment->setAuthor('Bogdan');
        $comment->setEmail('test@example.com');
        $comment->setText('Buy cheap watches!');

        $this->assertSame($expectedScore, $checker->getSpamScore($comment, []));
    }

    public static function provideAnswers(): iterable
    {
        yield 'ham' => ['ham', 0];
        yield 'maybe' => ['maybe spam', 1];
        yield 'blatant' => ['blatant spam', 2];
    }
}
