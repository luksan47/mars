<?php

if (! function_exists('var_export54')) {
    function var_export54($var, $indent = '')
    {
        switch (gettype($var)) {
            case 'string':
                return '\''.addcslashes($var, "\\\$\"\'\r\n\t\v\f").'\'';
            case 'array':
                if(count($var) == 0) {
                    return "[]";
                }
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        .($indexed ? '' : var_export54($key).' => ')
                        .var_export54($value, "$indent    ");
                }

                return "[\n".implode(",\n", $r).",\n".$indent.']';
            case 'boolean':
                return $var ? 'TRUE' : 'FALSE';
            default:
                return var_export($var, true);
        }
    }
}
if (! function_exists('generate_file')) {
    function generate_file($path, $expressions)
    {
        return fwrite($path, "<?php\n\nreturn ".var_export54($expressions).";\n");
    }
}
