<?php

namespace App\Traits;

trait RequestMessages
{
    public function messages()
    {
        return [
            'title.required' => 'Поле "Название" обязательно для заполнения',
            'title.max'  => 'В поле "Название" может быть не более 100 символов',
            'title.unique'  => 'Такое название уже существует',
            'region_id.required'  => 'Не указан ID региона',
            'region_id.exists'  => 'ID региона не найден',
            'position_id.required'  => 'Не указан ID должности',
            'position_id.exists'  => 'ID должности не найден',
            'abbreviation.required' => 'Поле "Категория" обязательно для заполнения',
            'abbreviation.max' => 'В поле "Категория" может быть не более 10 символов',
            'code.required' => 'Поле "Код" обязательно для заполнения',
            'code.max' => 'В поле "Код" может быть не более 10 символов',
            'to_rate.required' => 'Поле "Оценка" обязательно для заполнения',
            'type_of_gas_station_id.required' => 'Не указан ID типа АЗС',
            'type_of_gas_station_id.exists'  => 'ID ипа АЗС не найден',
            'type_of_checklists_id.required' => 'Не указан ID типа чеклиста',
            'type_of_checklists_id.exists' => 'ID типа чеклиста не найден',
        ];
    }
}
