# Shortlinks Site

A small PHP script that redirects to a URL based on a keyword matched against a CSV sheet on a URL.

## Installation

1. Place files in an Apache webserver with PHP support

2. Update path to CSV file (`$csv` variable)

### NGINX

Since NGINX does not read `.htaccess` you must add a redirect into the config.

To do so add `rewrite ^/(.*)$ /index.php?link=$1 last;` at the last line of the `location / {` block. For example:

```
location / {
  try_files $uri $uri/ =404;
  rewrite ^/(.*)$ /index.php?link=$1 last;
}
```

## Usage

Line in CSV file:

> `keyword`,`destination_url`

For example:

`example`,`https://example.org`

Browse to:

> https://`YOUR_DOMAIN_NAME`/`keyword`
