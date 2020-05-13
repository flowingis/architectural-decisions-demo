<?php

namespace App\Test;

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

        if (false === !strpos('App\\DTO', $fullName)) {
            return [];
        }

        if ('Data' === substr($fullName, -4)) {
            return [];
        }

        return [
            "La classe $fullName deve avere il nome che termina in 'Data'",
        ];
    }
}
