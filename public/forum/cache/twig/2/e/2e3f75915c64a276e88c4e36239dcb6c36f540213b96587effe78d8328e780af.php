<?php

/* acp_permissions.html */
class __TwigTemplate_2e3f75915c64a276e88c4e36239dcb6c36f540213b96587effe78d8328e780af extends Twig_Template
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
        $this->loadTemplate("overall_header.html", "acp_permissions.html", 1)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
        // line 2
        echo "
<a id=\"maincontent\"></a>

";
        // line 5
        if ((isset($context["S_INTRO"]) ? $context["S_INTRO"] : null)) {
            // line 6
            echo "
\t<h1>";
            // line 7
            echo $this->env->getExtension('phpbb')->lang("ACP_PERMISSIONS");
            echo "</h1>

\t";
            // line 9
            echo $this->env->getExtension('phpbb')->lang("ACP_PERMISSIONS_EXPLAIN");
            echo "

";
        }
        // line 12
        echo "
";
        // line 13
        if ((isset($context["S_SELECT_VICTIM"]) ? $context["S_SELECT_VICTIM"] : null)) {
            // line 14
            echo "
\t";
            // line 15
            if ((isset($context["U_BACK"]) ? $context["U_BACK"] : null)) {
                echo "<a href=\"";
                echo (isset($context["U_BACK"]) ? $context["U_BACK"] : null);
                echo "\" style=\"float: ";
                echo (isset($context["S_CONTENT_FLOW_END"]) ? $context["S_CONTENT_FLOW_END"] : null);
                echo ";\">&laquo; ";
                echo $this->env->getExtension('phpbb')->lang("BACK");
                echo "</a>";
            }
            // line 16
            echo "
\t<h1>";
            // line 17
            echo $this->env->getExtension('phpbb')->lang("TITLE");
            echo "</h1>

\t<p>";
            // line 19
            echo $this->env->getExtension('phpbb')->lang("EXPLAIN");
            echo "</p>

\t";
            // line 21
            if ((isset($context["S_FORUM_NAMES"]) ? $context["S_FORUM_NAMES"] : null)) {
                // line 22
                echo "\t\t<p><strong>";
                echo $this->env->getExtension('phpbb')->lang("FORUMS");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</strong> ";
                echo (isset($context["FORUM_NAMES"]) ? $context["FORUM_NAMES"] : null);
                echo "</p>
\t";
            }
            // line 24
            echo "
\t";
            // line 25
            if ((isset($context["S_SELECT_FORUM"]) ? $context["S_SELECT_FORUM"] : null)) {
                // line 26
                echo "
\t\t<form id=\"select_victim\" method=\"post\" action=\"";
                // line 27
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t<fieldset>
\t\t\t<legend>";
                // line 30
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
                echo "</legend>
\t\t\t";
                // line 31
                if ((isset($context["S_FORUM_MULTIPLE"]) ? $context["S_FORUM_MULTIPLE"] : null)) {
                    echo "<p>";
                    echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUMS_EXPLAIN");
                    echo "</p>";
                }
                // line 32
                echo "\t\t<dl>
\t\t\t<dt><label for=\"forum\">";
                // line 33
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</label></dt>
\t\t\t<dd><select id=\"forum\" name=\"forum_id[]\"";
                // line 34
                if ((isset($context["S_FORUM_MULTIPLE"]) ? $context["S_FORUM_MULTIPLE"] : null)) {
                    echo " multiple=\"multiple\"";
                }
                echo " size=\"10\">";
                echo (isset($context["S_FORUM_OPTIONS"]) ? $context["S_FORUM_OPTIONS"] : null);
                echo "</select></dd>
\t\t\t";
                // line 35
                if ((isset($context["S_FORUM_ALL"]) ? $context["S_FORUM_ALL"] : null)) {
                    echo "<dd><label><input type=\"checkbox\" class=\"radio\" name=\"all_forums\" value=\"1\" /> ";
                    echo $this->env->getExtension('phpbb')->lang("ALL_FORUMS");
                    echo "</label></dd>";
                }
                // line 36
                echo "\t\t</dl>

\t\t<p class=\"quick\">
\t\t\t";
                // line 39
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t";
                // line 40
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                // line 41
                echo $this->env->getExtension('phpbb')->lang("SUBMIT");
                echo "\" class=\"button1\" />
\t\t</p>

\t\t</fieldset>
\t\t</form>

\t\t";
                // line 47
                if ((isset($context["S_FORUM_MULTIPLE"]) ? $context["S_FORUM_MULTIPLE"] : null)) {
                    // line 48
                    echo "
\t\t\t<form id=\"select_subforum\" method=\"post\" action=\"";
                    // line 49
                    echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                    echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                    // line 52
                    echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
                    echo "</legend>
\t\t\t\t<p>";
                    // line 53
                    echo $this->env->getExtension('phpbb')->lang("SELECT_FORUM_SUBFORUM_EXPLAIN");
                    echo "</p>
\t\t\t<dl>
\t\t\t\t<dt><label for=\"sforum\">";
                    // line 55
                    echo $this->env->getExtension('phpbb')->lang("LOOK_UP_FORUM");
                    echo $this->env->getExtension('phpbb')->lang("COLON");
                    echo "</label></dt>
\t\t\t\t<dd><select id=\"sforum\" name=\"subforum_id\">";
                    // line 56
                    echo (isset($context["S_SUBFORUM_OPTIONS"]) ? $context["S_SUBFORUM_OPTIONS"] : null);
                    echo "</select></dd>
\t\t\t</dl>

\t\t\t<p class=\"quick\">
\t\t\t\t";
                    // line 60
                    echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                    echo "
\t\t\t\t";
                    // line 61
                    echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                    echo "
\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                    // line 62
                    echo $this->env->getExtension('phpbb')->lang("SUBMIT");
                    echo "\" class=\"button1\" />
\t\t\t</p>

\t\t\t</fieldset>
\t\t\t</form>

\t\t";
                }
                // line 69
                echo "
\t";
            } elseif ((            // line 70
(isset($context["S_SELECT_USER"]) ? $context["S_SELECT_USER"] : null) && (isset($context["S_CAN_SELECT_USER"]) ? $context["S_CAN_SELECT_USER"] : null))) {
                // line 71
                echo "
\t\t<form id=\"select_victim\" method=\"post\" action=\"";
                // line 72
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t<fieldset>
\t\t\t<legend>";
                // line 75
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_USER");
                echo "</legend>
\t\t<dl>
\t\t\t<dt><label for=\"username\">";
                // line 77
                echo $this->env->getExtension('phpbb')->lang("FIND_USERNAME");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</label></dt>
\t\t\t<dd><input class=\"text medium\" type=\"text\" id=\"username\" name=\"username[]\" /></dd>
\t\t\t<dd>[ <a href=\"";
                // line 79
                echo (isset($context["U_FIND_USERNAME"]) ? $context["U_FIND_USERNAME"] : null);
                echo "\" onclick=\"find_username(this.href); return false;\">";
                echo $this->env->getExtension('phpbb')->lang("FIND_USERNAME");
                echo "</a> ]</dd>
\t\t\t<dd class=\"full\" style=\"text-align: left;\"><label><input type=\"checkbox\" class=\"radio\" id=\"anonymous\" name=\"user_id[]\" value=\"";
                // line 80
                echo (isset($context["ANONYMOUS_USER_ID"]) ? $context["ANONYMOUS_USER_ID"] : null);
                echo "\" /> ";
                echo $this->env->getExtension('phpbb')->lang("SELECT_ANONYMOUS");
                echo "</label></dd>
\t\t</dl>

\t\t<p class=\"quick\">
\t\t\t";
                // line 84
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t";
                // line 85
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                // line 86
                echo $this->env->getExtension('phpbb')->lang("SUBMIT");
                echo "\" class=\"button1\" />
\t\t</p>
\t\t</fieldset>
\t\t</form>

\t";
            } elseif ((            // line 91
(isset($context["S_SELECT_GROUP"]) ? $context["S_SELECT_GROUP"] : null) && (isset($context["S_CAN_SELECT_GROUP"]) ? $context["S_CAN_SELECT_GROUP"] : null))) {
                // line 92
                echo "
\t\t<form id=\"select_victim\" method=\"post\" action=\"";
                // line 93
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t<fieldset>
\t\t\t<legend>";
                // line 96
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_GROUP");
                echo "</legend>
\t\t<dl>
\t\t\t<dt><label for=\"group\">";
                // line 98
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_GROUP");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</label></dt>
\t\t\t<dd><select name=\"group_id[]\" id=\"group\">";
                // line 99
                echo (isset($context["S_GROUP_OPTIONS"]) ? $context["S_GROUP_OPTIONS"] : null);
                echo "</select></dd>
\t\t</dl>

\t\t<p class=\"quick\">
\t\t\t";
                // line 103
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t";
                // line 104
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                // line 105
                echo $this->env->getExtension('phpbb')->lang("SUBMIT");
                echo "\" class=\"button1\" />
\t\t</p>

\t\t</fieldset>
\t\t</form>

\t\t";
            } elseif (            // line 111
(isset($context["S_SELECT_USERGROUP"]) ? $context["S_SELECT_USERGROUP"] : null)) {
                // line 112
                echo "
\t\t<div class=\"column1\">

\t\t";
                // line 115
                if ((isset($context["S_CAN_SELECT_USER"]) ? $context["S_CAN_SELECT_USER"] : null)) {
                    // line 116
                    echo "
\t\t\t<h1>";
                    // line 117
                    echo $this->env->getExtension('phpbb')->lang("USERS");
                    echo "</h1>

\t\t\t<form id=\"users\" method=\"post\" action=\"";
                    // line 119
                    echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                    echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                    // line 122
                    echo $this->env->getExtension('phpbb')->lang("MANAGE_USERS");
                    echo "</legend>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><select style=\"width: 100%;\" name=\"user_id[]\" multiple=\"multiple\" size=\"5\">";
                    // line 124
                    echo (isset($context["S_DEFINED_USER_OPTIONS"]) ? $context["S_DEFINED_USER_OPTIONS"] : null);
                    echo "</select></dd>
\t\t\t\t";
                    // line 125
                    if ((isset($context["S_ALLOW_ALL_SELECT"]) ? $context["S_ALLOW_ALL_SELECT"] : null)) {
                        echo "<dd class=\"full\" style=\"text-align: right;\"><label><input type=\"checkbox\" class=\"radio\" name=\"all_users\" value=\"1\" /> ";
                        echo $this->env->getExtension('phpbb')->lang("ALL_USERS");
                        echo "</label></dd>";
                    }
                    // line 126
                    echo "\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                    // line 130
                    echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                    echo "
\t\t\t\t";
                    // line 131
                    echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                    echo "
\t\t\t\t<input type=\"submit\" class=\"button2\" name=\"action[delete]\" value=\"";
                    // line 132
                    echo $this->env->getExtension('phpbb')->lang("REMOVE_PERMISSIONS");
                    echo "\" style=\"width: 46% !important;\" /> &nbsp; <input class=\"button1\" type=\"submit\" name=\"submit_edit_options\" value=\"";
                    echo $this->env->getExtension('phpbb')->lang("EDIT_PERMISSIONS");
                    echo "\" style=\"width: 46% !important;\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t\t<form id=\"add_user\" method=\"post\" action=\"";
                    // line 136
                    echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                    echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                    // line 139
                    echo $this->env->getExtension('phpbb')->lang("ADD_USERS");
                    echo "</legend>
\t\t\t\t<p>";
                    // line 140
                    echo $this->env->getExtension('phpbb')->lang("USERNAMES_EXPLAIN");
                    echo "</p>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><textarea id=\"username\" name=\"usernames\" rows=\"5\" cols=\"5\" style=\"width: 100%; height: 60px;\"></textarea></dd>
\t\t\t\t<dd class=\"full\" style=\"text-align: left;\"><div style=\"float: ";
                    // line 143
                    echo (isset($context["S_CONTENT_FLOW_END"]) ? $context["S_CONTENT_FLOW_END"] : null);
                    echo ";\">[ <a href=\"";
                    echo (isset($context["U_FIND_USERNAME"]) ? $context["U_FIND_USERNAME"] : null);
                    echo "\" onclick=\"find_username(this.href); return false;\">";
                    echo $this->env->getExtension('phpbb')->lang("FIND_USERNAME");
                    echo "</a> ]</div><label><input type=\"checkbox\" class=\"radio\" id=\"anonymous\" name=\"user_id[]\" value=\"";
                    echo (isset($context["ANONYMOUS_USER_ID"]) ? $context["ANONYMOUS_USER_ID"] : null);
                    echo "\" /> ";
                    echo $this->env->getExtension('phpbb')->lang("SELECT_ANONYMOUS");
                    echo "</label></dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                    // line 148
                    echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                    echo "
\t\t\t\t";
                    // line 149
                    echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                    echo "
\t\t\t\t<input class=\"button1\" type=\"submit\" name=\"submit_add_options\" value=\"";
                    // line 150
                    echo $this->env->getExtension('phpbb')->lang("ADD_PERMISSIONS");
                    echo "\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t";
                }
                // line 155
                echo "
\t\t</div>

\t\t<div class=\"column2\">

\t\t";
                // line 160
                if ((isset($context["S_CAN_SELECT_GROUP"]) ? $context["S_CAN_SELECT_GROUP"] : null)) {
                    // line 161
                    echo "
\t\t\t<h1>";
                    // line 162
                    echo $this->env->getExtension('phpbb')->lang("USERGROUPS");
                    echo "</h1>

\t\t\t<form id=\"groups\" method=\"post\" action=\"";
                    // line 164
                    echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                    echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                    // line 167
                    echo $this->env->getExtension('phpbb')->lang("MANAGE_GROUPS");
                    echo "</legend>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><select style=\"width: 100%;\" name=\"group_id[]\" multiple=\"multiple\" size=\"5\">";
                    // line 169
                    echo (isset($context["S_DEFINED_GROUP_OPTIONS"]) ? $context["S_DEFINED_GROUP_OPTIONS"] : null);
                    echo "</select></dd>
\t\t\t\t";
                    // line 170
                    if ((isset($context["S_ALLOW_ALL_SELECT"]) ? $context["S_ALLOW_ALL_SELECT"] : null)) {
                        echo "<dd class=\"full\" style=\"text-align: right;\"><label><input type=\"checkbox\" class=\"radio\" name=\"all_groups\" value=\"1\" /> ";
                        echo $this->env->getExtension('phpbb')->lang("ALL_GROUPS");
                        echo "</label></dd>";
                    }
                    // line 171
                    echo "\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                    // line 175
                    echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                    echo "
\t\t\t\t";
                    // line 176
                    echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                    echo "
\t\t\t\t<input class=\"button2\" type=\"submit\" name=\"action[delete]\" value=\"";
                    // line 177
                    echo $this->env->getExtension('phpbb')->lang("REMOVE_PERMISSIONS");
                    echo "\" style=\"width: 46% !important;\" /> &nbsp; <input class=\"button1\" type=\"submit\" name=\"submit_edit_options\" value=\"";
                    echo $this->env->getExtension('phpbb')->lang("EDIT_PERMISSIONS");
                    echo "\" style=\"width: 46% !important;\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t\t<form id=\"add_groups\" method=\"post\" action=\"";
                    // line 181
                    echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                    echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                    // line 184
                    echo $this->env->getExtension('phpbb')->lang("ADD_GROUPS");
                    echo "</legend>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><select name=\"group_id[]\" style=\"width: 100%; height: 107px;\" multiple=\"multiple\">";
                    // line 186
                    echo (isset($context["S_ADD_GROUP_OPTIONS"]) ? $context["S_ADD_GROUP_OPTIONS"] : null);
                    echo "</select></dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                    // line 191
                    echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                    echo "
\t\t\t\t";
                    // line 192
                    echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                    echo "
\t\t\t\t<input type=\"submit\" class=\"button1\" name=\"submit_add_options\" value=\"";
                    // line 193
                    echo $this->env->getExtension('phpbb')->lang("ADD_PERMISSIONS");
                    echo "\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t";
                }
                // line 198
                echo "
\t\t</div>

\t";
            } elseif (            // line 201
(isset($context["S_SELECT_USERGROUP_VIEW"]) ? $context["S_SELECT_USERGROUP_VIEW"] : null)) {
                // line 202
                echo "
\t\t<div class=\"column1\">

\t\t\t<h1>";
                // line 205
                echo $this->env->getExtension('phpbb')->lang("USERS");
                echo "</h1>

\t\t\t<form id=\"users\" method=\"post\" action=\"";
                // line 207
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                // line 210
                echo $this->env->getExtension('phpbb')->lang("MANAGE_USERS");
                echo "</legend>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><select style=\"width: 100%;\" name=\"user_id[]\" multiple=\"multiple\" size=\"5\">";
                // line 212
                echo (isset($context["S_DEFINED_USER_OPTIONS"]) ? $context["S_DEFINED_USER_OPTIONS"] : null);
                echo "</select></dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                // line 217
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t\t";
                // line 218
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t\t<input class=\"button1\" type=\"submit\" name=\"submit\" value=\"";
                // line 219
                echo $this->env->getExtension('phpbb')->lang("VIEW_PERMISSIONS");
                echo "\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t\t<form id=\"add_user\" method=\"post\" action=\"";
                // line 223
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                // line 226
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_USER");
                echo "</legend>
\t\t\t<dl>
\t\t\t\t<dt><label for=\"username\">";
                // line 228
                echo $this->env->getExtension('phpbb')->lang("FIND_USERNAME");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</label></dt>
\t\t\t\t<dd><input type=\"text\" id=\"username\" name=\"username[]\" /></dd>
\t\t\t\t<dd>[ <a href=\"";
                // line 230
                echo (isset($context["U_FIND_USERNAME"]) ? $context["U_FIND_USERNAME"] : null);
                echo "\" onclick=\"find_username(this.href); return false;\">";
                echo $this->env->getExtension('phpbb')->lang("FIND_USERNAME");
                echo "</a> ]</dd>
\t\t\t\t<dd class=\"full\" style=\"text-align: left;\"><label><input type=\"checkbox\" class=\"radio\" id=\"anonymous\" name=\"user_id[]\" value=\"";
                // line 231
                echo (isset($context["ANONYMOUS_USER_ID"]) ? $context["ANONYMOUS_USER_ID"] : null);
                echo "\" /> ";
                echo $this->env->getExtension('phpbb')->lang("SELECT_ANONYMOUS");
                echo "</label></dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                // line 236
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t\t";
                // line 237
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                // line 238
                echo $this->env->getExtension('phpbb')->lang("VIEW_PERMISSIONS");
                echo "\" class=\"button1\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t</div>

\t\t<div class=\"column2\">

\t\t\t<h1>";
                // line 246
                echo $this->env->getExtension('phpbb')->lang("USERGROUPS");
                echo "</h1>

\t\t\t<form id=\"groups\" method=\"post\" action=\"";
                // line 248
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                // line 251
                echo $this->env->getExtension('phpbb')->lang("MANAGE_GROUPS");
                echo "</legend>
\t\t\t<dl>
\t\t\t\t<dd class=\"full\"><select style=\"width: 100%;\" name=\"group_id[]\" multiple=\"multiple\" size=\"5\">";
                // line 253
                echo (isset($context["S_DEFINED_GROUP_OPTIONS"]) ? $context["S_DEFINED_GROUP_OPTIONS"] : null);
                echo "</select></dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                // line 258
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t\t";
                // line 259
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t\t<input class=\"button1\" type=\"submit\" name=\"submit\" value=\"";
                // line 260
                echo $this->env->getExtension('phpbb')->lang("VIEW_PERMISSIONS");
                echo "\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t\t<form id=\"group\" method=\"post\" action=\"";
                // line 264
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t\t<fieldset>
\t\t\t\t<legend>";
                // line 267
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_GROUP");
                echo "</legend>
\t\t\t<dl>
\t\t\t\t<dt><label for=\"group_select\">";
                // line 269
                echo $this->env->getExtension('phpbb')->lang("LOOK_UP_GROUP");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo "</label></dt>
\t\t\t\t<dd><select name=\"group_id[]\" id=\"group_select\">";
                // line 270
                echo (isset($context["S_ADD_GROUP_OPTIONS"]) ? $context["S_ADD_GROUP_OPTIONS"] : null);
                echo "</select></dd>
\t\t\t\t<dd>&nbsp;</dd>
\t\t\t</dl>
\t\t\t</fieldset>

\t\t\t<fieldset class=\"quick\">
\t\t\t\t";
                // line 276
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t\t";
                // line 277
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t\t<input type=\"submit\" name=\"submit\" value=\"";
                // line 278
                echo $this->env->getExtension('phpbb')->lang("VIEW_PERMISSIONS");
                echo "\" class=\"button1\" />
\t\t\t</fieldset>
\t\t\t</form>

\t\t</div>

\t";
            }
            // line 285
            echo "
";
        }
        // line 287
        echo "
";
        // line 288
        if ((isset($context["S_VIEWING_PERMISSIONS"]) ? $context["S_VIEWING_PERMISSIONS"] : null)) {
            // line 289
            echo "
\t<h1>";
            // line 290
            echo $this->env->getExtension('phpbb')->lang("ACL_VIEW");
            echo "</h1>

\t<p>";
            // line 292
            echo $this->env->getExtension('phpbb')->lang("ACL_VIEW_EXPLAIN");
            echo "</p>

\t<fieldset class=\"quick\">
\t\t<strong>&raquo; ";
            // line 295
            echo $this->env->getExtension('phpbb')->lang("PERMISSION_TYPE");
            echo "</strong>
\t</fieldset>

\t";
            // line 298
            $location = "permission_mask.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("permission_mask.html", "acp_permissions.html", 298)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
            // line 299
            echo "
";
        }
        // line 301
        echo "
";
        // line 302
        if ((isset($context["S_SETTING_PERMISSIONS"]) ? $context["S_SETTING_PERMISSIONS"] : null)) {
            // line 303
            echo "
\t<h1>";
            // line 304
            echo $this->env->getExtension('phpbb')->lang("ACL_SET");
            echo "</h1>

\t<p>";
            // line 306
            echo $this->env->getExtension('phpbb')->lang("ACL_SET_EXPLAIN");
            echo "</p>

\t<br />

\t<fieldset class=\"quick\" style=\"float: ";
            // line 310
            echo (isset($context["S_CONTENT_FLOW_END"]) ? $context["S_CONTENT_FLOW_END"] : null);
            echo ";\">
\t\t<strong>&raquo; ";
            // line 311
            echo $this->env->getExtension('phpbb')->lang("PERMISSION_TYPE");
            echo "</strong>
\t</fieldset>

\t";
            // line 314
            if ((isset($context["S_PERMISSION_DROPDOWN"]) ? $context["S_PERMISSION_DROPDOWN"] : null)) {
                // line 315
                echo "\t\t<form id=\"pselect\" method=\"post\" action=\"";
                echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
                echo "\">

\t\t<fieldset class=\"quick\" style=\"float: ";
                // line 317
                echo (isset($context["S_CONTENT_FLOW_BEGIN"]) ? $context["S_CONTENT_FLOW_BEGIN"] : null);
                echo ";\">
\t\t\t";
                // line 318
                echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
                echo "
\t\t\t";
                // line 319
                echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
                echo "
\t\t\t";
                // line 320
                echo $this->env->getExtension('phpbb')->lang("SELECT_TYPE");
                echo $this->env->getExtension('phpbb')->lang("COLON");
                echo " <select name=\"type\">";
                echo (isset($context["S_PERMISSION_DROPDOWN"]) ? $context["S_PERMISSION_DROPDOWN"] : null);
                echo "</select>

\t\t\t<input class=\"button2\" type=\"submit\" name=\"submit\" value=\"";
                // line 322
                echo $this->env->getExtension('phpbb')->lang("GO");
                echo "\" />
\t\t</fieldset>
\t\t</form>
\t";
            }
            // line 326
            echo "
\t<br class=\"responsive-hide\" /><br class=\"responsive-hide\" />

\t<!-- include tooltip file -->
\t<script type=\"text/javascript\" src=\"style/tooltip.js\"></script>
\t<script type=\"text/javascript\">
\t// <![CDATA[
\t\twindow.onload = function(){enable_tooltips_select('set-permissions', '";
            // line 333
            echo addslashes($this->env->getExtension('phpbb')->lang("ROLE_DESCRIPTION"));
            echo "', 'role')};
\t// ]]>
\t</script>

\t<form id=\"set-permissions\" method=\"post\" action=\"";
            // line 337
            echo (isset($context["U_ACTION"]) ? $context["U_ACTION"] : null);
            echo "\">

\t";
            // line 339
            echo (isset($context["S_HIDDEN_FIELDS"]) ? $context["S_HIDDEN_FIELDS"] : null);
            echo "

\t";
            // line 341
            $location = "permission_mask.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("permission_mask.html", "acp_permissions.html", 341)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
            // line 342
            echo "
\t<br class=\"responsive-hide\" /><br class=\"responsive-hide\" />

\t<fieldset class=\"quick\" style=\"float: ";
            // line 345
            echo (isset($context["S_CONTENT_FLOW_END"]) ? $context["S_CONTENT_FLOW_END"] : null);
            echo ";\">
\t\t<input class=\"button1\" type=\"submit\" name=\"action[apply_all_permissions]\" value=\"";
            // line 346
            echo $this->env->getExtension('phpbb')->lang("APPLY_ALL_PERMISSIONS");
            echo "\" />
\t\t<input class=\"button2\" type=\"button\" name=\"cancel\" value=\"";
            // line 347
            echo $this->env->getExtension('phpbb')->lang("RESET");
            echo "\" onclick=\"document.forms['set-permissions'].reset(); init_colours(active_pmask + active_fmask);\" />
\t\t";
            // line 348
            echo (isset($context["S_FORM_TOKEN"]) ? $context["S_FORM_TOKEN"] : null);
            echo "
\t</fieldset>

\t<br class=\"responsive-hide\" /><br class=\"responsive-hide\" />

\t</form>

";
        }
        // line 356
        echo "
";
        // line 357
        $location = "overall_footer.html";
        $namespace = false;
        if (strpos($location, '@') === 0) {
            $namespace = substr($location, 1, strpos($location, '/') - 1);
            $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
            $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
        }
        $this->loadTemplate("overall_footer.html", "acp_permissions.html", 357)->display($context);
        if ($namespace) {
            $this->env->setNamespaceLookUpOrder($previous_look_up_order);
        }
    }

    public function getTemplateName()
    {
        return "acp_permissions.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  882 => 357,  879 => 356,  868 => 348,  864 => 347,  860 => 346,  856 => 345,  851 => 342,  839 => 341,  834 => 339,  829 => 337,  822 => 333,  813 => 326,  806 => 322,  798 => 320,  794 => 319,  790 => 318,  786 => 317,  780 => 315,  778 => 314,  772 => 311,  768 => 310,  761 => 306,  756 => 304,  753 => 303,  751 => 302,  748 => 301,  744 => 299,  732 => 298,  726 => 295,  720 => 292,  715 => 290,  712 => 289,  710 => 288,  707 => 287,  703 => 285,  693 => 278,  689 => 277,  685 => 276,  676 => 270,  671 => 269,  666 => 267,  660 => 264,  653 => 260,  649 => 259,  645 => 258,  637 => 253,  632 => 251,  626 => 248,  621 => 246,  610 => 238,  606 => 237,  602 => 236,  592 => 231,  586 => 230,  580 => 228,  575 => 226,  569 => 223,  562 => 219,  558 => 218,  554 => 217,  546 => 212,  541 => 210,  535 => 207,  530 => 205,  525 => 202,  523 => 201,  518 => 198,  510 => 193,  506 => 192,  502 => 191,  494 => 186,  489 => 184,  483 => 181,  474 => 177,  470 => 176,  466 => 175,  460 => 171,  454 => 170,  450 => 169,  445 => 167,  439 => 164,  434 => 162,  431 => 161,  429 => 160,  422 => 155,  414 => 150,  410 => 149,  406 => 148,  390 => 143,  384 => 140,  380 => 139,  374 => 136,  365 => 132,  361 => 131,  357 => 130,  351 => 126,  345 => 125,  341 => 124,  336 => 122,  330 => 119,  325 => 117,  322 => 116,  320 => 115,  315 => 112,  313 => 111,  304 => 105,  300 => 104,  296 => 103,  289 => 99,  284 => 98,  279 => 96,  273 => 93,  270 => 92,  268 => 91,  260 => 86,  256 => 85,  252 => 84,  243 => 80,  237 => 79,  231 => 77,  226 => 75,  220 => 72,  217 => 71,  215 => 70,  212 => 69,  202 => 62,  198 => 61,  194 => 60,  187 => 56,  182 => 55,  177 => 53,  173 => 52,  167 => 49,  164 => 48,  162 => 47,  153 => 41,  149 => 40,  145 => 39,  140 => 36,  134 => 35,  126 => 34,  121 => 33,  118 => 32,  112 => 31,  108 => 30,  102 => 27,  99 => 26,  97 => 25,  94 => 24,  85 => 22,  83 => 21,  78 => 19,  73 => 17,  70 => 16,  60 => 15,  57 => 14,  55 => 13,  52 => 12,  46 => 9,  41 => 7,  38 => 6,  36 => 5,  31 => 2,  19 => 1,);
    }
}
