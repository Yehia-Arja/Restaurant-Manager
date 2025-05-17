<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Traits\BuildChatPromptTrait;

abstract class Controller
{
    use ApiResponseTrait;
    use BuildChatPromptTrait;
}
