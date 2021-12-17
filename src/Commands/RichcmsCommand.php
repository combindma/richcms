<?php

namespace Combindma\Richcms\Commands;

use Illuminate\Console\Command;

class RichcmsCommand extends Command
{
    public $signature = 'richcms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
