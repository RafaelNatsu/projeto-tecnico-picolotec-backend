<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SecurityService
{
    public static function encrypt(string $value): string
    {
        try {
            return Crypt::encryptString($value);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erro ao criptografar os dados. Verifique o APP_KEY.");
        }
    }

    public static function decrypt(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            throw new \RuntimeException("Erro ao descriptografar. Verifique se o valor é inválido ou se a chave expirou.");
        }
    }
}
