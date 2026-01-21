<?php

namespace App\Support;

use Respect\Validation\Exceptions\NestedValidationException;

class FormValidation
{
    public static function validate(array $dados, array $regras): array
    {
        $erros = [];

        foreach ($regras as $campo => $regra) {
            try {
                $regra->assert($dados[$campo] ?? null);
            } catch (NestedValidationException $e) {
                $erros[$campo] = $e->getMessages();
            }
        }

        return $erros;
    }
}