<?php

namespace Smoren\Schemator\Components;

use Smoren\Schemator\Interfaces\SchematorInterface;
use Smoren\Schemator\Interfaces\MassSchematorInterface;
use Generator;

/**
 * Class for mass schematic data converting
 * @author Smoren <ofigate@gmail.com>
 */
class MassSchemator implements MassSchematorInterface
{
    /**
     * @var SchematorInterface Schemator instance
     */
    protected SchematorInterface $schemator;

    /**
     * MassSchemator constructor.
     * @param SchematorInterface $schemator Schemator instance
     */
    public function __construct(SchematorInterface $schemator)
    {
        $this->schemator = $schemator;
    }

    /**
     * @inheritDoc
     */
    public function generate(iterable $source, array $schema): Generator
    {
        foreach ($source as $item) {
            yield $this->schemator->convert($item, $schema);
        }
    }

    /**
     * @inheritDoc
     */
    public function convert(iterable $source, array $schema): array
    {
        $gen = $this->generate($source, $schema);
        $result = [];

        foreach ($gen as $item) {
            $result[] = $item;
        }

        return $result;
    }
}
