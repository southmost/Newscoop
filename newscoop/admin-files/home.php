<?php
require_once($GLOBALS['g_campsiteDir']."/db_connect.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Input.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Publication.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Issue.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Section.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Article.php");
require_once($GLOBALS['g_campsiteDir']."/classes/ArticlePublish.php");
require_once($GLOBALS['g_campsiteDir']."/classes/IssuePublish.php");
require_once($GLOBALS['g_campsiteDir']."/classes/Language.php");
require_once($GLOBALS['g_campsiteDir']."/classes/SimplePager.php");

require_once($GLOBALS['g_campsiteDir'].'/classes/Extension/WidgetContext.php');

require_once($GLOBALS['g_campsiteDir'].'/classes/Extension/WidgetContext.php');

require_once LIBS_DIR . '/ArticleList/ArticleList.php';

camp_load_translation_strings("home");
camp_load_translation_strings("articles");
camp_load_translation_strings("api");
camp_load_translation_strings("extensions");

 // install default widgets for admin
if ($g_user->getUserId() == 1
    && SystemPref::Get('AdminWidgetsInstalled') == NULL) {
    WidgetManager::SetDefaultWidgets(1);
    SystemPref::Set('AdminWidgetsInstalled', time());
}

$crumbs = array();
$crumbs[] = array(getGS('Dashboard'), '');
echo camp_html_breadcrumbs($crumbs);
?>
<script type="text/javascript" src="<?php echo $Campsite['WEBSITE_URL']; ?>/javascript/campsite.js"></script>

<?php
$clearCache = Input::Get('clear_cache', 'string', 'no', true);
if ((CampCache::IsEnabled() || CampTemplateCache::factory()) && ($clearCache == 'yes')
        && $g_user->hasPermission('ClearCache')) {
    // Clear cache engine's cache
    CampCache::singleton()->clear('user');
    CampCache::singleton()->clear();
    SystemPref::DeleteSystemPrefsFromCache();

    // Clear compiled templates
    require_once($GLOBALS['g_campsiteDir']."/template_engine/classes/CampTemplate.php");
    CampTemplate::singleton()->clear_compiled_tpl();

    // Clear template cache storage
    if (CampTemplateCache::factory()) CampTemplateCache::factory()->clean();

    $actionMsg = getGS('Newscoop cache was cleaned up');
    $res = 'OK';
}

$syncUsers = Input::Get('sync_users', 'string', 'no', true);
if (($syncUsers == 'yes') && $g_user->hasPermission('SyncPhorumUsers')) {
    require_once($GLOBALS['g_campsiteDir']."/$ADMIN_DIR/users/sync_phorum_users.php");
    $actionMsg = getGS('Newscoop and Phorum users were synchronized');
    $res = 'OK';
}
?>

<?php if (!empty($actionMsg)) { ?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<?php if ($res == 'OK') { ?>
    <td class="info_message" align="center">
<?php } else { ?>
    <td class="error_message" align="center">
<?php } ?>
        <?php echo $actionMsg; ?>
    </td>
</tr>
</table>
<?php } ?>

<?php camp_html_display_msgs("0.25em", "0.25em"); ?>

<p class="add-widgets" style="margin: 13px 21px 0"><a href="<?php echo $Campsite['WEBSITE_URL']; ?>/admin/widgets.php" title="<?php putGS('Add more widgets'); ?>"><?php putGS('Add more widgets'); ?></a></p>

<div id="dashboard">

<div class="column">
<?php
    $context = new WidgetContext('dashboard1');
    $context->render();
?>
</div>

<div class="column">
<?php
    $context = new WidgetContext('dashboard2');
    $context->render();
?>
</div>

</div><!-- /#dashboard -->

<div style="clear: both;"></div>
<script type="text/javascript">
$(document).ready(function() {
    $('.context').widgets({
        localizer: {
            remove: '<?php putGS('Remove widget'); ?>',
            info: '<?php putGS('Widget info'); ?>',
        }
    });
});
</script>

<?php camp_html_copyright_notice(); ?>
</body>
</html>