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
            'role_id.required' => 'Не указан ID роли',
            'role_id.exists' => 'ID роли не найден',
            'number.required' => 'Не заполнен номер',
            'number.max' => 'Номер может быть не более 10 символов',
            'number.unique' => 'Такой номер уже существует',
            'address.required' => 'Не заполнен адрес',
            'address.max' => 'Адрес может быть не более 500 символов',
            'is_shop.required' => 'Не указано наличие магазина',
            'it_works.required' => 'Не указано работает ли АЗС',
            'dir_name.required' => 'Не указано имя диретора',
            'dir_name.max' => 'Имя директора не может быть более 20 символов',
            'dir_patronymic.required' => 'Не указано отчество директора',
            'dir_patronymic.max' => 'Отчество диретора не может быть более 20 символов',
            'dir_surname.required' => 'Не указана фамилия директора',
            'dir_surname.max' => 'Фамилия диреткора не может быть более 20 символов',
            'email.required' => 'Не указан email АЗС',
            'email.max' => 'Email не может быть более 50 символов',
            'phone.required' => 'Не указан телефон АЗС',
            'phone.max' => 'Телефон не может быть более 20 символов',
        ];
    }
}
