<?php

declare(strict_types=1);

namespace Lmc\User\Mezzio\Validator;

use Override;

class NoRecordExists extends AbstractRecord
{
    /**
     * @param string $value
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    #[Override]
    public function isValid($value): bool
    {
        $this->setValue($value);

        if ($this->query($value)) {
            $this->error(self::ERROR_RECORD_FOUND, $value);
            return false;
        }
        return true;
    }
}
