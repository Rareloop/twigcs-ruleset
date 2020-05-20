<?php

namespace Rareloop\Twigcs\Rule;

use Allocine\Twigcs\Lexer;
use Allocine\Twigcs\Token;
use Allocine\Twigcs\Rule\AbstractRule;
use Allocine\Twigcs\Rule\RuleInterface;

class LowerCamelCaseVariable extends AbstractRule implements RuleInterface
{
    public function check(\Twig\TokenStream $tokens)
    {
        $this->reset();

        while (!$tokens->isEOF()) {
            $token = $tokens->getCurrent();

            if ($token->getType() === \Twig\Token::NAME_TYPE && $this->isNotLowerCamelCase($token->getValue())) {
                if ($tokens->look(Lexer::PREVIOUS_TOKEN)->getType() === Token::WHITESPACE_TYPE && $tokens->look(-2)->getValue() === 'set') {
                    $this->addViolation(
                        $tokens->getSourceContext()->getPath(),
                        $token->getLine(),
                        $token->columnno,
                        sprintf('The "%s" variable should be in lowerCamelCase.', $token->getValue())
                    );
                }
            }

            $tokens->next();
        }

        return $this->violations;
    }

    private function isNotLowerCamelCase(string $string): bool
    {
        return !preg_match('/^[a-z]+((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $string);
    }
}
