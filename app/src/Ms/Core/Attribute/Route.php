<?php
// src/Attributes/Route.php
namespace Banquet\Ms\Core\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route {
    public function __construct(
        public string $path,
        public string $method = 'GET'
    ) {}
}
