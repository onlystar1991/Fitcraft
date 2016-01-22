<?php

/* simple_header.html */
class __TwigTemplate_9cbb186623c676d9567905f028a54d05fc56102fe6b406659e4575408d12e29a extends Twig_Template
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
        echo "<!DOCTYPE html>
<html dir=\"";
        // line 2
        echo (isset($context["S_CONTENT_DIRECTION"]) ? $context["S_CONTENT_DIRECTION"] : null);
        echo "\" lang=\"";
        echo (isset($context["S_USER_LANG"]) ? $context["S_USER_LANG"] : null);
        echo "\">
<head>
<meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width\" />
";
        // line 6
        echo (isset($context["META"]) ? $context["META"] : null);
        echo "
<title>";
        // line 7
        echo (isset($context["SITENAME"]) ? $context["SITENAME"] : null);
        echo " &bull; ";
        if ((isset($context["S_IN_MCP"]) ? $context["S_IN_MCP"] : null)) {
            echo $this->env->getExtension('phpbb')->lang("MCP");
            echo " &bull; ";
        } elseif ((isset($context["S_IN_UCP"]) ? $context["S_IN_UCP"] : null)) {
            echo $this->env->getExtension('phpbb')->lang("UCP");
            echo " &bull; ";
        }
        echo (isset($context["PAGE_TITLE"]) ? $context["PAGE_TITLE"] : null);
        echo "</title>

\t<link href=\"";
        // line 9
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/print.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"print\" title=\"printonly\" />
\t";
        // line 10
        if ((isset($context["S_ALLOW_CDN"]) ? $context["S_ALLOW_CDN"] : null)) {
            echo "<link href=\"//fonts.googleapis.com/css?family=Open+Sans:600&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic,greek-ext,greek,vietnamese\" rel=\"stylesheet\" />";
        }
        // line 11
        echo "
\t<link href=\"";
        // line 12
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/common.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 13
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/links.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 14
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/content.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 15
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/buttons.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 16
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/cp.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<link href=\"";
        // line 17
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/forms.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />

\t<link href=\"";
        // line 19
        echo (isset($context["T_THEME_PATH"]) ? $context["T_THEME_PATH"] : null);
        echo "/pbwow.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />

\t<link href=\"";
        // line 21
        echo (isset($context["T_STYLESHEET_LINK"]) ? $context["T_STYLESHEET_LINK"] : null);
        echo "\" rel=\"stylesheet\" />

\t<link href=\"";
        // line 23
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/responsive.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" media=\"only screen and (max-width: 700px), only screen and (max-device-width: 700px)\" />
\t<link href=\"";
        // line 24
        echo (isset($context["T_THEME_PATH"]) ? $context["T_THEME_PATH"] : null);
        echo "/responsive.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" media=\"only screen and (max-width: 700px), only screen and (max-device-width: 700px)\" />

\t";
        // line 26
        if (((isset($context["S_CONTENT_DIRECTION"]) ? $context["S_CONTENT_DIRECTION"] : null) == "rtl")) {
            // line 27
            echo "\t<link href=\"";
            echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
            echo "styles/prosilver/theme/bidi.css?assets_version=";
            echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
            echo "\" rel=\"stylesheet\" />
\t<link href=\"";
            // line 28
            echo (isset($context["T_THEME_PATH"]) ? $context["T_THEME_PATH"] : null);
            echo "/bidi.css?assets_version=";
            echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
            echo "\" rel=\"stylesheet\" />
\t";
        }
        // line 30
        echo "
\t<!--[if lte IE 9]>
\t<link href=\"";
        // line 32
        echo (isset($context["ROOT_PATH"]) ? $context["ROOT_PATH"] : null);
        echo "styles/prosilver/theme/tweaks.css?assets_version=";
        echo (isset($context["T_ASSETS_VERSION"]) ? $context["T_ASSETS_VERSION"] : null);
        echo "\" rel=\"stylesheet\" />
\t<![endif]-->

";
        // line 35
        $value = 1;
        $context['definition']->set('POPUP', $value);
        // line 36
        echo "
";
        // line 37
        // line 38
        echo "
";
        // line 39
        echo $this->getAttribute((isset($context["definition"]) ? $context["definition"] : null), "STYLESHEETS", array());
        echo "

";
        // line 41
        // line 42
        echo "
</head>

<body id=\"phpbb\" class=\"nojs ";
        // line 45
        echo (isset($context["S_CONTENT_DIRECTION"]) ? $context["S_CONTENT_DIRECTION"] : null);
        echo " ";
        echo (isset($context["BODY_CLASS"]) ? $context["BODY_CLASS"] : null);
        echo "\" style=\"background-position: 49.999% 0;\">

";
        // line 47
        // line 48
        echo "
<div id=\"wrap\" style=\"margin-top: 0\">
\t<a id=\"top\" class=\"anchor\" accesskey=\"t\"></a>
\t<div id=\"page-body\">
";
    }

    public function getTemplateName()
    {
        return "simple_header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  181 => 48,  180 => 47,  173 => 45,  168 => 42,  167 => 41,  162 => 39,  159 => 38,  158 => 37,  155 => 36,  152 => 35,  144 => 32,  140 => 30,  133 => 28,  126 => 27,  124 => 26,  117 => 24,  111 => 23,  106 => 21,  99 => 19,  92 => 17,  86 => 16,  80 => 15,  74 => 14,  68 => 13,  62 => 12,  59 => 11,  55 => 10,  49 => 9,  35 => 7,  31 => 6,  22 => 2,  19 => 1,);
    }
}
