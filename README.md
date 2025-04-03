# Zonelist - Amazon Bestsellers

## Run Bestsellers Importer

There are three posibilities to run the Bestsellers Importer:

1. REST call: POST {HOST}/api/bestsellers with header `X-API-KEY`
2. Cron job
3. Locally by hand: `php artisan schedule:test --name bestsellers`
