<?php

namespace Phi\Module\DOMTemplate;



class Component extends PHPTemplate
{
    use Introspectable;


    protected $injectInlineAsset=false;
    protected $autoWrap=true;

    protected $output='';

    protected $debugMode=false;



    protected $configuration;




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


    public function getConfiguration() {
        if($this->configuration==null) {
            $this->configuration=$this->getDefaultConfiguration();
        }
        return $this->configuration;
    }


    public function getDefaultConfiguration() {
        return new DefaultConfiguration();
    }

    public function getFromConfiguration($variableName) {
        return $this->getConfiguration()->getVariable($variableName);
    }



    public function debug($value) {
        $this->debugMode=$value;
        return $this;
    }





    public function loadDataSource($name, $uri) {

        $routerClassName='\CapitalSite\Configuration\GlobalRouter';


        if(class_exists($routerClassName)) {

            $router=new $routerClassName;


            $request=new RouterRequest(array(
                'REQUEST_URI'=>$uri,
                'REQUEST_METHOD'=>'GET',
            ));



            $buffer=$router->ob_run($request);



            if($buffer!=='') {
                if($data=json_decode($buffer)) {
                    $this->setVariable($name, $data);
                }
                else {
                    $this->setVariable($name, $buffer);
                }

                return $this->getVariable($name);
            }
        }

        return false;

    }



    public function loadTemplate($template) {
        $templateFile=$this->getDefinitionFolder().'/template/'.$template;
        $this->template=$templateFile;
        return $this;
    }


    public function render($template=null) {


        if($template==null && $this->template==null) {
            $template=$this->getDefinitionFolder().'/template/default.php';
        }

        if(!is_file($template)) {

            $parentDefinitionFolders=$this->getParentClassesDefinitionFolders();
            foreach ($parentDefinitionFolders as $folder) {
                $defaultTemplate=$folder.'/template/default.php';
                if(is_file($defaultTemplate)) {
                    $template=$defaultTemplate;
                    break;
                }
            }
        }





        $output=parent::render($template);
        $mustacheEngine=new \Mustache_Engine();
        $compiled=$mustacheEngine->render($output, $this->getVariables());

        $this->output=$compiled;

        if($this->debugMode && 0) {
            $output=preg_replace('`^(.*?)>`s', '$1 data-component>', $this->output);
            //echo htmlentities($output);
            //die('EXIT '.__FILE__.'@'.__LINE__);
            return $output;

        }
        else {
            return $this->output;
        }
    }




    public function encapsulateHTML($output, $injectInlineAsset=false) {


        $componentName=$this->getClassBaseName();

        $css='';
        $javascript='';

        if($injectInlineAsset) {
            $css=$this->injectCSS()."\n";
            $javascript=$this->injectJavascript()."\n";
        }


        $componentCSSClassName=$this->getCSSClassName();


        $wrapper=$this->getVariable('HTMLTag');


        $prepend=$this->getVariable('prepend');
        $append=$this->getVariable('append');

        if(!$wrapper) {
            if($this->autoWrap) {
                $wrapper='div';
            }
        }


        if($wrapper) {
            return '<'.$wrapper.' class="'.$this->getFromConfiguration('componentCSSClassName').' '.$componentCSSClassName.' '.$this->getVariable('cssClass').'" '.$this->getVariable('customAttributesString').' >'.
            $prepend."\n".
            $css.
            $javascript.
            $output.
            $append."\n".
            '</'.$wrapper.'>';
        }
        else {
            return
            $prepend."\n".
            $css.
            $javascript.
            $output.
            $append."\n"
            ;
        }

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