# Shortlinks Site

Small PHP script redirect user to a URL based on a keyword mach found in a CSV sheet found on the internet.


## Installation 

1. Place files in apache webserver with PHP support

2. Update path to CSV file (`$csv` variable)

### NGINX

Since NGINX does not read .htaccess you must add a redirect into the config

## Usage

http://`YourDomainName`/`keyword`>

## CSV Format

`keyword`,`destination_url`
ie
`example`,`https://example.org`
