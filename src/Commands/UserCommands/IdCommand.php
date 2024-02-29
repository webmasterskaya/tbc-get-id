<?php

namespace Webmasterskaya\TelegramBotCommands\Commands\UserCommands;

use Longman\TelegramBot\Commands as BotCommands;
use Longman\TelegramBot\Entities\Entity;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\User;
use Longman\TelegramBot\Request;

class IdCommand extends BotCommands\UserCommand
{
    protected $name = 'id';

    protected $description = 'Get id of current chat';

    protected $usage = '/id';

    protected $version = '1.0.0';

    protected $private_only = false;

    public function execute(): ServerResponse
    {
        $message = $this->getMessage() ?: $this->getChannelPost();

        if ($message->getFrom()->getIsBot() && is_null($message->getSenderChat())) {
            return Request::emptyResponse();
        }

        $chat = $message->getChat();

        $data = [
            'chat_id' => $chat->getId(),
            'reply_to_message_id' => $message->getMessageId(),
            'parse_mode' => 'MarkdownV2'
        ];

        /** @noinspection PhpUndefinedMethodInspection */
        if (!empty(@$message->getExternalReply())) {
            $data['text'] = sprintf('*Error*: %s', Entity::escapeMarkdownV2('Replies 2.0 not supported.'));
            return Request::sendMessage($data);
        }

        $response_data = [];

        if($chat->isPrivateChat()){
            $response_data['Your ID'] = $message->getFrom()->getId() ?: $chat->getId();
        } else {
            $response_data['This chat ID'] = $chat->getId();
        }

        if (!is_null($reply = $message->getReplyToMessage())) {
            $message = $reply;
            if (!$chat->isPrivateChat()) {
                $form = $message->getSenderChat() ?: $message->getFrom();
                $form_type = ($form instanceof User)
                    ? ($form->getIsBot() ? 'bot' : 'user')
                    : $form->getType();

                $response_data["Message from $form_type ID"] = $form->getId();
            }
        }

        if (!is_null($forward = $message->getForwardFrom() ?: $message->getForwardFromChat())) {
            $forward_from_type = ($forward instanceof User)
                ? ($forward->getIsBot() ? 'bot' : 'user')
                : $forward->getType();
            $response_data["Forward from $forward_from_type ID"] = $forward->getId();
        }

        $data['text'] = '';
        foreach ($response_data as $title => $value) {
            $data['text'] .= sprintf('*%s*: `%s`',
                    Entity::escapeMarkdownV2($title),
                    Entity::escapeMarkdownV2($value)) . PHP_EOL;
        }

        return Request::sendMessage($data);
    }
}