<?php

class ms2PatternProductUri
{
    /** @var modX $modx */
    public $modx;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = $modx->getOption('ms2patternproducturi.core_path',$config, $modx->getOption('core_path',null,MODX_CORE_PATH).'components/ms2patternproducturi/');
        $assetsUrl = $modx->getOption('ms2patternproducturi.assets_url',$config, $modx->getOption('assets_url').'components/ms2patternproducturi/');
        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'jsUrl' => $assetsUrl.'js/'
        ], $config);

        $this->modx->addPackage('ms2patternproducturi', $this->config['modelPath']);
        $this->modx->lexicon->load('ms2patternproducturi:default');
    }

    public function generatePatternUri($resource) {

        if ($resource->get('class_key') == 'msProduct') {

            $getOptionPatternUri = $this->modx->getOption('ms2patternproducturi_product_as_uri');
            $getOptionPatternUriDebug = $this->modx->getOption('ms2patternproducturi_product_as_uri_debug');
            $getOldUri = $resource->get('uri');

            $outputContenerPetternUri = preg_replace('/\/.+/', '', $getOptionPatternUri);
            preg_match_all('~{([^{}]*)}~', $getOptionPatternUri, $renderDataPatternUri);

            $getContentType = $this->modx->getObject('modContentType', array('mime_type' => 'text/html'));
            $getContentTypeSuffix = $getContentType->get('file_extensions');

            $renderUri = $outputContenerPetternUri . '/' . $resource->get($renderDataPatternUri[1][0]) . $getContentTypeSuffix;

            $resource->set('uri' , $renderUri);
            if ($resource->get('uri_override') != true) {
                $resource->set('uri_override', true);
            }
            $resource->save();

            if ($getOldUri != $renderUri && $getOptionPatternUriDebug == 1) {
                $this->modx->log(1, '<b>ms2PatternProductUri:</b> изменен адрес ресурса <b>ID ' . $resource->get('id') . ' </b>' . $getOldUri . ' на ' . $renderUri);
            }

            if ($getOldUri != $renderUri) {

                $this->modx->addPackage('autoredirector', $this->modx->getOption('autoredirector_core_path', null ,$this->modx->getOption('core_path').'components/autoredirector/').'model/');

                $newRedirect = $this->modx->newObject('arRule');
                $newRedirect->set('res_id' , $resource->id);
                $newRedirect->set('context_key', $resource->context_key);
                $newRedirect->set('uri', $getOldUri);
                $newRedirect->save();

            }
        }
    }

    public function loadControllerJsCss($page) {
        if ($page == 'product_create' || $page == 'product_update') {
            $this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/ms2patternproducturi.js');
        }
    }
}