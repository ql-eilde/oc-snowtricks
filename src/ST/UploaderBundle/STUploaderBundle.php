<?php

namespace ST\UploaderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class STUploaderBundle extends Bundle
{
    public function getParent(){
        return 'VichUploaderBundle';
    }
}