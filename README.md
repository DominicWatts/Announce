# Announce

![phpcs](https://github.com/DominicWatts/Announce/workflows/phpcs/badge.svg)

![PHPCompatibility](https://github.com/DominicWatts/Announce/workflows/PHPCompatibility/badge.svg)

![PHPStan](https://github.com/DominicWatts/Announce/workflows/PHPStan/badge.svg)


## Magento 2 site-wide customer facing announcements

Easily add personalised customer messages to your magento store. Customised greetings, discounts, upsells and more. Find the comment for the placeholder code in markup and go from there.

With marketing section in backend configure message groups with the following:

    * Required

  - Name *
  - Position in site
  - CSS class
  - Status * 
  - Store View * 
  - Only visible to customer email
  - Only visible to customer group
  - Visible date from
  - Visible date to
  - Sort
  - Limit
  - Message sort by *

Then attach one or more messages to this group with the following:

    * Required

  - Name *
  - CSS class
  - Sort
  - Associated Group ID *
  - Status *
  - Content

Messages are rendered on the frontend based on configuration.

I use magento registry to restrict impatch of queries.

### Todo

  - ~~Custom placement logic / help doc~~
  - ~~Contact Us placement~~
  - ~~Wysiwyg template filter~~
  - ~~Admin group message selection grid ~~
  - Use admin group message grid to change selection and/or sort
  - Group visible only on selected category
  - Group visible only on selected product
  - ~~Random message sort~~
  - ~~Message limit~~
  - ~~Mass status / mass delete~~
  - ~~Escape phtml~~
  - Catch impressions
  - Extension own cache
  - Private content (hole punch cache)
  - [Long term] Banner manager
  - [Long term] Product carousels for upsells/cross sells/related

## Install Instructions

`composer require dominicwatts/announce`

`php bin/magento setup:upgrade`

`php bin/magento setup:di:compile`

`php bin/magento setup:static-content:deploy`

## Useage Instructions

    Admin > Marketing > Announcements

![Group Grid](https://i.snipboard.io/CfTWVw.jpg)

![Group Page](https://i.snipboard.io/4KxMJl.jpg)

![Message Page](https://i.snipboard.io/WtZTbS.jpg)

![Contact Us](https://i.snipboard.io/1AE5ax.jpg)