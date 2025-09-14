<?php

namespace App\Validation;

class CustomRules
{
    public function emailCheck(string $email, string $fields = null, array $data = []): bool
    {
        return preg_match('/@.*cmb\.ac\.lk$/', $email) === 1;
    }
}
