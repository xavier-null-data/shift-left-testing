<?php

namespace PHPStanRules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Regla para evitar que alguien use where('organization_id', ...)
 * directo en código. La idea es forzar a pasar por un repositorio o policy.
 *
 * @implements Rule<MethodCall>
 */
class NoDirectWhereOnOrganizationIdRule implements Rule
{
    // esta regla solo se aplica a llamadas de métodos tipo ->where()
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        // si el nodo no tiene nombre o no es un método, ignoramos
        if (!property_exists($node, 'name') || !($node->name instanceof Identifier)) {
            return [];
        }

        // nombre del método, ej: where, orWhere, etc
        $methodName = $node->name->toString();

        // solo nos interesa el método where()
        if ($methodName !== 'where') {
            return [];
        }

        // si el primer argumento del where es "organization_id", marcamos alerta
        if (isset($node->args[0]) && $node->args[0]->value instanceof Node\Scalar\String_) {
            $arg = $node->args[0]->value->value;

            if ($arg === 'organization_id') {
                return [
                    RuleErrorBuilder::message(
                        "Uso directo de where('organization_id') detectado. Usa un repositorio o verifica permisos antes de filtrar por organización."
                    )->build(),
                ];
            }
        }

        return [];
    }
}
