<?php

/* message_body.html */
class __TwigTemplate_7748d0267e62a752c7d1197ee0c159bc0cc198bb898af764e0a1bd81d93967c8 extends Twig_Template
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
        $this->loadTemplate("overall_header.html", "message_body.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<div ";
        // line 3
        if ((isset($context["S_USER_NOTICE"]) ? $context["S_USER_NOTICE"] : null)) {
            echo "class=\"successbox\"";
        } else {
            echo "class=\"errorbox\"";
        }
        echo ">
\t<h3>";
        // line 4
        echo (isset($context["MESSAGE_TITLE"]) ? $context["MESSAGE_TITLE"] : null);
        echo "</h3>
\t<p>";
        // line 5
        echo (isset($context["MESSAGE_TEXT"]) ? $context["MESSAGE_TEXT"] : null);
        echo "</p>
</div>

";
        // line 8
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "message_body.html", 8)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "message_body.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 8,  46 => 5,  42 => 4,  34 => 3,  31 => 2,  19 => 1,);
    }
}
