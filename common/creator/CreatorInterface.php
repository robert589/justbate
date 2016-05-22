<?php

namespace common\creator;

/**
 * Interface Factory
 * All factory should follow singleton pattern
 * Factory does not mean the class follows factory pattern
 * @package common\factory
 */
interface CreatorInterface{

    function get(array $need);

    function validateModel();
}