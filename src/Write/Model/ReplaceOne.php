<?php

namespace Tequilla\MongoDB\Write\Model;

use Tequilla\MongoDB\Write\Bulk\BulkWrite;
use Tequilla\MongoDB\Write\Options\ReplaceOneOptions;
use Tequilla\MongoDB\Util\ValidatorUtils;

class ReplaceOne implements WriteModelInterface
{
    /**
     * @var array|object
     */
    private $filter;

    /**
     * @var array|object
     */
    private $replacement;

    /**
     * @var array
     */
    private $options;

    /**
     * @param $filter
     * @param $replacement
     * @param array $options
     */
    public function __construct($filter, $replacement, array $options = [])
    {
        ValidatorUtils::ensureValidFilter($filter);
        ValidatorUtils::ensureValidDocument($replacement);

        $this->filter = $filter;
        $this->replacement = $replacement;
        $this->options = ReplaceOneOptions::getCachedResolver()->resolve($options);
    }

    public function writeToBulk(BulkWrite $bulk)
    {
        $bulk->update($this->filter, $this->replacement, $this->options);
    }
}