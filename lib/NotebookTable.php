<?php
namespace Ibs\shopnotebook;

use Bitrix\Main\Entity;

class NotebookTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'ibs_notebook_laptop';
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
            'YEAR' => new Entity\IntegerField('YEAR', [
                'required' => true
            ]),
            'PRICE' => new Entity\FloatField('PRICE', [
                'required' => true
            ]),
            'MODEL_ID' => new Entity\IntegerField('MODEL_ID', [
                'required' => true
            ]),
            'MODEL' => new Entity\ReferenceField(
                'MODEL',
                'Ibs\shopnotebook\ModelTable',
                ['=this.MODEL_ID' => 'ref.ID']
            ),
            'OPTIONS' => new Entity\ReferenceField(
                'OPTIONS',
                'Ibs\shopnotebook\OptionTable',
                ['=this.ID' => 'ref.LAPTOP_ID']
            )
        ];
    }
}
