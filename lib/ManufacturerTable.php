<?php
namespace Ibs\shopnotebook;

use Bitrix\Main\Entity;

class ManufacturerTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'ibs_notebook_manufacturer';
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
            ])
        ];
    }
}
