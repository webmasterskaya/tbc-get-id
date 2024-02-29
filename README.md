# Telegram Bot Command - Get user and chanel id

> [!NOTE]
> **For GitHub users!** This is mirror! All development takes place [here](https://git.webmasterskaya.xyz/tbc/tbc-get-id) 
> | Вся разработка ведётся [здесь](https://git.webmasterskaya.xyz/tbc/tbc-get-id)

Implements the ability to get a user or channel ID in Telegram.

Реализует возможность получить ID пользователя или канала в Telegram.

## Подключение к проекту

Установите пакет в зависимости

```shell
composer require webmasterskaya/tbc-get-id
```

Зарегистрируйте класс команды, при инициализации приложения.

```php
$bot_api_key  = 'your:bot_api_key';
$bot_username = 'username_bot';

$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

$telegram->addCommandClass(\Webmasterskaya\TelegramBotCommands\Commands\UserCommands\IdCommand::class);

$telegram->handle();
// OR
$telegram->handleGetUpdates();
```

Команду можно запускать вручную, без изменений входящих данных!

```php
$telegram->executeCommand('id');
```

## Использование

### В чатах
1. Выполните команду `/id`, чтобы получить ID текущего чата.
2. Выполните команду `/id` в ответ на любое сообщение и вы получите ID текущего чата, ID автора сообщения и ID чата, из которого это сообщение переслали.

### В личных сообщениях
1. Выполните команду `/id`, чтобы получить ваш ID.
2. Перешлите любое сообщение (пользователя, чата, канала или другого бота) боту и, в ответ на это сообщение, выполните команду `/id`.