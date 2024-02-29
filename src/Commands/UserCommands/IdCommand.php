<?php

namespace Webmasterskaya\TelegramBotCommands\Commands\UserCommands;

use Longman\TelegramBot\Commands as BotCommands;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class IdCommand extends BotCommands\UserCommand
{
    protected $name = 'id';

    protected $description = 'Get id of current chat';

    protected $usage = '/id';

    protected $version = '1.0.0';

    protected $private_only = true;

    public function execute(): ServerResponse
    {
        // TODO: Implement execute() method.

        return Request::EmptyResponse();
    }
}