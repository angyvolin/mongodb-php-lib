<?php

namespace Tequila\MongoDB\Write\Model;

use Tequila\MongoDB\BulkWrite;
use Tequila\MongoDB\Exception\InvalidArgumentException;
use Tequila\MongoDB\WriteModelInterface;
use function Tequila\MongoDB\ensureValidDocument;

class InsertOne implements WriteModelInterface
{
    /**
     * @var array|object
     */
    private $document;

    /**
     * @param array|object $document
     */
    public function __construct($document)
    {
        if (!is_array($document) && !is_object($document)) {
            throw new InvalidArgumentException(
                sprintf(
                    '$document must be an array or an object, %s given.',
                    \Tequila\MongoDB\getType($document)
                )
            );
        }

        try {
            ensureValidDocument($document);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException(
                sprintf('Invalid $document: %s', $e->getMessage())
            );
        }

        $this->document = $document;
    }

    public function writeToBulk(BulkWrite $bulk)
    {
        $bulk->insert($this->document);
    }
}
