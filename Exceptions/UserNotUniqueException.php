<?php

namespace OswisOrg\OswisCoreBundle\Exceptions;

class UserNotUniqueException extends OswisException
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Identifikátor uživatele není unikátní.');
    }
}
