<?php
require_once($_SERVER['DOCUMENT_ROOT']."/classes/common.php");
require_once($_SERVER['DOCUMENT_ROOT']."/$ADMIN_DIR/lib_campsite.php");

/**
 * Common header for all section screens.
 *
 * @param Section p_sectionObj
 *		The article that is being displayed.
 *
 * @param int p_interfaceLanguageId
 *		The language for the Issue that that article is contained within.
 *
 * @param string p_title
 *		The title of the page.  This should have a translation in the language files.
 *
 * @param boolean p_includeLinks
 *		Whether to include the links underneath the title or not.  Default TRUE.
 *
 * @return void
 */
function SectionTop($p_sectionObj, $p_interfaceLanguageId, $p_title, $p_includeLinks = true, $p_fValidate = false) {
	global $Campsite;
	global $ADMIN;

	// Fetch section
	$sectionObj =& new Section($p_sectionObj->getPublicationId(),
		$p_sectionObj->getIssueId(),
		$p_interfaceLanguageId,
		$p_sectionObj->getSectionId());

	// Fetch issue
	$issueObj =& new Issue($p_sectionObj->getPublicationId(),
		$p_interfaceLanguageId,
		$p_sectionObj->getIssueId());

	// Fetch publication
	$publicationObj =& new Publication($p_sectionObj->getPublicationId());

	$articleLanguageObj =& new Language($p_sectionObj->getLanguageId());
	$interfaceLanguageObj =& new Language($p_interfaceLanguageId);
?>
<HEAD>
	<LINK rel="stylesheet" type="text/css" href="<?php echo $Campsite['WEBSITE_URL']; ?>/css/admin_stylesheet.css">
	<?php if ($p_fValidate) { ?>
	<script type="text/javascript" src="<?php echo $Campsite['WEBSITE_URL']; ?>/javascript/fValidate/fValidate.config.js"></script>
    <script type="text/javascript" src="<?php echo $Campsite['WEBSITE_URL'] ?>/javascript/fValidate/fValidate.core.js"></script>
    <script type="text/javascript" src="<?php echo $Campsite['WEBSITE_URL'] ?>/javascript/fValidate/fValidate.lang-enUS.js"></script>
    <script type="text/javascript" src="<?php echo $Campsite['WEBSITE_URL'] ?>/javascript/fValidate/fValidate.validators.js"></script>	
	<?php } ?>
</HEAD>

<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="1" WIDTH="100%" class="page_title_container">
<TR>
	<TD class="page_title">
	    <?php putGS($p_title); ?>
	</TD>
<?php 
if ($p_includeLinks) {
?>
	<TD ALIGN="right" style="padding-right: 10px; padding-top: 0px;">
		<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="0">
		<TR>
			<!-- "Sections" link -->
			<TD><A HREF="/<?php echo $ADMIN; ?>/pub/issues/sections/?Pub=<?php p($p_sectionObj->getPublicationId()); ?>&Issue=<?php p($p_sectionObj->getIssueId()); ?>&Language=<?php p($p_interfaceLanguageId); ?>" class="breadcrumb"><?php putGS("Sections"); ?></A></TD>
			<td class="breadcrumb_separator">&nbsp;</td>
			
			<!-- "Issues" Link -->
			<TD><A HREF="/<?php echo $ADMIN; ?>/pub/issues/?Pub=<?php p($p_sectionObj->getPublicationId()); ?>" class="breadcrumb"><?php putGS("Issues"); ?></A></TD>
			<td class="breadcrumb_separator">&nbsp;</td>
			
			<!-- "Publications" Link -->
			<TD><A HREF="/<?php echo $ADMIN; ?>/pub/"  class="breadcrumb"><?php  putGS("Publications");  ?></A></TD>
			
		</TR>
		</TABLE>
	</TD>
<?php
} // if ($p_includeLinks)
?>
</TR>
</TABLE>

<TABLE BORDER="0" CELLSPACING="1" CELLPADDING="1" WIDTH="100%" class="current_location_table">
<TR>
	<TD ALIGN="RIGHT" NOWRAP VALIGN="TOP" width="1%" class="current_location_title">&nbsp;<?php putGS("Publication"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php print htmlspecialchars($publicationObj->getName()); ?></TD>

	<TD ALIGN="RIGHT" NOWRAP VALIGN="TOP" width="1%" class="current_location_title">&nbsp;<?php putGS("Issue"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php print htmlspecialchars($issueObj->getIssueId()); ?>. <?php  print htmlspecialchars($issueObj->getName()); ?> (<?php print htmlspecialchars($interfaceLanguageObj->getName()) ?>)</TD>

	<TD ALIGN="RIGHT" NOWRAP VALIGN="TOP" width="1%" class="current_location_title">&nbsp;<?php putGS("Section"); ?>:</TD>
	<TD VALIGN="TOP" class="current_location_content"><?php print $sectionObj->getSectionId(); ?>. <?php  print htmlspecialchars($sectionObj->getName()); ?></TD>
</TR>
</TABLE>
	<?php
} // fn section_top
?>
