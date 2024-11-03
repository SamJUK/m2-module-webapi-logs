# GhostUnicorns_WebapiLogs

> 🔔 This module is a fork of [GhostUnicorns_WebapiLogs](https://github.com/ghostunicorns/module-webapi-logs). It adds additional functionality to meet the needs of running in production on Medium to Large stores.

This module logs inbound REST API calls to the database, and provide visualisation within the Admin Panel. 

Works best on Small -> Medium sized stores, for Large / Enterprise stores I recommend logging at the proxy level and ingesting into your observability suite.

## Changes
This fork implements a few additional features to the module to meet the needs of running in production on Medium to Large stores.
- Optimisation the clean up routines.
- Added User Agent to the Grid & Filters
- Ability to filter incoming requests based on whitelists to reduce database usage.
    - Toggle Ajax (Checkout/Personal Data etc)
    - Filter based on User Agent Whitelist
    - Filter based on Client IP Whitelist
    - Filter based on Request URI Segments Whitelist
    - Filter based on HTTP Method Whitelist

## Installation

Installing the module requires adding a composer repository linking to this repository.

```sh
# Configure the repository
composer config repositories.ghostunicorns/module-webapi-logs vcs https://github.com/SamJUK/m2-module-webapi-logs

# Install the module
composer require ghostunicorns/module-webapi-logs
```

## Configuration

Recommended approach is to leave disabled by default, and enable with aggressive filtering when you are actively debugging issues.

1. Log-in your Magento backend

2. Go to `Stores > Configuration > System > Webapi Logs` and enable it

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen1.png" />

### 🚨 Attention!

If you disable the Secret Mode this module will logs everything passes in the webapi calls (tokens and passwords too!), then remember to clean logs by clicking the `Delete All Logs` button:

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen4.png" />


## Usage

Go to `Reports > Webapi Logs > Show Logs`

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen2.png" />

You can select an entry to see more details about the request and the response

<img src="https://github.com/ghostunicorns/module-webapi-logs/blob/main/screenshots/screen3.png" />