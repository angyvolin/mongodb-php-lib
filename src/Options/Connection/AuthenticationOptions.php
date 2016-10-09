<?php

namespace Tequila\MongoDB\Options\Connection;

use Tequila\MongoDB\Options\OptionsInterface;
use Tequila\MongoDB\Options\OptionsResolver;

class AuthenticationOptions implements OptionsInterface
{
    const AUTH_SOURCE = 'authSource';
    const AUTH_MECHANISM = 'authMechanism';

    public static function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            self::AUTH_SOURCE,
            self::AUTH_MECHANISM,
        ]);

        $resolver
            ->setAllowedTypes(self::AUTH_SOURCE, ['string'])
            ->setAllowedValues(self::AUTH_MECHANISM, [
                'SCRAM-SHA-1',
                'MONGODB-CR',
                'MONGODB-X509',
                'GSSAPI',
                'PLAIN',
            ]);
    }
}