<?php

declare(strict_types=1);

namespace Quillstack\ValidatorInterface;

/**
 * Base interface for Validator classes.
 */
interface ValidatorInterface
{
    /**
     * Validate method only validates. It doesn't set anything, you can implement your own setters, or pass your
     * parameters via construct. It should return true/bool value, or throw an exception in case of failure.
     *
     * @return bool
     */
    public function validate(): bool;
}
