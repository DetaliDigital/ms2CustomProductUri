<?php
/**
 * ms2PatternProductUri
 * @package ms2patternproducturi
 */
/**
 * @var modX $modx
 * @var $resource
 * @var array $scriptProperties
 */

/** @var ms2PatternProductUri $ms2patternproducturi  */

$ms2PatternProductUri = $modx->getService('ms2patternproducturi', 'ms2PatternProductUri');

switch($modx->event->name)
{
    case 'OnDocFormSave':
        $ms2PatternProductUri->generatePatternUri($resource);
        break;
    case 'msOnManagerCustomCssJs':
        $ms2PatternProductUri->loadControllerJsCss($page);
        break;
}

return; 