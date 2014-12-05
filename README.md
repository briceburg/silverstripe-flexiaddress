silverstripe-flexiaddress
=========================

Add microdata friendly addresses and phone numbers to your SilverStripe objects. 

Features
--------

* schema.org microdata templating
* extend any DataObject 
* reduces administrative repetitiveness and improves consistency through **many_many** relationships
* extensible through [YAML Configuration](http://doc.silverstripe.org/framework/en/topics/configuration) and subclassing


Requirements
------------

The venerable GridFieldExtensions https://github.com/ajshort/silverstripe-gridfieldextensions

Tested in SilverStripe 3.1

Screenshots
-----------

![editing](https://github.com/briceburg/silverstripe-flexiaddress/blob/master/docs/screenshots/flexiaddress_1.jpg?raw=true)

![list](https://github.com/briceburg/silverstripe-flexiaddress/blob/master/docs/screenshots/flexiaddress_2.jpg?raw=true)


Usage 
=====

* Add address and phone numbers to your Objects by extending them with
`FlexiAddressExtension`.  E.g.

```php
class Office extends Page
{

    private static $extensions = array(
        'FlexiAddressExtension'
    );

}
```

* Trigger the environment builder (/dev/build) after extending your objects --
You will now see the Address tab when editing Office in the CMS.

### Front-end

FlexiAddress provides a shortcut to return the _first address_ associated.
Here's an example Office.ss

```html
```html
<div itemscope itemtype="http://schema.org/LocalBusiness" id="office">
  <h1>$Title</h1>

  ...
  
  $FlexiAddress
  
  <div class="office-phone-numbers">
    <% loop FlexiAddress.PhoneNumbers %>
      <% include FlexiAddressPhone %>
    <% end_loop %>
  </div>
  
  ...

</div>
```


You can also loop through aqddresses. Here's an example Office.ss

```html
<div itemscope itemtype="http://schema.org/LocalBusiness" id="office">

  <h1>$Title</h1>

  ... 
  
  <% loop FlexiAddresses %>

    <h2>Address</h2>
    <% include FlexiAddress %> 
    
    <a href="$AddressMapLink" target="_blank" class="directions font-opensans">
      Get Directions
    </a> 
      
    <% loop PhoneNumbers %> 
      <% include FlexiAddressPhone %> 
    <% end_loop %> 
  <% end_loop %> 
  
  ... 
  
</div>

```


You may, as always, override the [built-in templates](https://github.com/briceburg/silverstripe-flexiaddress/tree/master/templates) by
adding them to your theme and changing markup as needed.


### Limiting Fields

You may find the built-in address fields a bit too much. Here's a few strategies
to limit them;

* Strategy 1: Globally via mysite/config/config.yml

```yaml
---

FlexiAddressExtension:
  flexiaddress_fields:
    - StreetLine1
    - City
    - PhoneNumbers
```

* Strategy 2: Via the **$flexiaddress_fields** property on extended classes

```php

class Office extends Page
{

    protected static $flexiaddress_fields = array(
        'StreetLine1',
        'City',
        'PhoneNumbers'
    );
}
```

* Strategy 3: Via [YAML Configuration](http://doc.silverstripe.org/framework/en/topics/configuration) of extended classes

```yaml
---

Office:
  flexiaddress_fields:
    - StreetLine1
    - City
    - PhoneNumbers
```

### Changing the Address Tab Name

By default, flexiaddress adds its GridField to the _Root.Address_ tab. You
can configure this in a couple of ways;

* Strategy 1: Via [YAML Configuration](http://doc.silverstripe.org/framework/en/topics/configuration)

```yaml
---

# Global Change
FlexiAddressExtension:
  flexiaddress_tab: Root.Addresses
  
# Class Specific
Office:
  flexiaddress_tab: Root.Main
  flexiaddress_insertBefore: Content

```
 
* Strategy 2: Through your extended class
 
```php

class Office extends Page
{

    // Option 1 - properties
    ////////////////////////
    
    protected static $flexiaddress_tab = 'Root.Main';
    protected static $flexiaddress_insertBefore = 'Content';
   
    // Option 2 - via Config::inst()->update
    ////////////////////////////////////////
    
    public function getCMSFields()
    {
        $this->set_stat('flexiaddress_tab', 'Root.Addresses');
        return parent::getCMSFields();
    }
   
}
```

### Changing the Add New GridField Button

If you don't like "Create New Address", follow the _Changing the Address Tab Name_
procecedure, but alter the **flexiaddress_addButton** propperty.


 