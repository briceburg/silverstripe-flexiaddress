<?php

class FlexiAddressExtension extends DataExtension
{

    private static $flexiaddress_tab = 'Root.Address';

    private static $flexiaddress_insertBefore = null;

    private static $flexiaddress_addButton = 'Create New Address';

    private static $flexiaddress_fields = array(
        'StreetLine1',
        'StreetLine2',
        'City',
        'State',
        'PostalCode',
        'Country',
        'Website',
        'Email',
        'PhoneNumbers'
    );

    private static $many_many = array(
        'FlexiAddresses' => 'FlexiAddress'
    );

    private static $many_many_extraFields = array(
        'FlexiAddresses' => array(
            'SortOrder' => 'Int'
        )
    );

    public function updateCMSFields(FieldList $fields)
    {
        $enabled_fields = $this->getFlexiAddressFields();
        Config::inst()->update('FlexiAddress', 'flexiaddress_fields', $enabled_fields);

        $config = new GridFieldConfig_FlexiAddresses($enabled_fields, $this->owner);
        $component = $config->getComponentByType('GridFieldAddNewButton');
        $component->setButtonName($this->getFlexiAddressAddButton());

        $list = $this->owner->FlexiAddresses();
        $field_title = ($list->count() > 1) ? 'Addresses' : 'Address';

        $fields->addFieldToTab($this->getFlexiAddressTab(),
            new GridField('FlexiAddresses', $field_title, $list, $config),
            $this->getFlexiAddressInsertBefore());
    }

    public function getFlexiAddressTab()
    {
        return $this->lookup('flexiaddress_tab');
    }

    public function setFlexiAddressTab($tab_name)
    {
        return $this->owner->set_stat('flexiaddress_tab', $tab_name);
    }

    public function getFlexiAddressInsertBefore()
    {
        return $this->lookup('flexiaddress_insertBefore');
    }

    public function setFlexiAddressInsertBefore($field_name)
    {
        return $this->owner->set_stat('flexiaddress_insertBefore', $field_name);
    }

    public function getFlexiAddressAddButton()
    {
        return $this->lookup('flexiaddress_addButton');
    }

    public function setFlexiAddressAddButton($button_name)
    {
        return $this->owner->set_stat('flexiaddress_addButton', $button_name);
    }

    public function getFlexiAddressFields()
    {
        return $this->lookup('flexiaddress_fields', true);
    }

    public function setFlexiAddressFields($fields)
    {
        return $this->owner->set_stat('flexiaddress_fields', $fields);
    }

    private function lookup($lookup, $do_not_merge = false)
    {
        if ($do_not_merge &&
             $unmerged = Config::inst()->get($this->owner->class, $lookup, Config::EXCLUDE_EXTRA_SOURCES)) {
            return $unmerged;
        }

        return $this->owner->stat($lookup);
    }
}

