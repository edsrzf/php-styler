<?php
$foo = function ($bar) use ($baz) : mixed {
    $i ++;
};
$dib = function () {
    $i ++;
};
$veryLongVariableName = function (
    $veryLongVar1,
    $veryLongVar2,
) use (
    $veryLongVar3,
    $veryLongVar4,
) {
    $i ++;
};
foo(
    function () {
        /* code */
    },
);
foo(
    $bar,
    function () {
        /* code */
    },
);
foo(
    function () {
        /* code */
    },
    $baz,
);
foo(
    $bar,
    function () {
        /* code */
    },
    $baz,
);
$result = $this
    ->veryLongProperty
    ->veryLongMethod(
        $veryLongVariableName,
        new VeryLongClassName(
            static function () : void {
                throw VeryLongException::create();
            },
            $this->veryLongVariableName,
        ),
    );
$shortVar = array_reduce(
    $foo,
    function ($addr, $addrs) {
        if (
            'REMOTE_ADDR' !== $addr
        ) {
            $addrs[] = $addr;
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $addrs[] = $_SERVER['REMOTE_ADDR'];
        }

        return $addr;
    },
    [],
);

class foo
{
    public function bar(baz $e)
    {
        $result = $this
            ->func
            ->proc(
                $psr7Request,
                new VeryLongClassName(
                    static function () : void {
                        throw ReachedFinalHandlerException::create();
                    },
                    $this->veryLongProperty,
                ),
            );
        $e->setResult($result);
        return $result;
    }
}

// long params, no uses
$foo = function (
    $veryVeryVeryVeryLongParameter,
    $veryVeryVeryVeryLongerParameter,
    $veryVeryVeryVeryMuchLongerParameter,
) {
    // body
};

// no params, long uses
$foo = function () use (
    $veryVeryVeryVeryLongVar1,
    $veryVeryVeryVeryLongerVar2,
    $veryVeryVeryVeryMuchLongerVar3,
) {
    // body
};

// long params, long uses
$foo = function (
    $veryVeryVeryVeryLongParameter,
    $veryVeryVeryVeryLongerParameter,
    $veryVeryVeryVeryMuchLongerParameter,
) use (
    $veryVeryVeryVeryLongVar1,
    $veryVeryVeryVeryLongerVar2,
    $veryVeryVeryVeryMuchLongerVar3,
) {
    // body
};

// long params, short uses
$foo = function (
    $veryVeryVeryVeryLongParameter,
    $veryVeryVeryVeryLongerParameter,
    $veryVeryVeryVeryMuchLongerParameter,
) use (
    $var1,
) {
    // body
};

// short params, long uses
$foo = function (
    $parameter,
) use (
    $veryVeryVeryVeryLongVar1,
    $veryVeryVeryVeryLongerVar2,
    $veryVeryVeryVeryMuchLongerVar3,
) {
    // body
};
