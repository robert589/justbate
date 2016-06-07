<?php

namespace backend\creator;

/**
 * Interface Factory
 * All factory should follow singleton pattern
 * Factory does not mean the class follows factory pattern
 * @package backend\factory
 */

interface CreatorInterface
{
     function get(array $need);

     function validateModel();
}

?>
