<?php

class FlexiAddress extends DataObject
{
    private static $template = null;

    private static $db = array(
        'StreetLine1' => 'Varchar',
        'StreetLine2' => 'Varchar',
        'City' => 'Varchar',
        'State' => 'Varchar',
        'PostalCode' => 'Varchar',
        'Country' => 'Varchar',
        'Website' => 'ExternalURL',
        'Email' => 'Varchar'
    );

    private static $has_many = array(
        'PhoneNumbers' => 'FlexiAddressPhone'
    );

    private static $searchable_fields = array(
        'StreetLine1' => array(
            'field' => 'TextField',
            'filter' => 'PartialMatchFilter',
            'title' => 'Street Line 1'
        ),
        'Country' => array(
            'field' => 'CountryDropdownField'
        )
    );

    public function summaryFields()
    {
        $enabled_fields = $this->getEnabledFields();

        $fields = array(
            'toString' => 'Address'
        );

        if (in_array('Website', $enabled_fields)) {
            $fields['Website'] = 'Website';
        }

        if (in_array('Email', $enabled_fields)) {
            $fields['Email'] = 'Email';
        }

        if (in_array('PhoneNumbers', $enabled_fields)) {
            $fields['phoneNumbersToString'] = 'Phone Numbers(s)';
        }

        return $fields;
    }

    public function getCMSFields()
    {
        $fields = singleton('DataObject')->getCMSFields();

        $enabled_fields = $this->getEnabledFields();

        if (in_array('PhoneNumbers', $enabled_fields)) {
            $fields->addFieldToTab('Root.Main',
                new GridField('PhoneNumbers', 'Phone Numbers', $this->PhoneNumbers(),
                    new GridFieldConfig_FlexiAddressPhones()));
        }

        foreach ($this->db() as $field_name => $field_type) {
            if (in_array($field_name, $enabled_fields)) {
                $fields->addFieldToTab('Root.Main', $this->getFieldForName($field_name));
            }
        }
        
        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function searchableFields()
    {
        $search_fields = $this->stat('searchable_fields');
        $enabled_fields = $this->getEnabledFields();
        $fields = array();

        foreach ($search_fields as $field_name) {
            if (!in_array($field_name, $enabled_fields)) {
                continue;
            }

            $field_instance = $this->getFieldForName($field_name);

            $fields[$field_name] = array(
                'title' => $field_instance->Title(),
                'field' => $field_instance->class,
                'filter' => ($field_instance->is_a('DropdownField')) ? 'ExactMatchFilter' : 'PartialMatchFilter',
            );
        }

        return $fields;
    }

    public function getFieldForName($field_name)
    {
        $field_title = preg_replace('/(?<=\\w)(?=[A-Z])/', ' $1', $field_name);

        switch ($field_name) {
            case 'Country':
                $field = new CountryDropdownField($field_name, $field_title);
                break;

            case 'State':
                $field = (class_exists('USStateDropdownField')) ?
                    new USStateDropdownField($field_name, $field_title) :
                    new TextField($field_name, $field_title);

                break;

            case 'Email':
                $field = new EmailField($field_name, $field_title);
                break;

            default:
                $field = new TextField($field_name, $field_title);
                break;
        }

        return $field;
    }

    public function getEnabledFields()
    {
        if (! $fields = $this->stat('flexiaddress_fields')) {
            $fields = Config::inst()->get('FlexiAddressExtension', 'flexiaddress_fields');
        }
        return $fields;
    }

    public function getTemplate()
    {
        return ($this->stat('template')) ?  : $this->ClassName;
    }

    public function setTemplate($template)
    {
        $this->set_stat('template', $template);
    }

    public function FullStateName()
    {
        if ($state = $this->State) {
            return (class_exists('USStateDropdownField')) ?
                USStateDropdownField::$states[$this->State] :
                $this->State;
        }
    }

    public function AddressMapLink()
    {
        return 'https://maps.google.com/?q=' . $this->toString();
    }

    public function toString($with_phones = false)
    {
        $fields = array(
            'StreetLine1',
            'StreetLine2',
            'City',
            'State',
            'PostalCode'
        );

        $params = array();

        foreach ($fields as $field) {
            if (! empty($this->$field)) {
                $params[] = $this->$field;
            }
        }

        if ($with_phones) {
            foreach ($this->PhoneNumbers() as $phone) {
                $params[] = $phone->toString();
            }
        }

        return implode(',', $params);
    }

    public function phoneNumbersToString()
    {
        $phones = array();
        foreach ($this->PhoneNumbers() as $number) {
            $phones[] = $number->toString();
        }

        return implode(', ', $phones);
    }

    public function forTemplate()
    {
        return $this->renderWith(
            array(
                $this->getTemplate(),
                'FlexiAddress'
            ));
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function getTitle()
    {
        return $this->toString(false);
    }
}
