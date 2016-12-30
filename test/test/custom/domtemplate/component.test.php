<?php


require(__DIR__.'/../../../bootstrap.php');


$template='<button>Composant bouton</button>';
$test=new \Phi\Module\DOMTemplate\Component($template);
echo $test->render();
echo '<hr/>';


$template='
    <button>{{{content}}}</button>
';
$test=new \Phi\Module\DOMTemplate\Component($template);
$test->setVariable('content', 'Contenu injecté');
echo $test->render();
echo '<hr/>';








$template='
    <button>Sous composant</button>
';
$subComponent=new \Phi\Module\DOMTemplate\Component($template);

$template='
    <div style="border: solid 3px #002a80; padding: 10px;">Composant container <div>{{{content}}}</div></div>
';
$component=new \Phi\Module\DOMTemplate\Component($template);
$component->setVariable('content', $subComponent);
echo $component->render();
echo '<hr/>';









$template='
    <div style="border: solid 3px #002a80; padding: 10px;">
        <div>{{{content}}}</div>
        <div>Injection de texte</div>
       <div>
            <phi-component></phi-component>
       </div>
    </div>
';

$test=new \Phi\Module\DOMTemplate\Component($template);
$test->setVariable('content', '::Variable mustache "content"::');
$test->registerCustomTag('phi-component', function() {
    return '{{{Contenu texte}}}';
});
echo $test->render();
echo '<hr/>';

//=======================================================


$template='
    <div style="border: solid 3px #002a80; padding: 10px;">
        <div>{{{content}}}</div>

        Composant container

       <div>
            <phi-component data-instanceof="TestComponent">

            </phi-component>
       </div>
    </div>
';

$test=new \Phi\Module\DOMTemplate\Template($template);
$test->registerCustomTag('phi-component', function() {
   return '<button>Custom tag phi-component</button>';
});
$test->setVariable('content', 'Contenu injecté');
echo $test->render();
echo '<hr/>';



//=======================================================


class TestComponent extends \Phi\Module\DOMTemplate\Component
{
    public function render($template=null, $values=null) {
        return $this->getVariable('content');
    }
}


$template='
    <div style="border: solid 3px #002a80; padding: 10px;">
        <div>{{{content}}}</div>

        Composant container avec composant

       <div>

            <phi-component data-instanceof="TestComponent">
                <meta  data-attribute-name="content"><![CDATA[
                    Test :
                    <span style="border: solid 5px #ffe57f">
                        hello
                    </span>
                    ]]>
                </meta>
            </phi-component>



       </div>
    </div>
';

$test=new \Phi\Module\DOMTemplate\Template($template);
$test->setVariable('content', 'Contenu injecté');
$test->enableComponents(true);

echo 'ici';
echo $test->render();
echo '<hr/>';

//=======================================================










