<?php

namespace Phi\Module\DOMTemplate;


class Layout extends Component
{


    protected static $templateFolderName='template';
    protected static $defaultTemplateFilename='template.php';

    protected $skipPlaceholderContainer=true;




    protected $descriptor;




    public function skipPlaceholderContainer($value=null) {
        if($value===null) {
            return $this->skipPlaceholderContainer;
        }
        else {
            $this->skipPlaceholderContainer=$value;
        }

        return $this;
    }


    public function setDescriptor($descriptor) {
        $this->descriptor=$descriptor;
    }




    public function encapsulateHTML($output, $injectInlineAsset=false) {


        $componentName=$this->getClassBaseName();
        //$publicPath='../source/class/Layout/'.$componentName.'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder');
        //$output=preg_replace('`="\./`', '="'.$publicPath, $output);
        $output=preg_replace('`="/`', '="./', $output);


        return preg_replace('`</head>`i', ''.$this->injectCSS()."\n".'</head>', $output);


    }




    public function getPrependedAssets() {
        return array();
    }

    public function getAppendedAssets() {
        return array();
    }





    public function prependAssets($buffer) {
        $prependedAssets=$this->getPrependedAssets();
        $assetBuffer='';
        foreach ($prependedAssets as $asset) {
            if(strpos($asset, '.js')) {
                $assetBuffer.='<script src="'.$asset.'"></script>';
            }
            else if(strpos($asset, '.css')) {
                $assetBuffer.='<link rel="stylesheet" href="'.$asset.'"/>';
            }
        }

        $buffer=preg_replace('`(<head((\s+[^>]*?>)|>))`i',  '$1'."\n".$assetBuffer, $buffer);
        return $buffer;
    }

    public function appendAssets($buffer) {
        $appendedAssets=$this->getAppendedAssets();
        $assetBuffer='';
        foreach ($appendedAssets as $asset) {
            if(strpos($asset, '.js')) {
                $assetBuffer.='<script src="'.$asset.'"></script>';
            }
            else if(strpos($asset, '.css')) {
                $assetBuffer.='<link rel="stylesheet" href="'.$asset.'"/>';
            }
        }

        $buffer=preg_replace('`(</head>)`i', $assetBuffer."\n".'$1', $buffer);

        return $buffer;

    }



    public function render($template=null) {


        if($template===null) {

            $templateFile=$this->getDefaultTemplateFileName();

            if($templateFile) {

                $output=parent::render($templateFile);

                $domEngine=new DOMTemplate($output);
                $output=$domEngine->compile();

                $dom=new \CapitalSite\Frontend\Bridge\DOMTemplate($output);
                $dom->skipPlaceholderContainer($this->skipPlaceholderContainer());
                $output=$dom->compile($this->descriptor);

                $output=$this->prependAssets($output);
                $output=$this->appendAssets($output);
                $output=preg_replace('`(</body.*?>)`i', $this->append().'$1', $output);
                return $output;
            }
        }

        return '';
    }






    public function injectCSS() {

        $assets=$this->getAssets($this->getDefinitionFolder().'/'.\CapitalSite\Frontend\getFromConfiguration('assetFolder').'*.*');

        $styleBuffer='<style>'."\n";
        foreach ($assets as $asset) {
            if(preg_match('`.css$`', $asset)) {
                $cssDeclaration=file_get_contents($asset);
                $styleBuffer.=$cssDeclaration;
            }
        }
        $styleBuffer.='</style>'."\n";
        return $styleBuffer;
    }

    public function deploy() {
        $source=$this->getAssetFolder();
        $destination=\CapitalSite\Frontend\getFromConfiguration('layoutPublicFilepath').'/'.$this->getClassBaseName();

        if(!is_link($destination)) {
            symlink($source, $destination);
        }
        return $this;
    }



    public function getDefaultTemplateFileName() {

        $path=$this->getDefinitionFolder();

        $templateFilename=$path.'/'.static::$templateFolderName.'/'.static::$defaultTemplateFilename;
        if(is_file($templateFilename)) {
            return $templateFilename;
        }
        else {
            $parentClassNames=$this->getParentClassNames();

            foreach ($parentClassNames as $className) {
                $reflector=new \ReflectionClass($className);
                $definitionFile=$reflector->getFileName();
                $definitionFolder=dirname($definitionFile);

                $templateFilename=$definitionFolder.'/'.static::$templateFolderName.'/'.static::$defaultTemplateFilename;
                if(is_file($templateFilename)) {
                    return $templateFilename;
                }
            }
        }
        return false;

    }




    public function append() {
        return '';
    }


}