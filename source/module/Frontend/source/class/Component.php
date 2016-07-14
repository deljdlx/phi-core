<?php

namespace Phi\Module\Frontend;


use Phi\PHPTemplate;
use Phi\Traits\Introspectable;



class Component extends PHPTemplate
{

    use Introspectable;
    protected $subComponents;



    public function extractSubComponents() {

    }



}



/*

class Component extends PHPTemplate
{
    use Introspectable;


    protected $injectInlineAsset=false;



    public function __construct($template=null) {
        if($template) {
            $this->template=$template;
        }
        else {
            $defaultTemplateFile=$this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('defaultComponentTemplateFile');
            if(is_file($defaultTemplateFile)) {
                $this->template=$defaultTemplateFile;
            }
        }
    }

    public function loadTemplate($template) {
        $templateFile=$this->getDefinitionFolder().'/template/'.$template;
        $this->template=$templateFile;
        return $this;
    }




    public function encapsulateHTML($output, $injectInlineAsset=false) {


        $componentName=$this->getClassBaseName();

        $publicPath='../source/class/Component/'.$componentName.'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder');

        //$output=preg_replace('`="\./`', '="'.$publicPath, $output);
        $output=preg_replace('`="/`', '="./', $output);

        $css='';
        $javascript='';

        if($injectInlineAsset) {
            $css=$this->injectCSS()."\n";
            $javascript=$this->injectJavascript()."\n";
        }


        $componentCSSClassName=$this->getCSSClassName();
        return '<div class="'.\CapitalSite\Frontend\getFromConfiguration('componentCSSClassName').' '.$componentCSSClassName.' ">'.
            $css.
            $javascript.
            $output.
        '</div>';
    }


    public function getCSSClassName() {
        return $this->getClassBaseName();
    }

    public function injectCSS() {
        $stylesheets=$this->getAssets($this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder').'*.css');

        $componentCSSClassName=$this->getCSSClassName();

        $styleBuffer='<style>'."\n";
        foreach ($stylesheets as $asset) {
            if(preg_match('`.css$`', $asset)) {
                $cssDeclaration=file_get_contents($asset);
                $cssDeclaration=preg_replace_callback('`^\s*((?:\w|\.)+?)\s*\{\s*$`m', function($matches) use ($componentCSSClassName) {
                    if(!preg_match('`^s*.'.$componentCSSClassName.'\s* {`', $matches[0])) {
                        return '.'.\CapitalSite\Frontend\getFromConfiguration('componentCSSClassName').'.'.$componentCSSClassName.' '.$matches[1].' {';
                    }
                    else {
                        return '.'.\CapitalSite\Frontend\getFromConfiguration('componentCSSClassName').$matches[1].' {';
                    }
                }, $cssDeclaration);
                $styleBuffer.=$cssDeclaration;
            }
        }
        $styleBuffer.='</style>'."\n";
        return $styleBuffer;
    }

    public function injectJavascript() {

        $javascripts=$this->getAssets($this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder').'*.js');



        $javascriptBuffer='<script>'."\n";
        foreach ($javascripts as $asset) {
            if(preg_match('`.js$`', $asset)) {
                $script=file_get_contents($asset);
                $javascriptBuffer.=$script;
            }
        }
        $javascriptBuffer.='</script>'."\n";
        return $javascriptBuffer;

    }




    public function getAssets($pattern=null, $flags=0) {

        if($pattern===null) {
            $pattern=$this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder').'*';
        }

        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->getAssets($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }



    public function getAssetFolder() {
        return $this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder');
    }

    public function deploy() {
        $source=$this->getAssetFolder();
        $destination=\CapitalSite\Frontend\getFromConfiguration('componentPublicFilepath').'/'.$this->getClassBaseName();

        if(!is_link($destination)) {
            symlink($source, $destination);
        }
        return $this;
    }
}


*/