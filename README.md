# Rareloop Twig Coding Standards

This is a custom ruleset for [Twigcs](https://github.com/friendsoftwig/twigcs).

It follows the [official Twig coding style](http://twig.sensiolabs.org/doc/coding_standards.html) with the following exceptions:

- Use `lowerCamelCase` variables instead of `snake_case`
- Enforces 1 space inside a hash e.g. `{ key: expr, key: expr }` instead of the default `{key: expr, key: expr}`

## Installation

`composer require rareloop/twigcs-ruleset --dev`

## Usage

`twigcs path/to/files --ruleset \\Rareloop\\Twigcs\\Ruleset\\Rareloop`