<?php

namespace Tequila\MongoDB\Options\Driver;

use Symfony\Component\OptionsResolver\Options;
use Tequila\MongoDB\Exception\InvalidArgumentException;
use Tequila\MongoDB\Options\OptionsInterface;
use Tequila\MongoDB\Options\OptionsResolver;
use Tequila\MongoDB\Options\Traits\CachedResolverTrait;

class TypeMapOptions implements OptionsInterface
{
    use CachedResolverTrait;

    public static function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(self::getDefaults());

        $resolver
            ->setAllowedTypes('array', 'string')
            ->setAllowedTypes('document', 'string')
            ->setAllowedTypes('root', 'string');

        $resolver
            ->setNormalizer('array', self::getNormalizer('array'))
            ->setNormalizer('document', self::getNormalizer('document'))
            ->setNormalizer('root', self::getNormalizer('root'));
    }

    public static function getDefaults()
    {
        return [
            'root' => 'array',
            'document' => 'array',
            'array' => 'array',
        ];
    }

    /**
     * @param string $fieldName
     * @return \Closure
     */
    private static function getNormalizer($fieldName)
    {
        return function(Options $options, $fieldType) use($fieldName) {
            if (!in_array($fieldType, ['array', 'object'], true)) {
                if (!class_exists($fieldType)) {
                    throw new InvalidArgumentException(
                        sprintf(
                            'Type map option "%s" must be "array", "object" or a class name, "%s" given',
                            $fieldName,
                            $fieldType
                        )
                    );
                }
            }

            return $fieldType;
        };
    }
}
