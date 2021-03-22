# Shortlinks Site

A small PHP script that redirects to a URL based on a keyword matched against a CSV sheet on a URL.

## Installation

1. Place files in an NGINX webserver with PHP support

2. Update path to CSV file (`$csv` variable)

### NGINX

Since NGINX does not read `.htaccess` you must add a redirect into the config. (This is done for you when deploying with this [Ansible playbook](https://github.com/hyphacoop/ansibles/blob/master/deploy-hypha-sites/deploy-site-link.hypha.coop.yml))

To do so add `rewrite ^/(.*)$ /index.php?link=$1 last;` at the last line of the `location / {` block. For example:

```
location / {
	try_files $uri $uri/ =404;
	rewrite ^/(.*)$ /redir.php?link=$1 last;
}
```

## Usage

Line in CSV file:

> `keyword`,`destination_url`

For example:

`example`,`https://example.org`

Browse to:

> https://`link.hypha.coop`/`keyword`

For tips on managing and using these shortlinks,
see the [Shortlink Guides](https://handbook.hypha.coop/guides.html#shortlinks) in Hypha's Handbook.

## Deploying
We use this [Ansible playbook](https://github.com/hyphacoop/ansibles/blob/master/deploy-hypha-sites/deploy-site-link.hypha.coop.yml) to configure our reverse proxy and web server vhosts which also creates the directory to store the site files.

Once the playbook is done we can now deploy the site files using Travis CI with the `deploy` user's SSH key.

`staging` branch deploys to the staging server accessible here: https://link.staging.hypha.coop

`master` branch deploys to the production site.
