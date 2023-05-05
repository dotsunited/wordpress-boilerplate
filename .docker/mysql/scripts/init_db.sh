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
# Extract blog id.
# Arguments:
#   table name
# Outputs:
#   id
#######################################
get_blog_id() {
	id="$(echo $1 | sed -e 's/wp_\([0-9]\+\)_options/\1/')"

	if [ "wp_options" = "$id" ]; then
		echo 1
	else
		echo $id
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
	INSERT INTO ${WORDPRESS_TABLE_PREFIX}usermeta (user_id, meta_key, meta_value) VALUES (${next_user_id}, 'nickname', 'localAdmin');
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

	blogs=()

	while read -r line; do
		blogs+=( "$line" )
		echo "Found blog: ${line/%"_options"}"
	done < <(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME REGEXP '^${WORDPRESS_TABLE_PREFIX}(?:[0-9]+_)?options$'")

	echo "Found ${#blogs[@]} blogs in total."

	for blog in "${blogs[@]}"; do
		id=$(get_blog_id "$blog")
		siteurl=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $blog WHERE option_name = 'siteurl'")
		home=$(mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s -e "SELECT option_value FROM $blog WHERE option_name = 'home'")
        path_found=false

        while read -d, -r pair; do
            IFS='=' read -r key val <<<"$pair"

            if [ "$key" = "$id" ]; then
                echo "Using path $val for blog with id $id."

                path_found=true
                path="/$val"
                blogpath="/$val/"

                break
            fi
        done <<<"$WORDPRESS_MULTISITE_PATHS,"

        if [ "$path_found" = false ]; then
            echo "No configuration for blog with id $id found. Using default path."

            if [ "1" = "$id" ]; then
                path=""
                blogpath="/"
            else
                path="/$id"
                blogpath="/$id/"
            fi
        fi

		echo "Updating blog with id $id from $siteurl to http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$path)"

		mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	    UPDATE ${WORDPRESS_TABLE_PREFIX}blogs SET path = '$blogpath' WHERE blog_id = $id;
		UPDATE $blog SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$path' WHERE option_name = 'siteurl';
		UPDATE $blog SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}$path' WHERE option_name = 'home';
		EOF
	done
else
	# Initialize WordPress basic database.
	add_wordpress_admin_user

	mysql -u"$MYSQL_USER" "$MYSQL_DATABASE" -s <<-EOF
	UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'siteurl';
	UPDATE ${WORDPRESS_TABLE_PREFIX}options SET option_value = 'http://${WORDPRESS_HOST}:${WORDPRESS_PORT}' WHERE option_name = 'home';
	EOF
fi
