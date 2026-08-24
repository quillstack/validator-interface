<?php

declare(strict_types=1);

namespace Quillstack\ValidatorInterface\Tests\Unit;

use Quillstack\ValidatorInterface\ValidationExceptionInterface;
use Quillstack\ValidatorInterface\ValidatorExceptionInterface;
use Quillstack\ValidatorInterface\ValidatorInterface;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\Types\AssertBoolean;
use ReflectionClass;

/**
 * What this package promises.
 *
 * A signature that moves here moves in everything that implements or depends on it, which is the
 * only thing there is to test in a package containing no code.
 */
class TestContract
{
    public function __construct(
        private AssertEqual $assertEqual,
        private AssertBoolean $assertBoolean
    ) {
        //
    }

    public function aValidatorAnswersOneQuestion()
    {
        $reflection = new ReflectionClass(ValidatorInterface::class);
        $names = array_map(static fn (\ReflectionMethod $m): string => $m->getName(), $reflection->getMethods());

        $this->assertEqual->equal(['validate'], $names);
        $this->assertEqual->equal(0, $reflection->getMethod('validate')->getNumberOfRequiredParameters());
        $this->assertEqual->equal('bool', (string) $reflection->getMethod('validate')->getReturnType());
    }

    /**
     * The exception a caller catches is the general one, so catching it catches whatever a
     * particular validator throws.
     */
    public function aValidationFailureIsAValidatorFailure()
    {
        $this->assertBoolean->isTrue(
            (new ReflectionClass(ValidationExceptionInterface::class))
                ->isSubclassOf(ValidatorExceptionInterface::class)
        );
    }

    public function theseAreInterfacesAndNothingElse()
    {
        foreach ([ValidatorInterface::class, ValidatorExceptionInterface::class, ValidationExceptionInterface::class] as $name) {
            $this->assertBoolean->isTrue((new ReflectionClass($name))->isInterface());
        }
    }
}
