<?php


namespace App\Package\Domain\Common\Validator;


class ValidationNotification
{
    /** @var array  */
    public $notificationMessage = [];

    /**
     * エラーメッセージをキーと値でセットする
     *
     * @param string $key
     * @param string $message
     */
    public function setErrorMsg( string $key, string $message ): void
    {
        $this->notificationMessage[$key][] = $message;
    }

    /**
     * エラーメッセージが存在するか
     *
     * @return bool
     */
    public function exist(): bool
    {
        return !empty($this->notificationMessage);
    }

    /**
     * エラーメッセージを文字列として返す
     *
     * @return string
     */
    public function toString(): string
    {
        $msg = '';
        foreach ( $this->notificationMessage as $key => $messages ) {
            foreach ( $messages as $message ) {
                $msg .= $message . PHP_EOL;
            }
        }
        return $msg;
    }

    /**
     * エラーメッセージを配列で返す
     *
     * @return array
     */
    public function getNotificationMessage(): array
    {
        return $this->notificationMessage;
    }
}
