<?php

/**
 * 
 * Resources Factory's definitions 
 * 
 */

use Zeero\Database\Resource\Resource;


Resource::factory('resource name', function ($obj) {
    return [
        'key' => $obj->value
    ];
});
