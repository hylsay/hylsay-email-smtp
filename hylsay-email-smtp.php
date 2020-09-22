<?php 
/*
Plugin Name: Hylsay Email SMTP
Plugin URI: https://github.com/hylsay/hylsay-email-smtp
Description: Send mail using SMTP
Version: 1.0
Author: hylsay
Author URI: http://aoaoao.info
*/

class HylsayEmailSMTP {
	private $hylsay_email_smtp_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'hylsay_email_smtp_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'hylsay_email_smtp_page_init' ) );
	}

	public function hylsay_email_smtp_add_plugin_page() {
		add_menu_page(
			'Email-SMTP', // page_title
			'Email-SMTP', // menu_title
			'manage_options', // capability
			'email-smtp', // menu_slug
			array( $this, 'hylsay_email_smtp_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			101 // position
		);
	}

	public function hylsay_email_smtp_create_admin_page() {
		$this->hylsay_email_smtp_options = get_option( 'hylsay_email_smtp_option_name' ); ?>

		<div class="wrap">
			<h2>Hylsay-Email-SMTP</h2>
			<p>Wordpress邮箱插件，评论提醒，回复提醒，纯净版本。作者：hylsay，官方网址：<a href="https://aoaoao.info" target="_blank">https://aoaoao.info</a></p>
			

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'hylsay_email_smtp_option_group' );
					do_settings_sections( 'hylsay-email-smtp-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function hylsay_email_smtp_page_init() {
		register_setting(
			'hylsay_email_smtp_option_group', // option_group
			'hylsay_email_smtp_option_name', // option_name
			array( $this, 'hylsay_email_smtp_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'hylsay_email_smtp_setting_section', // id
			'SMTP配置', // title
			array( $this, 'hylsay_email_smtp_section_info' ), // callback
			'hylsay-email-smtp-admin' // page
		);

		add_settings_field(
			'hylsay_email_smtp_server', // id
			'邮件服务器', // title
			array( $this, 'hylsay_email_smtp_server_callback' ), // callback
			'hylsay-email-smtp-admin', // page
			'hylsay_email_smtp_setting_section' // section
		);

		add_settings_field(
			'hylsay_email_smtp_port', // id
			'服务器端口', // title
			array( $this, 'hylsay_email_smtp_port_callback' ), // callback
			'hylsay-email-smtp-admin', // page
			'hylsay_email_smtp_setting_section' // section
		);

		add_settings_field(
			'hylsay_email_smtp_se c', // id
			'授权方式', // title
			array( $this, 'hylsay_email_smtp_sec_callback' ), // callback
			'hylsay-email-smtp-admin', // page
			'hylsay_email_smtp_setting_section' // section
		);

		add_settings_field(
			'hylsay_email_smtp_username', // id
			'邮箱账号', // title
			array( $this, 'hylsay_email_smtp_username_callback' ), // callback
			'hylsay-email-smtp-admin', // page
			'hylsay_email_smtp_setting_section' // section
		);

		add_settings_field(
			'hylsay_email_smtp_passwd', // id
			'邮箱密码', // title
			array( $this, 'hylsay_email_smtp_passwd_callback' ), // callback
			'hylsay-email-smtp-admin', // page
			'hylsay_email_smtp_setting_section' // section
		);
	}

	public function hylsay_email_smtp_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['hylsay_email_smtp_server'] ) ) {
			$sanitary_values['hylsay_email_smtp_server'] = sanitize_text_field( $input['hylsay_email_smtp_server'] );
		}

		if ( isset( $input['hylsay_email_smtp_port'] ) ) {
			$sanitary_values['hylsay_email_smtp_port'] = sanitize_text_field( $input['hylsay_email_smtp_port'] );
		}

		if ( isset( $input['hylsay_email_smtp_sec'] ) ) {
			$sanitary_values['hylsay_email_smtp_sec'] = sanitize_text_field( $input['hylsay_email_smtp_sec'] );
		}

		if ( isset( $input['hylsay_email_smtp_username'] ) ) {
			$sanitary_values['hylsay_email_smtp_username'] = sanitize_text_field( $input['hylsay_email_smtp_username'] );
		}

		if ( isset( $input['hylsay_email_smtp_passwd'] ) ) {
			$sanitary_values['hylsay_email_smtp_passwd'] = sanitize_text_field( $input['hylsay_email_smtp_passwd'] );
		}

		return $sanitary_values;
	}

	public function hylsay_email_smtp_section_info() {
		
	}

	public function hylsay_email_smtp_server_callback() {
		printf(
			'<input class="regular-text" type="text" name="hylsay_email_smtp_option_name[hylsay_email_smtp_server]" id="hylsay_email_smtp_server" value="%s" placeholder="填写发件服务器地址，例如：smtp.163.com">',
			isset( $this->hylsay_email_smtp_options['hylsay_email_smtp_server'] ) ? esc_attr( $this->hylsay_email_smtp_options['hylsay_email_smtp_server']) : ''
		);
	}

	public function hylsay_email_smtp_port_callback() {
		printf(
			'<input class="regular-text" type="text" name="hylsay_email_smtp_option_name[hylsay_email_smtp_port]" id="hylsay_email_smtp_port" value="%s" placeholder="填写发件服务器端口，例如：465">',
			isset( $this->hylsay_email_smtp_options['hylsay_email_smtp_port'] ) ? esc_attr( $this->hylsay_email_smtp_options['hylsay_email_smtp_port']) : ''
		);
	}

	public function hylsay_email_smtp_sec_callback() {
		printf(
			'<input class="regular-text" type="text" name="hylsay_email_smtp_option_name[hylsay_email_smtp_sec]" id="hylsay_email_smtp_sec" value="%s" placeholder="填写登录鉴权的方式，ssl 或 tls">',
			isset( $this->hylsay_email_smtp_options['hylsay_email_smtp_sec'] ) ? esc_attr( $this->hylsay_email_smtp_options['hylsay_email_smtp_sec']) : ''
		);
	}

	public function hylsay_email_smtp_username_callback() {
		printf(
			'<input class="regular-text" type="text" name="hylsay_email_smtp_option_name[hylsay_email_smtp_username]" id="hylsay_email_smtp_username" value="%s" placeholder="填写邮箱账号">',
			isset( $this->hylsay_email_smtp_options['hylsay_email_smtp_username'] ) ? esc_attr( $this->hylsay_email_smtp_options['hylsay_email_smtp_username']) : ''
		);
	}

	public function hylsay_email_smtp_passwd_callback() {
		printf(
			'<input class="regular-text" type="password" name="hylsay_email_smtp_option_name[hylsay_email_smtp_passwd]" id="hylsay_email_smtp_passwd" value="%s" placeholder="填写邮箱密码">',
			isset( $this->hylsay_email_smtp_options['hylsay_email_smtp_passwd'] ) ? esc_attr( $this->hylsay_email_smtp_options['hylsay_email_smtp_passwd']) : ''
		);
	}

}
if ( is_admin() )
	$email_smtp = new HylsayEmailSMTP();

function hylsay_hes_mail_smtp($phpmailer)
{
	$hylsay_email_smtp_options = get_option( 'hylsay_email_smtp_option_name' );
	
	$phpmailer->isSMTP();
	$phpmailer->SMTPAuth = true;
	$phpmailer->CharSet = "utf-8";
	$phpmailer->SMTPSecure = $hylsay_email_smtp_options['hylsay_email_smtp_sec'];
	$phpmailer->Port = $hylsay_email_smtp_options['hylsay_email_smtp_port'];
	$phpmailer->Host = $hylsay_email_smtp_options['hylsay_email_smtp_server'];
	$phpmailer->From = $hylsay_email_smtp_options['hylsay_email_smtp_username'];
	$phpmailer->Username = $hylsay_email_smtp_options['hylsay_email_smtp_username'];
	$phpmailer->Password = $hylsay_email_smtp_options['hylsay_email_smtp_passwd'];
}
add_action('phpmailer_init', 'hylsay_hes_mail_smtp');

function hylsay_hes_comment_approved($comment)
{
	$hylsay_email_smtp_options = get_option( 'hylsay_email_smtp_option_name' );

    if (is_email($comment->comment_author_email)) {
        $wp_email = $hylsay_email_smtp_options['hylsay_email_smtp_username'];
        $to = trim($comment->comment_author_email);
        $post_link = get_permalink($comment->comment_post_ID);
        $subject = '[通知]您的留言已经通过审核';
        $message = '
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #FFF;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">您好，' . trim($comment->comment_author) . '：</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">您的留言已经通过了管理员的审核，摘要信息如下：</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="280px;">' . __('文章', 'kratos') . '</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="270px;">' . __('内容', 'kratos') . '</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="110px;">' . __('操作', 'kratos') . '</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">《' . get_the_title($comment->comment_post_ID) . '》</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim($comment->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="' . get_comment_link($comment->comment_ID) . '" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">查看留言</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">' . date("Y年m月d日", time()) . '</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"" . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}
add_action('comment_unapproved_to_approved', 'hylsay_hes_comment_approved');

function hylsay_hes_comment_notify($comment_id)
{
	$hylsay_email_smtp_options = get_option( 'hylsay_email_smtp_option_name' );

    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = $hylsay_email_smtp_options['hylsay_email_smtp_username'];
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '[通知]您的留言有了新的回复';
        $message = '
            <div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
            <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
                    <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
                        <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #FFF;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</a></h1>
                    </div>
                <div style="padding:35px 40px 30px;">
                    <h2 style="font-size:18px;margin:5px 0;">您好，' . trim(get_comment($parent_id)->comment_author) . '：</h2>
                    <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">您的留言有了新的回复，摘要信息如下：</p>
                        <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                            <thead>
                                <tr>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">' . __('原文', 'kratos') . '</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="235px;">' . __('回复', 'kratos') . '</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="100px;">' . __('作者', 'kratos') . '</th>
                                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="90px;" >' . __('操作', 'kratos') . '</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim(get_comment($parent_id)->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim($comment->comment_content) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' . trim($comment->comment_author) . '</td>
                                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="' . get_comment_link($comment->comment_ID) . '" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">' . __('查看回复', 'kratos') . '</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
                    <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</p>
                        <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">' . date("Y年m月d日", time()) . '</span></p>
                    </div>
                </div>
            </div>
        </div>';
        $from = "From: \"" . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}
add_action('comment_post', 'hylsay_hes_comment_notify');