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
# Add local WordPress admin user
# 
# Username: ´localAdmin´
# Password: ´localPassword´
#######################################
add_wordpress_admin_user () {
	next_user_id=$(
	mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '${MYSQL_DATABASE}' AND TABLE_NAME = '${WORDPRESS_TABLE_PREFIX}users';
	EOF
	)

	mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	INSERT INTO ${WORDPRESS_TABLE_PREFIX}users (ID, user_login, user_pass, user_nicename, user_email, user_status, display_name) VALUES (${next_user_id}, 'localAdmin', '\$P\$BirrwinnX1hAdJpwPuyWKzqXrl3LZ31', 'localAdmin', 'localadmin@wordpress.local', 0, 'localAdmin');
	INSERT INTO ${WORDPRESS_TABLE_PREFIX}usermeta (user_id, meta_key, meta_value) VALUES (${next_user_id}, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}');
	INSERT INTO ${WORDPRESS_TABLE_PREFIX}usermeta (user_id, meta_key, meta_value) VALUES (${next_user_id}, 'wp_user_level', 10);
	EOF
}

if [ "$WORDPRESS_MULTISITE" -eq "1" ]; then
	# Initialize WordPress multisite database.
	add_wordpress_admin_user

	mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	UPDATE ${WORDPRESS_TABLE_PREFIX}blogs SET domain = '${WORDPRESS_HOST}:${WORDPRESS_PORT}';
	UPDATE ${WORDPRESS_TABLE_PREFIX}site SET domain = '${WORDPRESS_HOST}:${WORDPRESS_PORT}';
	EOF

	while read -r line; do
		siteurl=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $line WHERE option_name = 'siteurl'")
		home=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $line WHERE option_name = 'home'")

		mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
		UPDATE $line SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$(get_url_path "$siteurl")' WHERE option_name = 'siteurl';
		UPDATE $line SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$(get_url_path "$home")' WHERE option_name = 'home';
		EOF
	done < <(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME REGEXP '^${WORDPRESS_TABLE_PREFIX}(?:[0-9]+_)?options$'")
else
	# Initialize WordPress basic database.
	add_wordpress_admin_user

	mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'siteurl';
	UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'home';
	EOF
fi
