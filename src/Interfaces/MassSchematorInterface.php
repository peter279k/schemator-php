<?php

namespace Smoren\Schemator\Interfaces;

use Generator;
use Smoren\Schemator\Exceptions\SchematorException;

/**
 * Interface MassSchematorInterface
 * @author Smoren <ofigate@gmail.com>
 */
interface MassSchematorInterface
{
    /**
     * Makes a generator for converting every item in the source array by schemator
     * @param iterable $source iterable source of items to convert every one by schemator
     * @param array $schema schema for converting
     * @return Generator
     * @throws SchematorException
     */
    public function generate(iterable $source, array $schema): Generator;

    /**
     * Converts input data array with using schema
     * @param iterable $source iterable source of items to convert every one by schemator
     * @param array $schema schema for converting
     * @return array array of converted items
     * @throws SchematorException
     */
    public function exec(iterable $source, array $schema): array;
}
