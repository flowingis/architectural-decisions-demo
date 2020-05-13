<?php

namespace App\Test\EasyCs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;

class DtoObjectsShouldHaveNameEndingInData implements Sniff
{
    /**
     * @return array<int, (int|string)>
     */
    public function register(): array
    {
        return [
            T_CLASS,
        ];
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     *
     * @param int $pointer
     */
    public function process(File $phpcsFile, $pointer): void
    {
        $fullName = ClassHelper::getFullyQualifiedName($phpcsFile, $pointer);

        $classIsInNamespaceData = strpos($fullName, 'App\DTO') !== false;
        $classNameEndsInData = substr($fullName, -4) === 'Data';

        if (!$classIsInNamespaceData) {
            return;
        }

        if ($classNameEndsInData) {
            return;
        }

        $phpcsFile->addError(
            "La classe $fullName deve avere il nome che termina in 'Data'",
            $pointer,
            self::class
        );
    }
}
