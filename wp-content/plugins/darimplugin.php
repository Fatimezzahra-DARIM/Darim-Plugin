<?php
/*
Plugin Name:  DARIM plugin
Plugin URI: http://www.exemple.com
Description: je suis une apprenante a Youcode et c'est mon 1er plugin 
Version: 1.0
Author: Fatimezzahra DARIM
Author URI: http://www.darim.com
*/

// Ajouter le menu du plugin dans l'administration
add_action('admin_menu', 'mon_plugin_menu');
function mon_plugin_menu()
{
	add_menu_page('DARIM plugin', 'DARIM plugin', 'manage_options', 'mon-plugin', 'mon_plugin_page', 'dashicons-admin-plugins');
	add_action('wp_dashboard_setup', 'mon_plugin_add_dashboard_widget');

}
// function mon_plugin_menu()
// {
// 	add_menu_page('DARIM plugin', 'DARIM plugin', 'manage_options', 'mon-plugin', 'mon_plugin_page', 'dashicons-admin-plugins');

// 	add_action('wp_dashboard_setup', 'mon_plugin_add_dashboard_widget');
// }

// function mon_plugin_menu()
// {
// 	add_menu_page('DARIM plugin', 'DARIM plugin', 'manage_options', 'mon-plugin', 'mon_plugin_page', 'dashicons-admin-plugins');
// }
// Ajouter la page de paramètres du plugin
function mon_plugin_page()
{
?>
	<div class="wrap">
		<h1>Darim plugin</h1>
		<form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="darim-plugin-form">
			<input type="hidden" name="action" value="mon_plugin_submit_form">
			<!-- <form method="post" action="" class="darim-plugin-form"> -->
				<div>
					<label for="nom">Nom :</label>
					<input class="inpt" type="text" name="nom" id="nom" >
				</div>
				<div>
					<label for="email">Email :</label>
					<input class="inpt" type="email" name="email" id="email" >
				</div>
				<div>
					<label for="sujet">Sujet :</label>
					<input class="inpt" type="text" name="sujet" id="sujet" >
				</div>
				<div class="msg-textre">
					<label for="message">Message :</label>
					<textarea class="darim-plugin-message" name="message" id="message" cols="30" rows="10" ></textarea><br><br>
				</div>
				<button type="submit" name="submit" value="Envoyer">Envoyer</button>
			</form>
	</div>
<?php
}

// Ajouter la validation du formulaire avec des regex
add_action('init', 'mon_plugin_validation');
function mon_plugin_validation()
{
	if (isset($_POST['submit'])) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mon_plugin_messages';
		$nom = sanitize_text_field($_POST['nom']);
		$email = sanitize_email($_POST['email']);
		$sujet = sanitize_text_field($_POST['sujet']);
		$message = wp_kses_post($_POST['message']);

		if (!preg_match('/^[a-zA-Z0-9 ]+$/', $nom)) {
			wp_die('Le nom est invalide.');
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			wp_die('L\'email est invalide.');
		}
		if (!preg_match('/^[a-zA-Z0-9 ]+$/', $sujet)) {
			wp_die('Le sujet est invalide.');
		}
		if (!preg_match('/^[a-zA-Z0-9,.!?\n\r ]+$/', $message)) {
			wp_die('Le message est invalide.');
		}

		// Insérer les données dans la base de données
		$wpdb->insert(
			$table_name,
			array(
				'nom' => $nom,
				'email' => $email,
				'sujet' => $sujet,
				'message' => $message,
			)
		);

		// Envoyer le message
		wp_mail('votre@email.com', $sujet, $message);
		echo '<div class="notice notice-success is-dismissible"><p>Votre message a bien été envoyé.</p></div>';
	}
}
// Ajouter widget
function mon_plugin_dashboard_widget()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'mon_plugin_messages';
	$results = $wpdb->get_results("SELECT * FROM $table_name");

	if (!empty($results)) {
		echo '<table class="wp-list-table widefat fixed striped">';
		echo '<thead><tr>';
		echo '<th>' . __('ID', 'mon-plugin') . '</th>';
		echo '<th>' . __('Name', 'mon-plugin') . '</th>';
		echo '<th>' . __('Email', 'mon-plugin') . '</th>';
		echo '<th>' . __('Subject', 'mon-plugin') . '</th>';
		echo '<th>' . __('Message', 'mon-plugin') . '</th>';
		echo '<th>' . __('Date', 'mon-plugin') . '</th>';
		echo '</tr></thead><tbody>';

		foreach ($results as $row) {
			echo '<tr>';
			echo '<td>' . $row->id . '</td>';
			echo '<td>' . $row->nom . '</td>';
			echo '<td>' . $row->email . '</td>';
			echo '<td>' . $row->sujet . '</td>';
			echo '<td>' . $row->message . '</td>';
			echo '<td>' . $row->date . '</td>';
			echo '</tr>';
		}

		echo '</tbody></table>';
	} else {
		echo '<p>' . __('No messages found.', 'mon-plugin') . '</p>';
	}
}



function mon_plugin_add_dashboard_widget()
{
	wp_add_dashboard_widget('mon_plugin_dashboard_widget', 'DARIM Plugin Messages', 'mon_plugin_dashboard_widget');
}



// Ajouter le style CSS du plugin
add_action('admin_enqueue_scripts', 'mon_plugin_style');
function mon_plugin_style()
{
	wp_enqueue_style('mon-plugin-style', plugins_url('/style.css', __FILE__));
}

// Ajouter la sécurité au plugin
add_action('plugins_loaded', 'mon_plugin_security');
function mon_plugin_security()
{
	if (!current_user_can('manage_options')) {
		wp_die('Accès interdit.');
	}
}

// Ajouter l'intégration via shortcode
add_shortcode('mon_plugin', 'mon_plugin_shortcode');
function mon_plugin_shortcode()
{
	ob_start();
	mon_plugin_page();
	return ob_get_clean();
}

// Créer la table du plugin dans l'activation
register_activation_hook(__FILE__, 'mon_plugin_activation');
function mon_plugin_activation()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'mon_plugin_messages';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		nom varchar(255) NOT NULL,
		email varchar(255) NOT NULL,
		sujet varchar(255) NOT NULL,
		message text NOT NULL,
		date datetime NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
//function pour supprimer la table du plugin 
register_deactivation_hook(__FILE__, 'mon_plugin_deactivation');
function mon_plugin_deactivation()
{
	global $wpdb;

	$table_name = $wpdb->prefix . 'mon_plugin_messages';

	$wpdb->query("DROP TABLE IF EXISTS $table_name");
}
