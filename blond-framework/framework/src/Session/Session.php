<?php

namespace Sunlazor\BlondFramework\Session;

class Session implements SessionInterface
{
    private const string FLASH_KEY = 'flash';
    public const string AUTH_KEY = 'user_id';

    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function getFlash(string $type): array
    {
        $flash = $this->get(self::FLASH_KEY, []);

        if (!isset($flash[$type])) {
            return [];
        }

        $messages = $flash[$type];
        unset($flash[$type]);
        $this->set(self::FLASH_KEY, $flash);

        return $messages;
    }

    public function setFlash(string $type, string $message): void
    {
        $flash = $this->get(self::FLASH_KEY, []);
        $flash[$type][] = $message;
        $this->set(self::FLASH_KEY, $flash);
    }

    public function hasFlash(string $type): bool
    {
        $flash = $this->get(self::FLASH_KEY, []);
        return isset($flash[$type]);
    }

    public function clearFlash(): void
    {
        $this->set(self::FLASH_KEY, []);
    }
}