<script type="text/javascript">
    function resetFrom() {
        document.getElementById('subject').value = '';
        document.getElementById('categoryid').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("FAQ's", 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=faq&jstlay=addfaq"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add FAQ', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=faq&jstlay=faqs"); ?>">
    <?php echo JSSTformfield::text('subject', jssupportticket::$_data['filter']['subject'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('faqs'), jssupportticket::$_data['filter']['categoryid'], __('Select Category', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>

</form>
<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-3 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('Category', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	
        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $faq) {
            $status = ($faq->status == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-3 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=faq&jstlay=addfaq&jssupportticketid=<?php echo $faq->id; ?>"><?php echo $faq->subject; ?></a></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket');
        echo " : "; ?></span><?php echo $faq->categoryname; ?></div>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
        echo " : "; ?></span> <a href="?page=faq&task=changestatus&action=jstask&faqid=<?php echo $faq->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></a></div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket');
        echo " : "; ?></span>
                    <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=faq&task=ordering&action=jstask&order=up&faqid=<?php echo $faq->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                    <?php
                    }
                    echo $faq->ordering;
                    if ($number < $count) {
                        ?>
                        <a href="?page=faq&task=ordering&action=jstask&order=down&faqid=<?php echo $faq->id;
                        echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=faq&task=ordering&action=jstask&order=down&faqid=<?php echo $faq->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
        <?php } ?>
                </div>

                <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($faq->created)); ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs js-textaligncenter">
                    <a href="?page=faq&jstlay=addfaq&jssupportticketid=<?php echo $faq->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');
                                                        "href="?page=faq&task=deletefaq&action=jstask&faqid=<?php echo $faq->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>

        <?php
        $number++;
    }
    ?>
    </div>		
    <?php
    if (jssupportticket::$_data[1]) {
        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
    }
} else {
    JSSTlayout::getNoRecordFound();
}
?>
