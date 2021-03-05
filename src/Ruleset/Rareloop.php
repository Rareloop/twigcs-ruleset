<?php

namespace Rareloop\Twigcs\Ruleset;

use FriendsOfTwig\Twigcs\Rule;
use FriendsOfTwig\Twigcs\Validator\Violation;
use FriendsOfTwig\Twigcs\RegEngine\RulesetBuilder;
use FriendsOfTwig\Twigcs\Ruleset\RulesetInterface;
use FriendsOfTwig\Twigcs\RegEngine\RulesetConfigurator;
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
    private $twigMajorVersion;

    public function __construct(int $twigMajorVersion)
    {
        $this->twigMajorVersion = $twigMajorVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function getRules()
    {
        $configurator = new RulesetConfigurator();
        $configurator->setTwigMajorVersion($this->twigMajorVersion);
        $configurator->setHashSpacingPattern('{ key: expr, key: expr }');
        $builder = new RulesetBuilder($configurator);

        return [
            new LowerCamelCaseVariable(Violation::SEVERITY_ERROR),
            new Rule\RegEngineRule(Violation::SEVERITY_ERROR, $builder->build()),
            new Rule\TrailingSpace(Violation::SEVERITY_ERROR),
            new Rule\UnusedMacro(Violation::SEVERITY_WARNING),
            new Rule\UnusedVariable(Violation::SEVERITY_WARNING),
        ];
    }
}
