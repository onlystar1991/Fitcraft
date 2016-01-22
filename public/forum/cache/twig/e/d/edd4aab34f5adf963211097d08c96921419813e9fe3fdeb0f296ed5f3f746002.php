<?php

/* top_bar.html */
class __TwigTemplate_edd4aab34f5adf963211097d08c96921419813e9fe3fdeb0f296ed5f3f746002 extends Twig_Template
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
        echo "<div id=\"top-bar\">
\t<div class=\"inner\">
\t\t<ul class=\"linklist\">
\t\t\t<li class=\"small-icon link\">
                <a href=\"";
        // line 5
        if ((isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null)) {
            echo (isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null);
        } else {
            echo (isset($context["U_INDEX"]) ? $context["U_INDEX"] : null);
        }
        echo "\">Home</a>
            </li>

\t\t\t";
        // line 8
        // line 9
        echo "\t\t\t<li class=\"small-icon link rightside\"><a href=\"";
        if ((isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null)) {
            echo (isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null);
            echo "/logout";
        } else {
            echo (isset($context["U_LOGIN_LOGOUT"]) ? $context["U_LOGIN_LOGOUT"] : null);
        }
        echo "\" title=\"";
        echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
        echo "\" accesskey=\"x\" role=\"menuitem\">";
        echo $this->env->getExtension('phpbb')->lang("LOGIN_LOGOUT");
        echo "</a></li>
\t\t</ul>
\t</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "top_bar.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 9,  35 => 8,  25 => 5,  19 => 1,);
    }
}
