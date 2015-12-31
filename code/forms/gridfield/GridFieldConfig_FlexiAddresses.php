<?php

class GridFieldConfig_FlexiAddresses extends GridFieldConfig
{

    public function __construct($enabled_fields)
    {
        $this->addComponent(new GridFieldButtonRow('before'));
        $this->addComponent(new GridFieldAddNewButton('buttons-before-left'));
        $this->addComponent(new GridFieldAddExistingSearchButton('buttons-before-right'));
        $this->addComponent(new GridFieldToolbarHeader());
        $this->addComponent(new GridFieldTitleHeader());
        $this->addComponent(new GridFieldDataColumns());
        $this->addComponent(new GridFieldEditButton());
        $this->addComponent(new GridFieldDeleteAction(true));
        $this->addComponent(new GridFieldDetailForm());


        // Sort Order
        // ///////////
        $this->addComponent(new GridFieldOrderableRows('SortOrder'));


        /*
        // Display Fields
        /////////////////


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

        $component = $this->getComponentByType('GridFieldDataColumns');
        $component->setDisplayFields($fields);


        // Limit Edit Fields
        ////////////////////
        $closure = function ($form, $item_request) use($enabled_fields)
        {

            // also allow XSS field
            $enabled_fields[] = 'SecurityID';

            $fields = $form->Fields();

            foreach ($fields->dataFields() as $field) {
                if (! in_array($field->getName(), $enabled_fields)) {
                    $fields->removeByName($field->getName());
                }
            }
        };

        $component = $this->getComponentByType('GridFieldDetailForm');
        $component->setItemEditFormCallback($closure);


        // Limit Search Fields
        //////////////////////

        $search_fields = array();
        foreach($enabled_fields as $field_name){

        }
        */
    }
}
