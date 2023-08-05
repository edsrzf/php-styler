<?php
declare(strict_types=1);

namespace PhpStyler\Command;

use PhpParser\ParserFactory;
use PhpParser\Parser;
use PhpParser\Node\Stmt;
use PhpStyler\Printer;
use PhpStyler\Styler;
use UnexpectedValueException;
use RuntimeException;

abstract class Command
{
    protected Parser $parser;

    protected Printer $printer;

    protected Styler $styler;

    public function __construct()
    {
        $parserFactory = new ParserFactory();
        $this->parser = $parserFactory->create(ParserFactory::PREFER_PHP7);
        $this->printer = new Printer();
    }

    /**
     * @return mixed[]
     */
    protected function load(string $file) : array
    {
        return require $file;
    }

    protected function findConfigFile() : string
    {
        $file = dirname(__DIR__, 6) . DIRECTORY_SEPARATOR . ".php-styler.php";

        if (file_exists($file)) {
            return $file;
        }

        throw new RuntimeException("Could not find {$file}");
    }

    protected function lint(string $file) : bool
    {
        exec("php -l {$file}", $output, $return);

        if ($return !== 0) {
            echo implode(PHP_EOL, $output) . PHP_EOL;

            return false;
        }

        return true;
    }

    /**
     * @param mixed[] $config
     */
    protected function setStyler(array $config) : void
    {
        $styler = $config['styler'] ?? [];

        if ($styler instanceof Styler) {
            $this->styler = $styler;
        } elseif (is_array($styler)) {
            $this->styler = new Styler(...$styler);
        } else {
            throw new UnexpectedValueException(
                "Config key 'styler' misconfigured.",
            );
        }
    }

    protected function style(string $file) : string
    {
        /** @var string */
        $code = file_get_contents($file);

        /** @var Stmt[] */
        $stmts = $this->parser->parse($code);

        return $this->printer->printFile($stmts, $this->styler);
    }
}
