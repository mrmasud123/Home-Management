<?php

namespace Illuminate\Contracts\JsonSchema;

use Illuminate\JsonSchema\Types\ArrayType;
use Illuminate\JsonSchema\Types\BooleanType;
use Illuminate\JsonSchema\Types\IntegerType;
use Illuminate\JsonSchema\Types\NumberType;
use Illuminate\JsonSchema\Types\ObjectType;
use Illuminate\JsonSchema\Types\StringType;

interface JsonSchema
{
    public function string(): StringType;
    public function integer(): IntegerType;
    public function number(): NumberType;
    public function boolean(): BooleanType;
    public function array(): ArrayType;
    public function object(): ObjectType;
}
