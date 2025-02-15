<?php
namespace Ibs\shopnotebook;

use Bitrix\Main\Entity;

class OptionTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'ibs_notebook_option';
    }

    public static function getMap()
    {
        return [
            'ID' => new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            'NAME' => new Entity\StringField('NAME', [
                'required' => true,
                'validation' => function() {
                    return [
                        new Entity\Validator\Length(null, 255)
                    ];
                }
            ]),
            'NOTEBOOK_ID' => new Entity\IntegerField('NOTEBOOK_ID', [
                'required' => true
            ]),
            'NOTEBOOK' => new Entity\ReferenceField(
                'NOTEBOOK',
                'Ibs\shopnotebook\NotebookTable',
                ['=this.NOTEBOOK_ID' => 'ref.ID']
            )
        ];
    }
}
