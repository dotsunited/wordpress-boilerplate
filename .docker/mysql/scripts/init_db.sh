#!/bin/bash
#
# Initialize the WordPress database.

# Set MySQL password environment variable.
export MYSQL_PWD="$MYSQL_PASSWORD"

#######################################
# Extract URL path.
# Arguments:
#   URL
# Outputs:
#   URL path
#######################################
get_url_path () {
	protocol="$(echo $1 | grep :// | sed -e's,^\(.*://\).*,\1,g')"
	url="$(echo ${1/$protocol/})"
	path="$(echo $url | grep / | cut -d/ -f2-)"

	if [ ! -z "$path" ]; then
		echo /$path
	fi
}

#######################################
# Set WordPress user password or create
# one if it does not exist.
#######################################
set_wordpress_admin_user () {
	user_exists=$(
    mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
    SELECT COUNT(1) FROM ${WORDPRESS_TABLE_PREFIX}users WHERE user_login = 'dotsunited';
	EOF
	)

	if [ "$user_exists" -eq "1" ]; then
		mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
		UPDATE ${WORDPRESS_TABLE_PREFIX}users SET user_pass = '\$P\$BjclDNhNxwUtHZNXByFaADVWzR7Bg21' WHERE user_login = 'dotsunited';
		EOF
	else
		mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
		INSERT INTO ${WORDPRESS_TABLE_PREFIX}users (ID, user_login, user_pass, user_nicename, user_email, user_status, display_name) VALUES (99999, 'dotsunited', '\$P\$BjclDNhNxwUtHZNXByFaADVWzR7Bg21', 'dotsunited', 'info@dotsunited.de', 0, 'dotsunited');
		INSERT INTO ${WORDPRESS_TABLE_PREFIX}usermeta (user_id, meta_key, meta_value) VALUES (99999, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}');
		INSERT INTO ${WORDPRESS_TABLE_PREFIX}usermeta (user_id, meta_key, meta_value) VALUES (99999, 'wp_user_level', 10);
		EOF
	fi
}

if [ "$WORDPRESS_MULTISITE" -eq "1" ]; then
	# Initialize WordPress multisite database.
	set_wordpress_admin_user

    mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	UPDATE ${WORDPRESS_TABLE_PREFIX}blogs SET domain = '${WORDPRESS_HOST}:${WORDPRESS_PORT}';
	UPDATE ${WORDPRESS_TABLE_PREFIX}site SET domain = '${WORDPRESS_HOST}:${WORDPRESS_PORT}';
	EOF

    while read -r line; do
		if [[ "$line" =~ "$WORDPRESS_TABLE_PREFIX"([0-9]+_)?options ]]; then
			siteurl=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $line WHERE option_name = 'siteurl'")
			home=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $line WHERE option_name = 'home'")

			mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
			UPDATE $line SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$(get_url_path "$siteurl")' WHERE option_name = 'siteurl';
			UPDATE $line SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$(get_url_path "$home")' WHERE option_name = 'home';
			EOF
		fi
	done < <(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '"$MYSQL_DATABASE"'")
else
	# Initialize WordPress basic database.
	set_wordpress_admin_user

    mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
    UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'siteurl';
    UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'home';
	EOF
fi
