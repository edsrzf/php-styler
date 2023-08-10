# PHP Styler

**EXPERIMENTAL. NOT FOR PRODUCTION USE.**

PHP-Styler reconstructs PHP code after it has been deconstructed into an abstract syntax tree. It will **completely reformat** the code it is given, discarding any previous formatting entirely.

> McCoy: What if this thing were used where [formatting] already exists?
>
> Spock: It would destroy such [formatting] in favor of its new matrix.
>
> McCoy: Its new matrix? Do you have any idea what you're saying?
>
> Spock: I was not attempting to evaulate its [aesthetic] implications.
>
> -- Star Trek II: The Wrath of Khan (paraphrased)

PHP-Styler is a companion to [PHP-Parser](https://github.com/nikic/PHP-Parser). Whereas the PHP-Parser pretty printer does not have output customization as a main design goal, PHP-Styler does.

PHP-Styler is targeted toward declaration/definition files (class, interface, enum, trait) and script files.

PHP-Styler is **not appropriate** for PHP-based templates, as it does not use the alternative control structures. Perhaps a future release will include a custom _AlternativeStyler_ for PHP-based templates using alternative control structures.

## Design Goals

- **Logic Preservation.** Restructured PHP code will continue to operate as before.

- **Horizontal and Vertical Spacing.** Automatic, reasonable indenting and blank-line placement.

- **Line Length Control.** Automatic splitting across multiple lines when a single line is too long.

- **Diff-Friendly.** Default output should aid noise-reduction in diffs.

- **Customization.** Change the output style of printable elements by extending the _Styler_ and overriding the method for each _Printable_ you want to change.

- **Comment Preservation.** As much as the PHP-Parser will allow.

## Using PHP-Styler

### Installation

Use `composer` to add PHP-Styler as a dev requirement:

```
composer require --dev pmjones/php-styler 0.x-dev
```

Copy the default `php-styler.php` config file to your package root:

```
cp ./vendor/bin/pmjones/php-styler/php-styler.php .
```

### Preview Formatting

Preview how PHP-Styler will restructure a source PHP file:

```
./vendor/bin/php-styler preview ./src//My/Source/File.php
```

### Apply Formatting

Apply PHP-Styler to all files identified in the `php-styler.php` config file:

```
./vendor/bin/php-styler apply
```

Use `-c` or `--config` to specify an alternative config file:

```
./vendor/bin/php-styler apply -c /path/to/other/php-styler.php
```

PHP-Styler will track the last time it was applied in `.php-styler.cache` and only apply styling to files modified since that time. Use `-f` or `--force` to force PHP-Styler to apply styling regardless of modification time:

```
./vendor/bin/php-styler apply -f
```


### Configuration

TBD.


## How It Works

PHP-Styler uses a 3-pass system to reformat and style PHP code:

1. _PHPParser\Parser_ converts the code to an abstract syntax tree of _Node_ elements.
2. _PHPStyler\Printer_ flattens the _Node_ tree into a list of _Printable_ elements.
3. _PHPStyler\Styler_ converts each _Printable_ back into text; it applies horizontal spacing, vertical spacing, and line-splitting rules as it goes.


### Automatic Line-Splitting

At first, PHP-Styler builds each statement/instruction as a single line. If that line is "too long" (88 characters by default) the _Styler_ reconstructs the code by trying to split it across multiple lines. It does so by applying one or more rules in order:

- String concatenations are split at dots.
- Array elements are split at commas.
- Conditions are split at parentheses.
- Precedence-indicating parentheses are split.
- Boolean `||` operators are split.
- Boolean `&&` operators are split.
- Ternaries are split at `?` and `:`.
- Object member operators are split at `->` and `?->`.
- Argument lists are split at commas.
- Coalesce `??` operators are split;
- Function and method parameters are split at commas.
- Attribute arguments are split at commas.

If the first rule does not make the line short enough, the second rule is applied in addition, then the third, and so on.

Even after all rules are applied, the line may still end up "too long."

## Caveats

(These are not all-inclusive.)

PHP-Styler does not:

- rearrange or reorder code blocks
- separate imports into groups (use, use function, use const)
- split comment lines

PHP-Styler will de-align lines like this ...

```
$foo = 'longish'    . $bar
$foo = 'short'      . $bar;
$foo = 'muchlonger' . $bar;
```

... into this:

```
$foo = 'longish' . $bar
$foo = 'short' . $bar;
$foo = 'muchlonger' . $bar;
```

Comment lines are always attached to the following line, not the same or previous line. That is, leading or trailing comments *on the same line* may not appear where you expect. Likewise, comments intended to be attached to the *previous* line may end up attached to the *following* line. (This is a limitation of PHP-Parser.)

Inline comments after array elements will mess up indenting.

Comments on closure signatures will mess up indenting; the following is how PHP-Styler reformats one part of Laminas Escaper:

```php
$this->htmlAttrMatcher =

/** @param array<array-key, string> $matches */
function (array $matches) : string {
   return $this->htmlAttrMatcher($matches);
};
```

## Fixing Mangled Output

If PHP-Styler generates "ugly" or "weird" or "mangled" results, it might be a problem with how PHP-Styler works; please submit an issue.

Alternatively, it may be an indication that the source line(s) should be refactored. Here are some suggestions:

- Increase the maximum line length. The default length is 88 characters (10% more than the commonly-suggested 80-character length) to allow some wiggle room. However, some codebases tend to much longer lines, so increasing the line length may result in more-agreeable line splits.

- Break up a single long line into shorter multiple lines.

- Move inline conditions from the beginning or end of the line to *above* the line.

- Assign inline closures to variables.

## Comparable Offerings

[PHP CS Fixer](https://cs.symfony.com/) is the category leader here. It offers a huge range of customization options to fix (or not fix) specific elements of PHP code. However, it is extremely complex, and can be difficult to modify.

By comparison, PHP-Styler does not "fix" code; it restructures code entirely from an abstract syntax tree. It is also much less complex to modify.
