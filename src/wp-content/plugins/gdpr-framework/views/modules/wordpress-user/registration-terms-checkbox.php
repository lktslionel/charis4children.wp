<p class="gdpr-terms-container" style="margin-bottom: 10px">
<?php 
		if (!isset($gdpr_value)):
			$gdpr_value = '';
		endif;
		if (!isset($gdpr_arg2)):
			$gdpr_arg2 = '';
		endif;
		if (!isset($gdpr_arg3)):
			$gdpr_arg3 = '';
		endif;
		?>
    <label>
        <input type="checkbox" required name="gdpr_terms" id="gdpr_terms" value="1" />
        <?php $enabled = gdpr('options')->get('enable_tac');?>
        <?php if ($termsUrl && $enabled): 
            add_filter( 'gdpr-framework-consent-policy-with-terms', 'TermAndConditionWithPrivacyContent' );
            $gdpr_text_policy_with_terms = apply_filters( 'gdpr-framework-consent-policy-with-terms', $gdpr_value, $gdpr_arg2, $gdpr_arg3 );
            ?>
            <?= sprintf(
                __($gdpr_text_policy_with_terms, 'gdpr-framework'),
                "<a href='{$termsUrl}' target='_blank'>",
                '</a>',
                "<a href='{$privacyPolicyUrl}' target='_blank'>",
                '</a>'
            ); ?>
        <?php else: ?>
        
        <?php 
        add_filter( 'gdpr-framework-consent-policy', 'gdprfPrivacyPolicy' );
        $gdpr_text_policy = apply_filters( 'gdpr-framework-consent-policy', $gdpr_value, $gdpr_arg2, $gdpr_arg3 );
        ?>
            <?= sprintf(
                __($gdpr_text_policy, 'gdpr-framework'),
                "<a href='{$privacyPolicyUrl}' target='_blank'>",
                '</a>'
            ); ?>
        <?php endif; ?>*
    </label>
</p>
