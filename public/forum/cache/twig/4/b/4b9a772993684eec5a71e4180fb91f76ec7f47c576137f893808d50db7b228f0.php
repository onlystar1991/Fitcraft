<?php

/* index_body.html */
class __TwigTemplate_4b9a772993684eec5a71e4180fb91f76ec7f47c576137f893808d50db7b228f0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $location = "overall_header.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_header.html", "index_body.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<div class=\"fancy-index\"></div>
";
        // line 4
        if ((isset($context["RECENT_TOPICS_DISPLAY"]) ? $context["RECENT_TOPICS_DISPLAY"] : null)) {
            echo "<div class=\"index-right\">";
        }
        // line 5
        echo "
\t";
        // line 6
        // line 7
        echo "
";
        // line 8
        if ((isset($context["RECENT_TOPICS_DISPLAY"]) ? $context["RECENT_TOPICS_DISPLAY"] : null)) {
            // line 9
            echo "\t";
            if (((isset($context["ADS_INDEX_CODE"]) ? $context["ADS_INDEX_CODE"] : null) &&  !(isset($context["S_IS_BOT"]) ? $context["S_IS_BOT"] : null))) {
                // line 10
                echo "\t<div class=\"misc-block advertisement\">";
                echo (isset($context["ADS_INDEX_CODE"]) ? $context["ADS_INDEX_CODE"] : null);
                echo "</div>
\t";
            }
            // line 12
            echo "</div><!-- /.index-right -->
<div class=\"index-left\">
";
        }
        // line 15
        echo "
";
        // line 16
        // line 17
        echo "
";
        // line 18
        $location = "forumlist_body.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("forumlist_body.html", "index_body.html", 18)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 19
        echo "
";
        // line 20
        // line 21
        // line 22
        echo "
";
        // line 23
        // line 24
        echo "
";
        // line 25
        if ((isset($context["RECENT_TOPICS_DISPLAY"]) ? $context["RECENT_TOPICS_DISPLAY"] : null)) {
            echo "</div><!-- /.index-left -->";
        }
        // line 26
        echo "<div class=\"clear\"></div>

";
        // line 28
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "index_body.html", 28)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "index_body.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 28,  97 => 26,  93 => 25,  90 => 24,  89 => 23,  86 => 22,  85 => 21,  84 => 20,  81 => 19,  69 => 18,  66 => 17,  65 => 16,  62 => 15,  57 => 12,  51 => 10,  48 => 9,  46 => 8,  43 => 7,  42 => 6,  39 => 5,  35 => 4,  31 => 2,  19 => 1,);
    }
}
