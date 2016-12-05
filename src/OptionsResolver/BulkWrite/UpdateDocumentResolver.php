<?php

namespace Tequila\MongoDB\OptionsResolver\BulkWrite;

use Tequila\MongoDB\Exception\InvalidArgumentException;
use Tequila\MongoDB\OptionsResolver\OptionsResolver;
use Tequila\MongoDB\Traits\CachedResolverTrait;

class UpdateDocumentResolver extends OptionsResolver
{
    use CachedResolverTrait;

    public function configureOptions()
    {
        $this->setDefined([
            '$inc',
            '$mul',
            '$rename',
            '$setOnInsert',
            '$set',
            '$unset',
            '$min',
            '$max',
            '$currentDate',
            '$bit',
        ]);
    }

    public function resolve(array $options = array())
    {
        try {
            parent::resolve($options);
        } catch(InvalidArgumentException $e) {
            throw new InvalidArgumentException(
                sprintf(
                    '$update has a wrong format: %s',
                    $e->getMessage()
                )
            );
        }
    }
}