<?php

class GridFieldConfig_FlexiAddressPhones extends GridFieldConfig
{

    public function __construct()
    {
        $this->addComponent(new GridFieldButtonRow('before'));
        $this->addComponent(new GridFieldAddNewInlineButton('buttons-before-left'));
        $this->addComponent(new GridFieldToolbarHeader());
        $this->addComponent(new GridFieldTitleHeader());
        $this->addComponent(new GridFieldEditableColumns());
        $this->addComponent(new GridFieldDeleteAction(false));

        $component = $this->getComponentByType('GridFieldAddNewInlineButton');
        $component->setTitle('Add Phone Number');

        $component = $this->getComponentByType('GridFieldEditableColumns');

        $component->setDisplayFields(
            array(
                'Telephone' => array(
                    'title' => 'Phone Number',
                    'field' => 'TextField'
                ),
                'Label' => array(
                    'title' => 'Label (optional)',
                    'field' => 'TextField'
                ),
                'MetaFax' => array(
                    'title' => 'Is Fax?',
                    'field' => 'CheckboxField'
                ),
                'MetaTollFree' => array(
                    'title' => 'Is Toll Free?',
                    'field' => 'CheckboxField'
                ),
                'MetaType' => array(
                    'title' => 'Meta Type',
                    'callback' => function ($record, $column_name, $grid) {
                        $source = singleton('FlexiAddressPhone')->dbObject('MetaType')
                            ->enumValues();
                        return new DropdownField($column_name, 'Meta Type', $source);
                    }
                )
            ));

        // Sort Order
        // ///////////
        $this->addComponent(new GridFieldOrderableRows('SortOrder'));
    }
}
