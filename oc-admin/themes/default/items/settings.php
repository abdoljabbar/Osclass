<?php
    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

    //customize Head
    function customHead(){ ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="moderate_items"]').bind('change', function() {
            if( $(this).is(':checked') ) {
                $('input[name="logged_user_item_validation"]').attr('disabled', false) ;
                $(".num-moderated-items").show() ;
                $('input[name="num_moderate_items"]').val(0) ;
            } else {
                $('input[name="logged_user_item_validation"]').attr('disabled', true) ;
                $('.num-moderated-items').hide();
            }
        }) ;
    }) ;
</script>
        <?php
    }
    osc_add_hook('admin_header','customHead');

    function render_offset(){
        return 'row-offset';
    }
    osc_add_hook('admin_page_header','customPageHeader');
    function customPageHeader(){ ?>
        <h1 class="dashboard"><?php _e('Listing') ; ?></h1>
    <?php
    }
?>
<?php osc_current_admin_theme_path( 'parts/header.php' ) ; ?>
<div id="general-setting">
    <!-- settings form -->
    <div id="item-settings">
        <h2 class="render-title"><?php _e('Listing Settings') ; ?></h2>
            <form action="<?php echo osc_admin_base_url(true) ; ?>" method="post">
                <input type="hidden" name="page" value="items" />
                <input type="hidden" name="action" value="settings_post" />
                <fieldset>
                    <div class="form-horizontal">
                        <div class="form-row">
                            <div class="form-label"> <?php _e('Settings') ; ?></div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" <?php echo ( osc_reg_user_post() ? 'checked="checked"' : '') ; ?> name="reg_user_post" value="1" />
                                    <?php _e('Only logged in users can post listings') ; ?>
                                </div>
                                <div>
                                    <?php printf( __('An user has to wait %s seconds between each listing added'), '<input type="text" class="input-small" name="items_wait_time" value="' . osc_items_wait_time() . '" />') ; ?>
                                    <div class="help-box">
                                        <?php _e('If the value is zero, there is no waiting') ; ?>
                                    </div>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( ( osc_moderate_items() == -1 ) ? '' : 'checked="checked"' ) ; ?> name="moderate_items" value="1" />
                                    <?php _e('Users have to validate their listings') ; ?>
                                </div>
                                <div>
                                    <?php printf( __("After %s validated listings the user doesn't longer need to validate the listings"), '<input type="text" class="input-small" name="num_moderate_items" value="' . ( ( osc_moderate_items() == -1 ) ? '' : osc_moderate_items() ) . '" />') ; ?>
                                    <div class="help-box">
                                        <?php _e('If the value is zero, it means that each listing must be validated') ; ?>
                                    </div>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( osc_logged_user_item_validation() ? 'checked="checked"' : '' ) ; ?> name="logged_user_item_validation" value="1" <?php echo ( ( osc_moderate_items() != -1 ) ? '' : 'disabled="disabled"') ; ?> />
                                    <?php _e("Logged in users don't need to validate their listings") ; ?>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( ( osc_recaptcha_items_enabled() == '0' ) ? '' : 'checked="checked"' ) ; ?> name="enabled_recaptcha_items" value="1" />
                                    <?php _e('Show reCAPTCHA in add/edit listing form') ; ?>
                                    <div class="help-box"><?php _e('<strong>Remember</strong> that you must configure reCAPTCHA first') ; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label"> <?php _e('Contact publisher') ; ?></div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                   <input type="checkbox" <?php echo ( osc_reg_user_can_contact() ? 'checked="checked"' : '' ) ; ?> name="reg_user_can_contact" value="1" />
                                    <?php _e('Only allow registered users to contact publisher') ; ?>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( osc_item_attachment() ? 'checked="checked"' : '' ) ; ?> name="item_attachment" value="1" />
                                    <?php _e('Allow attach files in contact publisher form') ; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label"> <?php _e('Notifications') ; ?></div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" <?php echo ( osc_notify_new_item() ? 'checked="checked"' : '') ; ?> name="notify_new_item" value="1" />
                                    <?php _e('Notify admin when a new listing is added') ; ?>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( osc_notify_contact_item() ? 'checked="checked"' : '' ) ; ?> name="notify_contact_item" value="1" />
                                    <?php _e('Send a copy to admin of the contact publisher e-mail') ; ?>
                                </div>
                                <div class="separate-top-medium">
                                    <input type="checkbox" <?php echo ( osc_notify_contact_friends() ? 'checked="checked"' : '' ) ; ?> name="notify_contact_friends" value="1" />
                                    <?php _e('Send a copy to admin of the share listing e-mail') ; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-label"> <?php _e('Optional fields') ; ?></div>
                            <div class="form-controls">
                                <div class="form-label-checkbox">
                                    <input type="checkbox" <?php echo ( osc_price_enabled_at_items() ? 'checked="checked"' : '' ) ; ?> name="enableField#f_price@items" value="1"  />
                                    <?php _e('Price') ; ?>
                                    <div class="separate-top-medium">
                                        <input type="checkbox" <?php echo ( osc_images_enabled_at_items() ? 'checked="checked"' : '' ) ; ?> name="enableField#images@items" value="1" />
                                        <?php _e('Attach images') ; ?>
                                    </div>
                                    <div class="separate-top-medium">
                                        <?php printf( __('Attach %s images per listing'), '<input type="text" class="input-small" name="numImages@items" value="' . osc_max_images_per_item() . '" />' ) ; ?>
                                        <div class="help-box"><?php _e('If the value is zero, it means unlimited number of images') ; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="<?php echo osc_esc_html( __('Save changes') ) ; ?>" class="btn btn-submit" />
                        </div>
                    </div>
                </fieldset>
                </form>
                </div>
                <!-- /settings form -->
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ) ; ?>                