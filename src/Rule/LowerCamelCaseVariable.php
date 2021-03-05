<?php

namespace Rareloop\Twigcs\Rule;

use FriendsOfTwig\Twigcs\Lexer;
use FriendsOfTwig\Twigcs\TwigPort\Token;
use FriendsOfTwig\Twigcs\Rule\AbstractRule;
use FriendsOfTwig\Twigcs\Rule\RuleInterface;
use FriendsOfTwig\Twigcs\TwigPort\TokenStream;

class LowerCamelCaseVariable extends AbstractRule implements RuleInterface
{
    public function check(TokenStream $tokens)
    {
        $violations = [];

        while (!$tokens->isEOF()) {
            $token = $tokens->getCurrent();

            if ($token->getType() === Token::NAME_TYPE && $this->isNotLowerCamelCase($token->getValue())) {
                if ($tokens->look(Lexer::PREVIOUS_TOKEN)->getType() === Token::WHITESPACE_TYPE && $tokens->look(-2)->getValue() === 'set') {
                    $violations[] = $this->createViolation(
                        $tokens->getSourceContext()->getPath(),
                        $token->getLine(),
                        $token->columnno,
                        sprintf('The "%s" variable should be in lowerCamelCase.', $token->getValue())
                    );
                }
            }

            $tokens->next();
        }

        return $violations;
    }

    private function isNotLowerCamelCase(string $string): bool
    {
        return !preg_match('/^[a-z]+((\d)|([A-Z0-9][a-z0-9]+))*([A-Z])?$/', $string);
    }
}
