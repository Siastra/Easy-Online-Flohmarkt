<?php


class MsgFactory
{
    public static function getWarning(string $text) : string
    {
        return self::getMessage("warning", $text);
    }

    public static function getSuccess(string $text) : string
    {
        return self::getMessage("success", $text);
    }

    private static function getMessage(string $type, string $text) : string {
        return '<div class="alert alert-' . $type .' alert-dismissible fade show" role="alert">' . $text . '
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>';
    }

}