<?php

namespace Rareloop\Twigcs\Ruleset;

use Allocine\Twigcs\Rule\UnusedMacro;
use Allocine\Twigcs\Rule\TrailingSpace;
use Allocine\Twigcs\Rule\TernarySpacing;
use Allocine\Twigcs\Rule\UnusedVariable;
use Allocine\Twigcs\Validator\Violation;
use Allocine\Twigcs\Rule\OperatorSpacing;
use Allocine\Twigcs\Rule\DelimiterSpacing;
use Allocine\Twigcs\Rule\ParenthesisSpacing;
use Allocine\Twigcs\Rule\PunctuationSpacing;
use Allocine\Twigcs\Ruleset\RulesetInterface;
use Allocine\Twigcs\Whitelist\TokenWhitelist;
use Allocine\Twigcs\Rule\HashSeparatorSpacing;
use Allocine\Twigcs\Rule\ArraySeparatorSpacing;
use Allocine\Twigcs\Rule\SliceShorthandSpacing;
use Rareloop\Twigcs\Rule\LowerCamelCaseVariable;

/**
 * The Rareloop twigcs ruleset
 *
 * Based on the official Symfony ruleset with a few exceptions (http://twig.sensiolabs.org/doc/coding_standards.html)
 *
 * Exceptions:
 * - Enforce lowerCamelCase variables instead of snakecase
 *
 * @author Tristan Maindron <tmaindron@gmail.com>
 */
class Rareloop implements RulesetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRules()
    {
        return [
            new DelimiterSpacing(Violation::SEVERITY_ERROR, 1),
            new ParenthesisSpacing(Violation::SEVERITY_ERROR, 0, 1),
            new ArraySeparatorSpacing(Violation::SEVERITY_ERROR, 0, 1),
            new HashSeparatorSpacing(Violation::SEVERITY_ERROR, 0, 1),
            new OperatorSpacing(Violation::SEVERITY_ERROR, [
                '==', '!=', '<', '>', '>=', '<=',
                '+', '-', '/', '*', '%', '//', '**',
                'not', 'and', 'or',
                '~',
                'is', 'in'
            ], 1),
            new PunctuationSpacing(
                Violation::SEVERITY_ERROR,
                ['|', '.', '..', '[', ']'],
                0,
                new TokenWhitelist([
                    ')',
                    \Twig\Token::NAME_TYPE,
                    \Twig\Token::NUMBER_TYPE,
                    \Twig\Token::STRING_TYPE
                ], [2])
            ),
            new TernarySpacing(Violation::SEVERITY_ERROR, 1),
            new LowerCamelCaseVariable(Violation::SEVERITY_ERROR),
            new UnusedVariable(Violation::SEVERITY_WARNING),
            new UnusedMacro(Violation::SEVERITY_WARNING),
            new SliceShorthandSpacing(Violation::SEVERITY_ERROR),
            new TrailingSpace(Violation::SEVERITY_ERROR),
        ];
    }
}
