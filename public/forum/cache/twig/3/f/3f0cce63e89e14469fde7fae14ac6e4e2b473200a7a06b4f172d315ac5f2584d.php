<?php

/* permission_forum_copy.html */
class __TwigTemplate_3f0cce63e89e14469fde7fae14ac6e4e2b473200a7a06b4f172d315ac5f2584d extends Twig_Template
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
        $this->loadTemplate("overall_header.html", "permission_forum_copy.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<a id=\"maincontent\"></a>

\t<h1>";
        // line 5
        echo $this->env->getExtension('phpbb')->lang("ACP_FORUM_PERMISSIONS_COPY");
        echo "</h1>

\t";
        // line 7
        echo $this->env->getExtension('phpbb')->lang("ACP_FORUM_PERMISSIONS_COPY_EXPLAIN");
        echo "

\t<form id=\"forum_perm_copy\" method=\"post\" action=\"";
        // line 9
        echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
        echo "\">

\t<fieldset>
\t\t<legend>";
        // line 12
        echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
        echo "</legend>

\t\t<dl>
\t\t\t<dt><label for=\"src_forum\">";
        // line 15
        echo $this->env->getExtension('phpbb')->lang("COPY_PERMISSIONS_FROM");
        echo $this->env->getExtension('phpbb')->lang("COLON");
        echo "</label><br /><span>";
        echo $this->env->getExtension('phpbb')->lang("COPY_PERMISSIONS_FORUM_FROM_EXPLAIN");
        echo "</span></dt>
\t\t\t<dd><select id=\"src_forum\" name=\"src_forum_id\"><option value=\"0\">";
        // line 16
        echo $this->env->getExtension('phpbb')->lang("SELECT_FORUM");
        echo "</option><option value=\"-1\">------------------</option>";
        echo (isset($context["S_FORUM_OPTIONS"]) ? $context["S_FORUM_OPTIONS"] : null);
        echo "</select></dd>
\t\t</dl>
\t</fieldset>

\t<fieldset>
\t\t<legend>";
        // line 21
        echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
        echo "</legend>
\t\t<p>";
        // line 22
        echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUMS_EXPLAIN");
        echo "</p>

\t\t<dl>
\t\t\t<dt><label for=\"dest_forums\">";
        // line 25
        echo $this->env->getExtension('phpbb')->lang("COPY_PERMISSIONS_TO");
        echo $this->env->getExtension('phpbb')->lang("COLON");
        echo "</label><br /><span>";
        echo $this->env->getExtension('phpbb')->lang("COPY_PERMISSIONS_FORUM_TO_EXPLAIN");
        echo "</span></dt>
\t\t\t<dd><select id=\"dest_forums\" name=\"dest_forum_ids[]\" multiple=\"multiple\" size=\"10\">";
        // line 26
        echo (isset($context["S_FORUM_OPTIONS"]) ? $context["S_FORUM_OPTIONS"] : null);
        echo "</select></dd>
\t\t</dl>
\t</fieldset>

\t<fieldset class=\"submit-buttons\">
\t\t<legend>";
        // line 31
        echo $this->env->getExtension('phpbb')->lang("SUBMIT");
        echo "</legend>
\t\t<input class=\"button1\" type=\"submit\" id=\"submit\" name=\"submit\" value=\"";
        // line 32
        echo $this->env->getExtension('phpbb')->lang("SUBMIT");
        echo "\" />&nbsp;
\t\t<input class=\"button2\" type=\"reset\" id=\"reset\" name=\"reset\" value=\"";
        // line 33
        echo $this->env->getExtension('phpbb')->lang("RESET");
        echo "\" />
\t\t";
        // line 34
        echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
        echo "
\t\t";
        // line 35
        echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
        echo "
\t</fieldset>

\t</form>

";
        // line 40
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "permission_forum_copy.html", 40)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "permission_forum_copy.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 40,  116 => 35,  112 => 34,  108 => 33,  104 => 32,  100 => 31,  92 => 26,  85 => 25,  79 => 22,  75 => 21,  65 => 16,  58 => 15,  52 => 12,  46 => 9,  41 => 7,  36 => 5,  31 => 2,  19 => 1,);
    }
}
