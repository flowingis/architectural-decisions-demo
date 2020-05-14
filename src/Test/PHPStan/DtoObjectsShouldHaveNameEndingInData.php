<?php

namespace App\Test\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class DtoObjectsShouldHaveNameEndingInData implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Identifier) {
            return [];
        }

        $fullName = $node->namespacedName->toString();

        $classIsInNamespaceDto = strpos($fullName, 'App\DTO') !== false;
        $classNameEndsInData = substr($fullName, -4) === 'Data';

        if (!$classIsInNamespaceDto) {
            return [];
        }

        if ($classNameEndsInData) {
            return [];
        }

        return ["La classe $fullName deve avere il nome che termina in 'Data'"];
    }
}
