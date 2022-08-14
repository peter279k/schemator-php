<?php


namespace Smoren\Schemator\Exceptions;


use Smoren\ExtendedExceptions\BaseException;
use Throwable;

/**
 * Class SchematorException
 * @author Smoren <ofigate@gmail.com>
 */
class SchematorException extends BaseException
{
    const FILTER_NOT_FOUND = 1;
    const FILTER_ERROR = 2;
    const CANNOT_GET_VALUE = 3;
    const UNSUPPORTED_SOURCE_TYPE = 4;
    const UNSUPPORTED_KEY_TYPE = 5;
    const UNSUPPORTED_FILTER_CONFIG_TYPE = 6;

    /**
     * Checks that filter exists in map
     * @param array $filterMap filters mapped by name
     * @param string $filterName name of filter
     * @throws SchematorException
     */
    public static function ensureFilterExists(array $filterMap, string $filterName): void
    {
        if(!isset($filterMap[$filterName])) {
            throw new SchematorException(
                "filter '{$filterName}' not found",
                SchematorException::FILTER_NOT_FOUND,
                null,
                [
                    'filter_name' => $filterName,
                ]
            );
        }
    }

    /**
     * Creates a new exception instance for filter execution error
     * @param string $filterName name of the filter
     * @param mixed $filterConfig arguments for filter
     * @param mixed $source source for filtering
     * @param Throwable $previous exception thrown in the filter body
     * @return SchematorException
     */
    public static function createAsFilterError(
        string $filterName, $filterConfig, $source, Throwable $previous
    ): SchematorException
    {
        return new SchematorException(
            "filter error: '{$filterName}'",
            SchematorException::FILTER_ERROR,
            $previous,
            [
                'error' => $previous->getMessage(),
                'filter_name' => $filterName,
                'config' => $filterConfig,
                'source' => $source,
            ]
        );
    }

    /**
     * Creates a new exception instance for "cannot get value" error
     * @param mixed $source data to get value from
     * @param string $key path key to get value by
     * @param Throwable|null $previous previous exception
     * @return SchematorException
     */
    public static function createAsCannotGetValue($source, string $key, ?Throwable $previous = null): SchematorException
    {
        return new SchematorException(
            "cannot get value by key '{$key}'",
            SchematorException::CANNOT_GET_VALUE,
            $previous,
            [
                'key' => $key,
                'source' => $source,
            ]
        );
    }

    /**
     * Creates a new exception instance for "unsupported source type" error
     * @param mixed $source source
     * @param mixed $key path key to get value by
     * @param Throwable|null $previous previous exception
     * @return SchematorException
     */
    public static function createAsUnsupportedSourceType($source, $key, ?Throwable $previous = null): SchematorException
    {
        $sourceType = gettype($source);
        return new SchematorException(
            "unsupported source type '{$sourceType}'",
            SchematorException::UNSUPPORTED_SOURCE_TYPE,
            $previous,
            [
                'key' => $key,
                'source' => $source,
                'source_type' => $sourceType,
            ]
        );
    }

    /**
     * Creates a new exception instance for "unsupported key type" error
     * @param mixed $source source
     * @param mixed $key path key to get value by
     * @param Throwable|null $previous previous exception
     * @return SchematorException
     */
    public static function createAsUnsupportedKeyType($source, $key, ?Throwable $previous = null): SchematorException
    {
        $keyType = gettype($key);
        return new SchematorException(
            "unsupported key type '{$keyType}'",
            SchematorException::UNSUPPORTED_KEY_TYPE,
            $previous,
            [
                'key' => $key,
                'source' => $source,
                'key_type' => $keyType,
            ]
        );
    }

    /**
     * Creates a new exception instance for "unsupported filter config type" error
     * @param mixed $filterConfig filter config
     * @param Throwable|null $previous previous exception
     * @return SchematorException
     */
    public static function createAsUnsupportedFilterConfigType($filterConfig, ?Throwable $previous = null): SchematorException
    {
        $filterConfigType = gettype($filterConfig);
        return new SchematorException(
            "unsupported filter config type '{$filterConfigType}'",
            SchematorException::UNSUPPORTED_FILTER_CONFIG_TYPE,
            $previous,
            [
                'filter_config' => $filterConfig,
                'filter_config_type' => $filterConfigType,
            ]
        );
    }
}
