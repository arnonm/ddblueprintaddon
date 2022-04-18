<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Tests\Feature;

use Arnonm\DDBlueprintAddon\DDBlueprintGenerator;
use Blueprint\Blueprint;
use Blueprint\Lexers\ControllerLexer;
use Blueprint\Lexers\ModelLexer;
use Blueprint\Lexers\StatementLexer;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Mockery\MockInterface;
use Arnonm\DDBlueprintAddon\Tests\TestCase;


class FeatureTestCase extends TestCase
{
    protected Blueprint $blueprint;

    protected MockInterface $files;

    protected DDBlueprintGenerator $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->files = Mockery::mock(Filesystem::class);

        $this->subject = new DDBlueprintGenerator($this->files);

        $this->blueprint = new Blueprint();
        $this->blueprint->registerLexer(new ModelLexer());
        $this->blueprint->registerLexer(new ControllerLexer(new StatementLexer()));
        $this->blueprint->registerGenerator($this->subject);
    }
}
