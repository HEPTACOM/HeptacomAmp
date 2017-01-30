<?php

function smarty_function_amplifyCss(array $params, &$smarty)
{
    if (!array_key_exists('file', $params)) {
        return;
    }

    $path = realpath(implode(DIRECTORY_SEPARATOR, [
        Shopware()->DocPath(),
        substr($params['file'], strlen(Shopware()->Front()->Request()->getBaseUrl()))
    ]));

    $css = file_get_contents($path);

    // PARSE, REDUCE, OPTIMIZE AND MINIFY CSS HERE

    return $css;
}
