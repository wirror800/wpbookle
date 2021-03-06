
<!-- sandbox notice -->
<?php if( get_option('wplister_sandbox_enabled') == '1' ) : ?>

	<script type="text/javascript">
		jQuery( document ).ready( function () {
		
		    jQuery('#screen-meta-links').append(
		        '<div id="wpl-sandbox-reminder-wrap" class="hide-if-no-js screen-meta-toggle">' +
		            '<a href="#" id="wpl-sandbox-reminder-link" class="show-settings"><?php echo __('Sandbox enabled','wplister'); ?></a>' +
		        '</div>'
		    );
	
		});

	</script>

<?php endif; ?>


<?php 
	// make sure we show all admin messages - even the ones generated after the WP admin_notices hook has fired
	do_action( 'wple_admin_notices' );
?>


<!-- jobs window -->
<div id="wple_jobs_window_container" style="display:none">
	<div id="wple_jobs_window">
		
		<h2 id="wple_jobs_title">Jobs</h2>
		
		<div id="wple_progressbar"><span class="caption">loading...</span></div>			
		<div id="wple_jobs_message">warming up...</div>
		
		<div id="wple_jobs_log">
			<span></span>
		</div>
		
		<div id="wple_jobs_footer_msg" style="">
			<?php echo __("Please don't close this window until all tasks are completed.",'wplister') ?>
		</div>
		<div class="submit" style="float:right; padding: 10px 0 0 0; margin: 0;">
			<a class="btn_close button"><?php echo __('Close window','wplister') ?></a>
			<a class="btn_cancel button-secondary"><?php echo __('Cancel','wplister') ?></a>
		</div>

	</div>
</div>


<script type="text/javascript">
	
	var wplister_url= '<?php echo WPLISTER_URL; ?>/';
	var wplister_ajax_error_handling = "<?php echo get_option( 'wplister_ajax_error_handling', 'halt' ); ?>";

	// on page load
	jQuery( document ).ready(
		function () {
	
			// init JobRunner
			WpLister.JobRunner.init();

			// btn_update_ebay_data
			jQuery('#btn_update_ebay_data').click( function(event) {
				WpLister.JobRunner.runJob( 'updateEbayData', 'Loading data from eBay...' );
			});
			jQuery('.btn_update_ebay_data_for_site').click( function(event,a,b) {			
				var params = {
					'site_id':    jQuery(this).data('site_id'),
					'account_id': jQuery(this).data('account_id')
				}
				console.log('runjob(updateEbayData) parameters: ',params);
				WpLister.JobRunner.runJob( 'updateEbayData', 'Updating site specific details from eBay...', params );
				return false;
			});

			// btn_verify_all_prepared_items
			jQuery('.btn_verify_all_prepared_items').click( function(event) {
				WpLister.JobRunner.runJob( 'verifyAllPreparedItems', 'Verifying items...' );
			});

			// btn_publish_all_verified_items
			jQuery('.btn_publish_all_verified_items').click( function(event) {
				WpLister.JobRunner.runJob( 'publishAllVerifiedItems', 'Listing items...' );
			});

			// btn_publish_all_prepared_items
			jQuery('.btn_publish_all_prepared_items').click( function(event) {
				WpLister.JobRunner.runJob( 'publishAllPreparedItems', 'Listing items...' );
			});

			// btn_relist_all_restocked_items
			jQuery('.btn_relist_all_restocked_items').click( function(event) {
				WpLister.JobRunner.runJob( 'relistAllRestockedItems', 'Relisting items...' );
			});

			// btn_revise_all_changed_items
			jQuery('.btn_revise_all_changed_items').click( function(event) {
				WpLister.JobRunner.runJob( 'reviseAllChangedItems', 'Revising items...' );
			});
			jQuery('.btn_revise_all_changed_items_reminder').click( function(event) {
				WpLister.JobRunner.runJob( 'reviseAllChangedItems', 'Revising items...' );
			});

			// btn_update_all_relisted_items
			jQuery('.btn_update_all_relisted_items_reminder').click( function(event) {
				WpLister.JobRunner.runJob( 'updateAllRelistedItems', 'Updating relisted items...' );
			});

			// btn_update_all_published_items
			jQuery('.btn_update_all_published_items').click( function(event) {
				WpLister.JobRunner.runJob( 'updateAllPublishedItems', 'Updating items...' );
			});

			// btn_run_delayed_profile_application
			jQuery('.btn_run_delayed_profile_application').click( function(event) {
				WpLister.JobRunner.runJob( 'runDelayedProfileApplication', 'Applying profile...' );
			});


			// init tooltips
			jQuery(".tips, .help_tip").tipTip({
		    	'attribute' : 'data-tip',
		    	'maxWidth' : '250px',
		    	'fadeIn' : 50,
		    	'fadeOut' : 50,
		    	'delay' : 200
		    });

		}
	);

</script>


<style type="text/css">

	#tiptip_holder #tiptip_content {
		max-width: 250px;
	}

</style>
