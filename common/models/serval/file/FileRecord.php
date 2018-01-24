<?php

namespace common\models\serval\file;

// parent class for all file types ( Active Record )

class FileRecord extends \common\models\serval\file\BaseFileRecord
{

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

}
