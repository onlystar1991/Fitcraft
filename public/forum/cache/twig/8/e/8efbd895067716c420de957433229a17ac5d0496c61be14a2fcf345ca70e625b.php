<?php

/* navbar_header.html */
class __TwigTemplate_8efbd895067716c420de957433229a17ac5d0496c61be14a2fcf345ca70e625b extends Twig_Template
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
        echo "<div class=\"navbar\" role=\"navigation\">
\t<div class=\"inner\">

\t<ul id=\"nav-main\" class=\"linklist bulletin\" role=\"menubar\">

\t\t";
        // line 6
        if ((isset($context["U_ACP"]) ? $context["U_ACP"] : null)) {
            echo "<li class=\"small-icon icon-acp\" data-skip-responsive=\"true\"><a href=\"";
            echo (isset($context["U_ACP"]) ? $context["U_ACP"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("ACP");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("ACP_SHORT");
            echo "</a></li>";
        }
        // line 7
        echo "\t\t";
        if ((isset($context["U_MCP"]) ? $context["U_MCP"] : null)) {
            echo "<li class=\"small-icon icon-mcp\" data-last-responsive=\"true\"><a href=\"";
            echo (isset($context["U_MCP"]) ? $context["U_MCP"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("MCP");
            echo "\" role=\"menuitem\">";
            echo $this->env->getExtension('phpbb')->lang("MCP_SHORT");
            echo "</a></li>";
        }
        // line 8
        echo "
\t</ul>

\t</div>
</div>

<div id=\"body-header\">
\t<ul id=\"nav-breadcrumbs\" class=\"linklist navlinks\" role=\"menubar\">
\t\t";
        // line 16
        $value = " itemtype=\"http://data-vocabulary.org/Breadcrumb\" itemscope=\"\"";
        $context['definition']->set('MICRODATA', $value);
        // line 17
        echo "\t\t";
        // line 18
        echo "\t\t<li class=\"small-icon icon-home breadcrumbs";
        if ((isset($context["S_IS_LOCKED"]) ? $context["S_IS_LOCKED"] : null)) {
            echo " locked";
        }
        echo "\">
\t\t\t";
        // line 19
        if ((isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null)) {
            echo "<span class=\"crumb\"><a href=\"";
            echo (isset($context["U_SITE_HOME"]) ? $context["U_SITE_HOME"] : null);
            echo "\"";
            echo $this->getAttribute((isset($context["definition"]) ? $context["definition"] : null), "MICRODATA", array());
            echo " data-navbar-reference=\"home\">";
            echo $this->env->getExtension('phpbb')->lang("SITE_HOME");
            echo "</a></span>";
        }
        // line 20
        echo "\t\t\t";
        // line 21
        echo "\t\t\t<span class=\"crumb\"><a href=\"";
        echo (isset($context["U_INDEX"]) ? $context["U_INDEX"] : null);
        echo "\" accesskey=\"h\"";
        echo $this->getAttribute((isset($context["definition"]) ? $context["definition"] : null), "MICRODATA", array());
        echo " data-navbar-reference=\"index\">";
        echo $this->env->getExtension('phpbb')->lang("INDEX");
        echo "</a></span>
\t\t\t";
        // line 22
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "navlinks", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["navlinks"]) {
            // line 23
            echo "\t\t\t\t";
            // line 24
            echo "\t\t\t\t<span class=\"crumb\"><a href=\"";
            echo $this->getAttribute($context["navlinks"], "U_VIEW_FORUM", array());
            echo "\"";
            echo $this->getAttribute((isset($context["definition"]) ? $context["definition"] : null), "MICRODATA", array());
            if ($this->getAttribute($context["navlinks"], "MICRODATA", array())) {
                echo " ";
                echo $this->getAttribute($context["navlinks"], "MICRODATA", array());
            }
            echo ">";
            echo $this->getAttribute($context["navlinks"], "FORUM_NAME", array());
            echo "</a></span>
\t\t\t\t";
            // line 25
            // line 26
            echo "\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['navlinks'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "\t\t\t";
        if ((isset($context["S_VIEWTOPIC"]) ? $context["S_VIEWTOPIC"] : null)) {
            echo "<span class=\"crumb crumb-topic\"><a href=\"";
            echo (isset($context["U_VIEW_TOPIC"]) ? $context["U_VIEW_TOPIC"] : null);
            echo "\">";
            echo (isset($context["TOPIC_TITLE"]) ? $context["TOPIC_TITLE"] : null);
            echo "</a></span>";
        }
        // line 28
        echo "\t\t\t";
        // line 29
        echo "\t\t</li>
\t\t";
        // line 30
        // line 31
        echo "\t\t";
        if (((isset($context["S_DISPLAY_SEARCH"]) ? $context["S_DISPLAY_SEARCH"] : null) &&  !(isset($context["S_IN_SEARCH"]) ? $context["S_IN_SEARCH"] : null))) {
            // line 32
            echo "\t\t\t<li class=\"responsive-search rightside small-icon icon-search\" style=\"display: none;\"><a href=\"";
            echo (isset($context["U_SEARCH"]) ? $context["U_SEARCH"] : null);
            echo "\" title=\"";
            echo $this->env->getExtension('phpbb')->lang("SEARCH_ADV_EXPLAIN");
            echo "\"></a></li>
\t\t";
        }
        // line 34
        echo "
\t\t";
        // line 35
        if ( !(isset($context["S_IS_BOT"]) ? $context["S_IS_BOT"] : null)) {
            // line 36
            echo "\t\t\t";
            if ((isset($context["S_INDEX"]) ? $context["S_INDEX"] : null)) {
                // line 37
                echo "\t\t\t\t";
                if (((isset($context["S_USER_LOGGED_IN"]) ? $context["S_USER_LOGGED_IN"] : null) && (isset($context["U_MARK_FORUMS"]) ? $context["U_MARK_FORUMS"] : null))) {
                    echo "<li class=\"rightside small-icon icon-mark-read\"><a href=\"";
                    echo (isset($context["U_MARK_FORUMS"]) ? $context["U_MARK_FORUMS"] : null);
                    echo "\" accesskey=\"m\" data-ajax=\"mark_forums_read\" title=\"";
                    echo $this->env->getExtension('phpbb')->lang("MARK_FORUMS_READ");
                    echo "\"></a></li>";
                }
                // line 38
                echo "\t\t\t";
            } elseif ((isset($context["S_VIEWFORUM"]) ? $context["S_VIEWFORUM"] : null)) {
                // line 39
                echo "\t\t\t\t";
                if (((isset($context["S_HAS_SUBFORUM"]) ? $context["S_HAS_SUBFORUM"] : null) && (isset($context["U_MARK_FORUMS"]) ? $context["U_MARK_FORUMS"] : null))) {
                    echo "<li class=\"rightside small-icon icon-mark-read\"><a href=\"";
                    echo (isset($context["U_MARK_FORUMS"]) ? $context["U_MARK_FORUMS"] : null);
                    echo "\" data-ajax=\"mark_forums_read\" title=\"";
                    echo $this->env->getExtension('phpbb')->lang("MARK_SUBFORUMS_READ");
                    echo "\"></a></li>";
                }
                // line 40
                echo "\t\t\t";
            } elseif ((isset($context["S_VIEWTOPIC"]) ? $context["S_VIEWTOPIC"] : null)) {
                // line 41
                echo "\t\t\t\t";
                if ((isset($context["U_VIEW_UNREAD_POST"]) ? $context["U_VIEW_UNREAD_POST"] : null)) {
                    echo "<li class=\"rightside small-icon icon-view\"><a href=\"";
                    echo (isset($context["U_VIEW_UNREAD_POST"]) ? $context["U_VIEW_UNREAD_POST"] : null);
                    echo "\" title=\"";
                    echo $this->env->getExtension('phpbb')->lang("VIEW_UNREAD_POST");
                    echo "\"></a></li>";
                }
                // line 42
                echo "\t\t\t";
            } elseif (((isset($context["SEARCH_MATCHES"]) ? $context["SEARCH_MATCHES"] : null) &&  !(isset($context["S_IN_SEARCH"]) ? $context["S_IN_SEARCH"] : null))) {
                // line 43
                echo "\t\t\t\t";
                if ((isset($context["SEARCH_TOPIC"]) ? $context["SEARCH_TOPIC"] : null)) {
                    // line 44
                    echo "\t\t\t\t<li class=\"rightside\"><a class=\"arrow-";
                    echo (isset($context["S_CONTENT_FLOW_BEGIN"]) ? $context["S_CONTENT_FLOW_BEGIN"] : null);
                    echo "\" href=\"";
                    echo (isset($context["U_SEARCH_TOPIC"]) ? $context["U_SEARCH_TOPIC"] : null);
                    echo "\">";
                    echo $this->env->getExtension('phpbb')->lang("RETURN_TO_TOPIC");
                    echo "</a></li>
\t\t\t\t";
                } else {
                    // line 46
                    echo "\t\t\t\t<li class=\"rightside\"><a class=\"arrow-";
                    echo (isset($context["S_CONTENT_FLOW_BEGIN"]) ? $context["S_CONTENT_FLOW_BEGIN"] : null);
                    echo "\" href=\"";
                    echo (isset($context["U_SEARCH"]) ? $context["U_SEARCH"] : null);
                    echo "\" title=\"";
                    echo $this->env->getExtension('phpbb')->lang("SEARCH_ADV");
                    echo "\">";
                    echo $this->env->getExtension('phpbb')->lang("GO_TO_SEARCH_ADV");
                    echo "</a></li>
\t\t\t\t";
                }
                // line 48
                echo "\t\t\t";
            }
            // line 49
            echo "\t\t";
        }
        // line 50
        echo "\t</ul>
</div>
";
    }

    public function getTemplateName()
    {
        return "navbar_header.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  217 => 50,  214 => 49,  211 => 48,  199 => 46,  189 => 44,  186 => 43,  183 => 42,  174 => 41,  171 => 40,  162 => 39,  159 => 38,  150 => 37,  147 => 36,  145 => 35,  142 => 34,  134 => 32,  131 => 31,  130 => 30,  127 => 29,  125 => 28,  116 => 27,  110 => 26,  109 => 25,  96 => 24,  94 => 23,  90 => 22,  81 => 21,  79 => 20,  69 => 19,  62 => 18,  60 => 17,  57 => 16,  47 => 8,  36 => 7,  26 => 6,  19 => 1,);
    }
}
