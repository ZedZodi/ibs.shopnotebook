<?php
namespace Ibs\shopnotebook;

use Bitrix\Main\Entity;

class ModelTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'ibs_notebook_model';
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
            'MANUFACTURER_ID' => new Entity\IntegerField('MANUFACTURER_ID', [
                'required' => true
            ]),
            'MANUFACTURER' => new Entity\ReferenceField(
                'MANUFACTURER',
                'Ibs\shopnotebook\ManufacturerTable',
                ['=this.MANUFACTURER_ID' => 'ref.ID']
            )
        ];
    }
}
