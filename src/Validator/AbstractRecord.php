<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Validator;

use Laminas\Validator\AbstractValidator;
use Lmc\User\Mezzio\Exception\InvalidConfigurationException;
use Lmc\User\Repository\AdapterInterface;

use function array_key_exists;

abstract class AbstractRecord extends AbstractValidator
{
    public const string ERROR_NO_RECORD_FOUND = 'noRecordFound';
    public const string ERROR_RECORD_FOUND    = 'recordFound';

    protected string $key;
    protected AdapterInterface $mapper;

    /**
     * @param array{key: string, mapper: AdapterInterface} $options
     */
    public function __construct(
        private readonly array $options,
    ) {
        if (! array_key_exists('key', $options)) {
            throw new InvalidConfigurationException('Option "key" is required.');
        }
        if (! array_key_exists('mapper', $options)) {
            throw new InvalidConfigurationException('Option "mapper" is required.');
        }
        $this->key    = $options['key'];
        $this->mapper = $options['mapper'];
        parent::__construct($this->options);
    }

    protected function query(string $value): bool
    {
        return match ($this->key) {
            'email' => $this->mapper->findByEmail($value) !== null,
            'username' => $this->mapper->findByUsername($value) !== null,
            default => throw new InvalidConfigurationException("Invalid key"),
        };
    }
}
