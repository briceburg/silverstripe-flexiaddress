<?php

class FlexiAddressPhone extends DataObject
{

    private static $db = array(
        'Telephone' => 'Varchar',
        'Label' => 'Varchar',
        'MetaType' => 'Enum(array("customer support","technical support","bill payment","sales","reservations","emergency"))',
        'MetaFax' => 'Boolean',
        'MetaTollFree' => 'Boolean',
        'SortOrder' => 'Int'
    );

    private static $has_one = array(
        'FlexiAddress' => 'FlexiAddress'
    );

    private static $summary_fields = array(
        'toString' => 'Number',
        'MetaType' => 'Meta Type',
        'MetaFax.Nice' => 'Is Fax',
        'MetaTollFree.Nice'=> 'Is Toll Free'
    );

    private static $default_sort = 'SortOrder';

    public function getCMSFields()
    {
        $fields = singleton('DataObject')->getCMSFields();

        $type_map = $this->dbObject('MetaType')->enumValues();

        $group = FieldGroup::create(
             FieldGroup::create(
                 TextField::create('Telephone', 'Phone Number'),
                 CheckboxField::create('MetaFax', 'Is Fax'),
                 CheckboxField::create('MetaTollFree', 'Toll Free')
             ),
             FieldGroup::create(
                 TextField::create('Label', 'Label (optional)')
             ),
            FieldGroup::create(
            DropdownField::create('MetaType', 'Meta Type', $type_map)

            )
         );

        $fields->addFieldToTab('Root.Main', $group);

        return $fields;
    }

    // @todo limplement internationalizetion of phone number
    public function IntlTelephone()
    {
        return $this->Telephone;
    }

    public function toString()
    {
        return ($this->Label) ? $this->Telephone . ' (' . $this->Label . ')' : $this->Telephone;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
