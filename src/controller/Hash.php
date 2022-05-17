<?php
namespace App\controller;
class Hash {
    public static function hash(string $texto) : string {
        return password_hash($texto, PASSWORD_BCRYPT, ['cost'=> 10]);
    }
}