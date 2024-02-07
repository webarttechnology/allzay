<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rewards = FKCart\Includes\Data::get_rewards();
if ( empty( $rewards ) ) {
	return;
}

$rewards_position = is_rtl() ? 'right' : 'left';
?>
<div class="fkcart-reward-panel fkcart-panel">
    <div class="fkcart-reward-message"><?php echo wp_kses_post( $rewards['title'] ) ?></div>
    <div class="fkcart-progress-wrap">
        <div class="fkcart-progress-bar" style="width:<?php esc_html_e( $rewards['progress_bar'] ) ?>%"></div>
    </div>
    <div class="fkcart-rewards">
        <div class="fkcart-reward-item-wrap">
            <div class="fkcart-reward-base"></div>
			<?php
			foreach ( $rewards['rewards'] as $reward ) {
				$wstyle = is_rtl() ? "right:calc(" . intval( $reward['progress_width'] ) . "% - 9px)" : "left:calc(" . intval( $reward['progress_width'] ) . "% - 9px)";
				?>
                <div data-tpos="<?php intval( $reward['progress_width'] ) > 50 ? esc_attr_e( 'l' ) : esc_attr_e( 'r' ) ?>" class="fkcart-reward-item <?php echo( ( true === $reward['achieved'] ) ? 'is-activated' : '' ); ?>" style="<?php esc_html_e( $wstyle ) ?>">
                    <div class="fkcart-reward-icon">
						<?php fkcart_get_template_part( 'icon/lock', '', [ 'show_icon' => ( false === $reward['achieved'] ) ] ); ?>
						<?php fkcart_get_template_part( 'icon/reward', '', [ 'show_icon' => ( true === $reward['achieved'] ) ] ); ?>
                    </div>
                    <div class="fkcart-reward-text"><?php esc_html_e( isset( $reward['icon_title'] ) ? $reward['icon_title'] : '' ); ?></div>
                </div>
				<?php
			}
			?>
        </div>
    </div>
</div>
