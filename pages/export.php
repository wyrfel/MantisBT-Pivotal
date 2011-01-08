<?php
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) header('WWW-Authenticate: Basic realm="Please enter username and password:"');
else if (auth_attempt_script_login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
	auth_ensure_user_authenticated();
	if (!$_GET['project']) die("missing parameters");

	require_once( 'core.php' );

	$t_core_path = config_get( 'core_path' );

	require_once( $t_core_path . 'filter_api.php' );
	require_once( $t_core_path . 'csv_api.php' );
	helper_begin_long_process();

	$t_page_number = 1;
	$t_per_page = -1;
	$t_bug_count = null;
	$t_page_count = null;
	$t_project_id = $_GET['project'];

	# Get bug rows according to the current filter
	$t_rows = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count, null, $t_project_id);
	if ( $t_rows === false ) {
		print_header_redirect( 'view_all_set.php?type=0' );
	}

	# Send headers to browser to activate mime loading
	header( 'Content-Type: text/xml');

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
 	echo "<external_stories type=\"array\">\n";

	# export the rows
	foreach ( $t_rows as $t_row ) {
		echo "<external_story>\n";
		echo "<external_id>".$t_row->id."</external_id>";
		echo "<name><![CDATA[".$t_row->summary."]]></name>";
		echo "<description><![CDATA[".$t_row->description."]]></description>";
		echo "<requested_by>".csv_format_reporter_id($t_row->reporter_id)."</requested_by>";
		echo "<created_at type=\"datetime\">".date("Y/m/d H:i:s", $t_row->date_submitted)." UTC</created_at>";
		echo "<story_type>".((get_enum_element('severity',$t_row->severity) == "feature")  ? "feature" : "bug")."</story_type>";
		echo "<estimate type=\"integer\">".(($t_row->eta-($t_row->eta%10))/10)."</estimate>";
		echo "</external_story>";
	}

	echo "</external_stories>";
} else {
	header('WWW-Authenticate: Basic realm="Wrong username or password."',true,401);
}
?>
