# Shortlinks Site

Small PHP script redirect user to a URL based on a keyword mach found in a CSV sheet found on the internet.


## Installation 

1. Place files in apache webserver with PHP support

2. Update path to CSV file (`$csv` variable)

### NGINX

Since NGINX does not read .htaccess you must add a redirect into the config
To do so add `rewrite ^/(.*)$ /index.php?link=$1 last;` at the last line the `location / {` block.

ie
```
location / {
  try_files $uri $uri/ =404;
  rewrite ^/(.*)$ /index.php?link=$1 last;
}
```
## Usage

http://`YourDomainName`/`keyword`>

## CSV Format

`keyword`,`destination_url`
ie
`example`,`https://example.org`
