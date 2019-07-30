<?php


namespace App\Container\Model\User\Service;


use App\Model\User\Service\ResetTokenizer;

class ResetTokenizerFactory
{
    public function create(string $interval)
    {
        return new ResetTokenizer($interval);
    }
}