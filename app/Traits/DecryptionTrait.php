<?php

namespace App\Traits;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

trait DecryptionTrait
{
    public function isDecryptable($string) {
        try {
            Crypt::decrypt($string);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }
}
