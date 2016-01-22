<?php

/* acp_logs.html */
class __TwigTemplate_d2109555bc71305f2167f74abd6c63e32a28a04f78f065601b3a34fd17e4e2ea extends Twig_Template
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
        $this->loadTemplate("overall_header.html", "acp_logs.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<a id=\"maincontent\"></a>

<h1>";
        // line 5
        echo $this->env->getExtension('phpbb')->lang("TITLE");
        echo "</h1>

<p>";
        // line 7
        echo $this->env->getExtension('phpbb')->lang("EXPLAIN");
        echo "</p>

<form id=\"list\" method=\"post\" action=\"";
        // line 9
        echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
        echo "\">

<fieldset class=\"display-options search-box\">
\t";
        // line 12
        echo $this->env->getExtension('phpbb')->lang("SEARCH_KEYWORDS");
        echo $this->env->getExtension('phpbb')->lang("COLON");
        echo " <input type=\"text\" name=\"keywords\" value=\"";
        echo (isset($context["S_KEYWORDS"]) ? $context["S_KEYWORDS"] : null);
        echo "\" />&nbsp;<input type=\"submit\" class=\"button2\" name=\"filter\" value=\"";
        echo $this->env->getExtension('phpbb')->lang("SEARCH");
        echo "\" />
</fieldset>

";
        // line 15
        if (twig_length_filter($this->env, $this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "pagination", array()))) {
            // line 16
            echo "<div class=\"pagination top-pagination\">
\t";
            // line 17
            $location = "pagination.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("pagination.html", "acp_logs.html", 17)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
            // line 18
            echo "</div>
";
        }
        // line 20
        echo "
";
        // line 21
        if (twig_length_filter($this->env, $this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "log", array()))) {
            // line 22
            echo "\t<table class=\"table1 zebra-table fixed-width-table\">
\t<thead>
\t<tr>
\t\t<th style=\"width: 15%;\">";
            // line 25
            echo $this->env->getExtension('phpbb')->lang("USERNAME");
            echo "</th>
\t\t<th style=\"width: 15%;\">";
            // line 26
            echo $this->env->getExtension('phpbb')->lang("IP");
            echo "</th>
\t\t<th style=\"width: 20%;\">";
            // line 27
            echo $this->env->getExtension('phpbb')->lang("TIME");
            echo "</th>
\t\t<th>";
            // line 28
            echo $this->env->getExtension('phpbb')->lang("ACTION");
            echo "</th>
\t\t";
            // line 29
            if ((isset($context["S_CLEARLOGS"]) ? $context["S_CLEARLOGS"] : null)) {
                // line 30
                echo "\t\t\t<th style=\"width: 50px;\">";
                echo $this->env->getExtension('phpbb')->lang("MARK");
                echo "</th>
\t\t";
            }
            // line 32
            echo "\t</tr>
\t</thead>
\t<tbody>
\t";
            // line 35
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "log", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["log"]) {
                // line 36
                echo "\t\t<tr>
\t\t\t<td>
\t\t\t\t";
                // line 38
                echo $this->getAttribute($context["log"], "USERNAME", array());
                echo "
\t\t\t\t";
                // line 39
                if ($this->getAttribute($context["log"], "REPORTEE_USERNAME", array())) {
                    // line 40
                    echo "\t\t\t\t<br />&raquo; ";
                    echo $this->getAttribute($context["log"], "REPORTEE_USERNAME", array());
                    echo "
\t\t\t\t";
                }
                // line 42
                echo "\t\t\t</td>
\t\t\t<td style=\"text-align: center;\">";
                // line 43
                echo $this->getAttribute($context["log"], "IP", array());
                echo "</td>
\t\t\t<td style=\"text-align: center;\">";
                // line 44
                echo $this->getAttribute($context["log"], "DATE", array());
                echo "</td>
\t\t\t<td>";
                // line 45
                echo $this->getAttribute($context["log"], "ACTION", array());
                if ($this->getAttribute($context["log"], "DATA", array())) {
                    echo "<br /><span>";
                    echo $this->getAttribute($context["log"], "DATA", array());
                    echo "</span>";
                }
                echo "</td>
\t\t\t";
                // line 46
                if ((isset($context["S_CLEARLOGS"]) ? $context["S_CLEARLOGS"] : null)) {
                    // line 47
                    echo "\t\t\t\t<td style=\"text-align: center;\"><input type=\"checkbox\" class=\"radio\" name=\"mark[]\" value=\"";
                    echo $this->getAttribute($context["log"], "ID", array());
                    echo "\" /></td>
\t\t\t";
                }
                // line 49
                echo "\t\t</tr>
\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['log'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "\t</tbody>
\t</table>

";
            // line 54
            if (twig_length_filter($this->env, $this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "pagination", array()))) {
                // line 55
                echo "\t<div class=\"pagination\">
\t\t";
                // line 56
                $location = "pagination.html";
                $namespace = false;
                if (strpos($location, '@') === 0) {
                    $namespace = substr($location, 1, strpos($location, '/') - 1);
                    $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                    $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
                }
                $this->loadTemplate("pagination.html", "acp_logs.html", 56)->display($context);
                if ($namespace) {
                    $this->env->setNamespaceLookUpOrder($previous_look_up_order);
                }
                // line 57
                echo "\t</div>
";
            }
            // line 59
            echo "
";
        } else {
            // line 61
            echo "\t<div class=\"errorbox\">
\t\t<p>";
            // line 62
            echo $this->env->getExtension('phpbb')->lang("NO_ENTRIES");
            echo "</p>
\t</div>
";
        }
        // line 65
        echo "
<fieldset class=\"display-options\">
\t";
        // line 67
        echo $this->env->getExtension('phpbb')->lang("DISPLAY_LOG");
        echo $this->env->getExtension('phpbb')->lang("COLON");
        echo " &nbsp;";
        echo (isset($context["S_LIMIT_DAYS"]) ? $context["S_LIMIT_DAYS"] : null);
        echo "&nbsp;";
        echo $this->env->getExtension('phpbb')->lang("SORT_BY");
        echo $this->env->getExtension('phpbb')->lang("COLON");
        echo " ";
        echo (isset($context["S_SORT_KEY"]) ? $context["S_SORT_KEY"] : null);
        echo " ";
        echo (isset($context["S_SORT_DIR"]) ? $context["S_SORT_DIR"] : null);
        echo "
\t<input class=\"button2\" type=\"submit\" value=\"";
        // line 68
        echo $this->env->getExtension('phpbb')->lang("GO");
        echo "\" name=\"sort\" />
\t";
        // line 69
        echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
        echo "
</fieldset>
<hr />

";
        // line 73
        if ((isset($context["S_SHOW_FORUMS"]) ? $context["S_SHOW_FORUMS"] : null)) {
            // line 74
            echo "\t<fieldset class=\"quick\">
\t\t";
            // line 75
            echo $this->env->getExtension('phpbb')->lang("SELECT_FORUM");
            echo $this->env->getExtension('phpbb')->lang("COLON");
            echo " <select name=\"f\" onchange=\"if(this.options[this.selectedIndex].value != -1){ this.form.submit(); }\">";
            echo (isset($context["S_FORUM_BOX"]) ? $context["S_FORUM_BOX"] : null);
            echo "</select>
\t\t<input class=\"button2\" type=\"submit\" value=\"";
            // line 76
            echo $this->env->getExtension('phpbb')->lang("GO");
            echo "\" />
\t</fieldset>
";
        }
        // line 79
        echo "
";
        // line 80
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["loops"]) ? $context["loops"] : null), "log", array())) && (isset($context["S_CLEARLOGS"]) ? $context["S_CLEARLOGS"] : null))) {
            // line 81
            echo "\t<fieldset class=\"quick\">
\t\t<input class=\"button2\" type=\"submit\" name=\"delall\" value=\"";
            // line 82
            echo $this->env->getExtension('phpbb')->lang("DELETE_ALL");
            echo "\" />&nbsp;
\t\t<input class=\"button2\" type=\"submit\" name=\"delmarked\" value=\"";
            // line 83
            echo $this->env->getExtension('phpbb')->lang("DELETE_MARKED");
            echo "\" /><br />
\t\t<p class=\"small\"><a href=\"#\" onclick=\"marklist('list', 'mark', true); return false;\">";
            // line 84
            echo $this->env->getExtension('phpbb')->lang("MARK_ALL");
            echo "</a> &bull; <a href=\"#\" onclick=\"marklist('list', 'mark', false); return false;\">";
            echo $this->env->getExtension('phpbb')->lang("UNMARK_ALL");
            echo "</a></p>
\t</fieldset>
";
        }
        // line 87
        echo "
</form>

";
        // line 90
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "acp_logs.html", 90)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "acp_logs.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  293 => 90,  288 => 87,  280 => 84,  276 => 83,  272 => 82,  269 => 81,  267 => 80,  264 => 79,  258 => 76,  251 => 75,  248 => 74,  246 => 73,  239 => 69,  235 => 68,  221 => 67,  217 => 65,  211 => 62,  208 => 61,  204 => 59,  200 => 57,  188 => 56,  185 => 55,  183 => 54,  178 => 51,  171 => 49,  165 => 47,  163 => 46,  154 => 45,  150 => 44,  146 => 43,  143 => 42,  137 => 40,  135 => 39,  131 => 38,  127 => 36,  123 => 35,  118 => 32,  112 => 30,  110 => 29,  106 => 28,  102 => 27,  98 => 26,  94 => 25,  89 => 22,  87 => 21,  84 => 20,  80 => 18,  68 => 17,  65 => 16,  63 => 15,  52 => 12,  46 => 9,  41 => 7,  36 => 5,  31 => 2,  19 => 1,);
    }
}
