<?php

namespace App\Test\Psalm;

use PhpParser\Node;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\StatementsSource;
use Psalm\Storage\ClassLikeStorage;

class DtoObjectsShouldHaveNameEndingInData implements \Psalm\Plugin\Hook\AfterClassLikeAnalysisInterface
{
    public static function afterStatementAnalysis(Node\Stmt\ClassLike $stmt, ClassLikeStorage $classlike_storage, StatementsSource $statements_source, Codebase $codebase, array &$file_replacements = [])
    {
        $fullName = $statements_source->getFQCLN();

        $classIsInNamespaceData = false !== strpos($fullName, 'App\DTO');
        $classNameEndsInData = 'Data' === substr($fullName, -4);

        if (!$classIsInNamespaceData) {
            return;
        }

        if ($classNameEndsInData) {
            return;
        }

        if (\Psalm\IssueBuffer::accepts(
            new NoDtoWithWrongName(
                "La classe $fullName deve avere il nome che termina in 'Data'",
                new CodeLocation($statements_source, $stmt),
            ),
            $statements_source->getSuppressedIssues()
        )) {
        }
    }
}

class NoDtoWithWrongName extends \Psalm\Issue\PluginIssue
{
}
