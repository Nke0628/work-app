<?php


namespace App\Package\UseCase\PositionChangeApply\Output;


class ErrorListDto
{
    /** @var string */
    private $messageStr = '';

    /** @var array */
    private $messageArray = [];

    /**
     * @param string $message
     */
    public function setMessageString( string $message )
    {
        $this->messageStr = $message;
    }

    /**
     * @param array $messages
     */
    public function setMessageArray( array $messages )
    {
        $this->messageArray = $messages;
    }

    /**
     * @return string
     */
    public function getMessageStr(): string
    {
        return $this->messageStr;
    }

    /**
     * @return array
     */
    public function getMessageArray(): array
    {
        return $this->messageArray;
    }
}
