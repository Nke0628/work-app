<?php


namespace App\Package\UseCase\Error\Dto;


class ErrorMessageDto
{
    /** @var string[] */
    private $messageList;

    /**
     * エラーメッセージを追加
     *
     * @param string $message
     */
    public function addMessage( string $message ): void
    {
        $this->messageList[] = $message;
    }

    /**
     * エラーメッセージを取得
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messageList;
    }
}
